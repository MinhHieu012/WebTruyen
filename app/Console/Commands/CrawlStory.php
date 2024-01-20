<?php

namespace App\Console\Commands;

use App\Jobs\CrawlStoryJob;
use function Laravel\Prompts\text;
use App\Models\Author;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Star;
use Illuminate\Console\Command;
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

class CrawlStory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:crawl-story {link_crawl_from} {link_crawl_to}';
    protected $signature = 'app:crawl-story {linkCrawlFrom} {linkCrawlTo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command crawl story from Truyen Full vn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $name = text(
        //     label: 'What is your name?',
        //     placeholder: 'E.g. Taylor Otwell',
        //     default: $user?->name
        // );

        
        // $linkCrawlFrom = text(
        //     label: 'Link từ trang mấy ?',
        //     placeholder: 'https://truyenfull.vn/phi-thien/trang-1',
        // );
        // $linkCrawlTo = text(
        //     label: 'Link đén trang mấy ?',
        //     placeholder: 'https://truyenfull.vn/phi-thien/trang-10',
        // );
        $linkCrawlFrom = $this->argument('linkCrawlFrom');
        $linkCrawlTo = $this->argument('linkCrawlTo');

        // dd($linkCrawlFrom, $linkCrawlTo);
        // die;
        $this->info('#Đang tiến hành crawl truyện ...');

        $this->store($linkCrawlFrom, $linkCrawlTo);

        // Hiển thị kết thúc hoặc thông báo khác nếu cần
        $this->info("\nCrawl story completed! Crawling from: $linkCrawlFrom to: $linkCrawlTo");
    }

    protected function store($linkCrawlFrom, $linkCrawlTo)
    {
        set_time_limit(500);

        $client = new Client();
        preg_match('/trang-(\d+)/', $linkCrawlFrom, $matches);
        $fromPaginate = $matches[1];

        preg_match('/trang-(\d+)/', $linkCrawlTo, $matches);
        $toPaginate = $matches[1];

        $crawler = $client->request('GET', $linkCrawlFrom);

        $htmlString = $crawler->getBody()->getContents();
        $baseUrl = $linkCrawlFrom;

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
        $pathImage = $this->downloadImages($storyImage->getUri(), Str::slug(strtolower($storyName), '_'));

        $dataStory = [
            'image' => $pathImage,
            'slug' => Str::slug($storyName),
            'name' => $storyName,
            'desc' => $storyDesc,
            'status' => Story::STATUS_ACTIVE,
            'is_full' => ($storyIsFull == 'Full') ? 1 : 0,
            // 'is_new' => Story::IS_NEW,
            'is_hot' => Story::IS_HOT
        ];

        $dataStar = [
            'stars' => 0,
            'count' => 0
        ];
        if ($crawler->filter('span[itemprop="ratingValue"]')->getNode(0) && $crawler->filter('span[itemprop="ratingCount"]')->getNode(0)) { 
            $dataStar['stars'] = $crawler->filter('span[itemprop="ratingValue"]')->text();
            $dataStar['count'] = $crawler->filter('span[itemprop="ratingCount"]')->text();
        }
        // Handle save database 
        $storyId = $this->saveDatabase($storyCategories, $storyAuthor, $dataStory, $dataStar);
        $linkCrawlOrigin = $linkCrawlFrom;

        Queue::push(new CrawlStoryJob($linkCrawlOrigin, $fromPaginate, $toPaginate, $storyId));
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

    protected function saveDatabase($storyCategories, $storyAuthor, $dataStory, $dataStar)
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
            $category = Category::query()->where($attributeCategory)->first();
            if (!$category) {
                $category = Category::query()->create($attributeCategory);
            }
            $categoriesIds[] = $category->id;
        }

        // Save author
        $author = Author::query()->where(['name' => $storyAuthor, 'slug' => Str::slug($storyAuthor)])->first();
        if (!$author) {
            $author = Author::query()->create(['name' => $storyAuthor, 'slug' => Str::slug($storyAuthor)]);
        }

        // Save story
        $dataStory['author_id'] = $author->id;

        $story = Story::query()->where([
            'name' => $dataStory['name'],
            'slug' => $dataStory['slug']
        ])->first();
        if (!$story) {
            $story = Story::query()->create($dataStory);
            $story->categories()->sync($categoriesIds);
        }

        // Save Stars
        $star = Star::query()->where('story_id', '=', $story->id)->first();
        if (!$star) {
            $star = new Star();
        }
        $star->story_id = $story->id;
        $star->controller_name = 'StoryController';
        $star->stars = $dataStar['stars'];
        $star->count = $dataStar['count'];
        $star->approved = 1;
        $star->save();

        return $story->id;
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

            $chapter = Chapter::query()->where($attributes)->first();
            if (!$chapter) {
                Chapter::query()->create($attributes);
            }

            Log::info("Crawl " . $titleChapter);
        }
    }
}
