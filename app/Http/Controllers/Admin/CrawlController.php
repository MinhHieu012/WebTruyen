<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Jobs\CrawlStoryJob;
use App\Models\Story;
use App\Repositories\Author\AuthorRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Chapter\ChapterRepository;
use App\Repositories\Chapter\ChapterRepositoryInterface;
use App\Repositories\Story\StoryRepositoryInterface;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class CrawlController extends Controller
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        protected AuthorRepositoryInterface $authorRepository,
        protected ChapterRepositoryInterface $chapterRepository,
        protected StoryRepositoryInterface $storyRepository
        // protected Stor
        // protected UserRepositoryInterface $repository,
        // protected UserService             $service
    ) {
        $this->middleware('can:xem_crawl_data')->only('index', 'store');
    }

    public function index(Request $request)
    {
        $search        = $request->get('search', []);

        $data = [];

        return view('Admin.pages.crawl.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'link_crawl_from' => 'required',
            'link_crawl_to' => 'required',
        ], [], [
            'link_crawl_from' => 'Link trang đầu',
            'link_crawl_to' => 'Link trang cuối',
        ]);
        
        $res = ['success' => false];
        Artisan::call('app:crawl-story', [
            'linkCrawlFrom' => $request->input('link_crawl_from'), 'linkCrawlTo' => $request->input('link_crawl_to')
        ]);

        $res['success'] = true;
        return response()->json($res);
        return redirect()->route('admin.story.index')->with('successMessage', 'Thêm mới truyện thành công');

        set_time_limit(100);

        $client = new Client();

        preg_match('/trang-(\d+)/', $request->input('link_crawl_from'), $matches);
        $fromPaginate = $matches[1];

        preg_match('/trang-(\d+)/', $request->input('link_crawl_to'), $matches);
        $toPaginate = $matches[1];
        // dd($toPaginate);

        $crawler = $client->request('GET', $request->input('link_crawl_from'));

        $htmlString = $crawler->getBody()->getContents();
        $baseUrl = $request->input('link_crawl_from');

        $crawler = new Crawler($htmlString, $baseUrl);

        $storyName = $crawler->filter('.title')->text();
        $storyDesc = $crawler->filter('.desc-text')->html();
        $storyAuthor = $crawler->filter('a[itemprop="author"]')->text();
        $storyCategories = $crawler->filter('div.info a[itemprop="genre"]');
        $storyIsFull = '';
        if ($crawler->filter('.text-success')->getNode(0)) {
            $storyIsFull = $crawler->filter('.text-success')->text();
        } else {
            if ($crawler->filter('.text-primary')->getNode(0)) {
                $storyIsFull = $crawler->filter('.text-primary')->text();
            }
        }
        $storyImage = $crawler->filter('.book img')->image();
        // dd($storyImage->getUri());

        $pathImage = $this->downloadImages($storyImage->getUri(), Str::slug(strtolower($storyName), '_'));

        $dataStory = [
            'image' => $pathImage,
            'slug' => Str::slug($storyName),
            'name' => $storyName,
            'desc' => $storyDesc,
            'status' => Story::STATUS_INACTIVE,
            'is_full' => ($storyIsFull == 'Full') ? 1 : 0,
            'is_new' => Story::IS_NEW,
            'is_hot' => Story::IS_HOT
            // 'hot_day' => 1,
            // 'hot_month' => 1,
            // 'hot_all_time' => 1,
        ];

        // dd($dataStory);

        // Handle save database 
        $storyId = $this->saveDatabase($storyCategories, $storyAuthor, $dataStory);

        $linkCrawlOrigin = $request->input('link_crawl_from');

        Queue::push(new CrawlStoryJob($linkCrawlOrigin, $fromPaginate, $toPaginate, $storyId));
        
        for ($i = $fromPaginate; $i <= $toPaginate;) {
            $linkCrawl = str_replace('trang-' . $fromPaginate, 'trang-' . $i, $linkCrawlOrigin);

            $crawler = $client->request('GET', $linkCrawl);

            $htmlString = $crawler->getBody()->getContents();
            $baseUrl = $linkCrawl;

            $crawler = new Crawler($htmlString, $baseUrl);

            $chapterLinks = $crawler->filter('ul.list-chapter a')->links();
            foreach ($chapterLinks as $link) {
                preg_match('/chuong-(\d+)/', $link->getUri(), $matches);

                if (isset($matches[1])) {
                    $chapter = $matches[1];
                    $this->crawlChapter($link->getUri(), $storyId, $chapter);
                }
            }

            $i++;
        }

        // try {
        //     CrawlStoryJob::dispatch($linkCrawlOrigin, $fromPaginate, $toPaginate, $storyId);
        // } catch (Exception $e) {
        //     return response()->json([
        //         'message' => $e->getMessage(),
        //     ], 403);
        // }

        return back()->with('success', 'Đang crawl data truyện, bạn có thể xem trong file laravel.log');
    }

    protected function downloadImages($urlImage, $fileName)
    {
        $client = new Client();
        $response = $client->request('GET', $urlImage); // Thay URL_HINH_ANH bằng URL thực tế của hình ảnh

        if ($response->getStatusCode() === 200) {
            // Lấy nội dung hình ảnh
            $imageContent = $response->getBody()->getContents();

            // Định đường dẫn và tên file lưu hình ảnh (có thể làm theo nhu cầu của bạn)
            $savePath = public_path('images/stories'); // Đường dẫn thư mục lưu trữ hình ảnh
            $fileName = $fileName . '.jpg'; // Tên file lưu trữ

            // Kiểm tra và tạo thư mục nếu nó chưa tồn tại
            if (!file_exists($savePath)) {
                mkdir($savePath, 0777, true);
            }

            // Lưu hình ảnh vào thư mục
            file_put_contents($savePath . '/' . $fileName, $imageContent);

            $path = '/images/stories/' . $fileName;
            return $path;
        }

        return "Không thể tải xuống hình ảnh.";
    }

    protected function crawlChapter($link, $storyId, $chapter)
    {
        $client = new Client();
        $crawler = $client->request('GET', $link);

        $htmlString = $crawler->getBody()->getContents();
        $baseUrl = $link;

        $crawler = new Crawler($htmlString, $baseUrl);

        if ($crawler->filter('div.chapter-c')->getNode(0)) {
            $content = $crawler->filter('div.chapter-c')->html();
            $titleChapter = $crawler->filter('.chapter-title')->text();
            $attributes = [
                'story_id' => $storyId,
                'chapter' => $chapter,
                'slug' => 'chuong-' . $chapter,
                'content' => $content,
                'name' => $titleChapter
            ];
            $this->chapterRepository->findOrCreate($attributes, $attributes);

            Log::info("Crawl " . $titleChapter);
        }
    }

    protected function saveDatabase($storyCategories, $storyAuthor, $dataStory)
    {
        // Save categories table
        $categories = [];
        $categoriesIds = [];
        foreach ($storyCategories as $category) {
            $categories[] = $category->textContent;
            $attributeCategory = [
                'name' => $category->textContent,
                'slug' => Str::slug($category->textContent)
            ];
            $category = $this->categoryRepository->findOrCreate($attributeCategory, $attributeCategory);
            $categoriesIds[] = $category->id;
        }

        // Save author
        $author = $this->authorRepository->findOrCreate(['name' => $storyAuthor, 'slug' => Str::slug($storyAuthor)], ['name' => $storyAuthor, 'slug' => Str::slug($storyAuthor)]);

        // Save story
        $dataStory['author_id'] = $author->id;
        $story = $this->storyRepository->findOrCreate($dataStory, $dataStory);
        $story->categories()->sync($categoriesIds);

        return $story->id;
    }

    public function storeOld(Request $request)
    {
        $client = new Client();
        $crawler = $client->request('GET', $request->input('link_crawl'));

        $htmlString = $crawler->getBody()->getContents();
        $baseUrl = $request->input('link_crawl');

        $crawler = new Crawler($htmlString, $baseUrl);
        // dd($crawler);

        $DOMchapterContent = $crawler->filter('div.chapter-c');
        $DOMchapterTitle = $crawler->filter('.chapter-title');

        $chapterContent = $DOMchapterContent->html();
        $chapterTitle = $DOMchapterTitle->text();

        $data = [
            'chapter_title' => $chapterTitle,
            'content' => $chapterContent
        ];

        return $DOMchapterContent->html();

        // ====================
        // // Lọc tất cả thẻ img trong thẻ div đã lọc
        // $images = $chapterDiv->filter('img')->images();

        // $imageUrls = [];
        // // Duyệt qua mảng các hình ảnh và lưu chúng
        // foreach ($images as $image) {
        //     // dd($image->getNode()->getAttribute('data-srcset'));
        //     $imageUrl = $image->getNode()->getAttribute('data-srcset');

        //     $client = new Client();
        //     $response = $client->request('GET', $imageUrl); // Thay URL_HINH_ANH bằng URL thực tế của hình ảnh

        //     if ($response->getStatusCode() === 200) {
        //         // Lấy nội dung hình ảnh
        //         $imageContent = $response->getBody()->getContents();

        //         // Định đường dẫn và tên file lưu hình ảnh (có thể làm theo nhu cầu của bạn)
        //         $savePath = public_path('uploads'); // Đường dẫn thư mục lưu trữ hình ảnh
        //         $fileName = 'ten_file.jpg'; // Tên file lưu trữ
        //         dd($savePath, $fileName);
        //         // Kiểm tra và tạo thư mục nếu nó chưa tồn tại
        //         if (!file_exists($savePath)) {
        //             mkdir($savePath, 0755, true);
        //         }

        //         // Lưu hình ảnh vào thư mục
        //         file_put_contents($savePath . '/' . $fileName, $imageContent);

        //         // Thông báo tải xuống thành công hoặc thất bại
        //         return "Hình ảnh đã được tải xuống và lưu trữ tại: $savePath/$fileName";
        //     }


        //     $imageUrls[] = $imageUrl;
        //     // Làm bất kỳ điều gì bạn muốn với URL của hình ảnh, ví dụ: lưu vào cơ sở dữ liệu, hiển thị ra màn hình, tải về v.v.
        // }
        // dd($imageUrls);

        // return response()->json($data);
    }
}
