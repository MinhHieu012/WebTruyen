<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Models\Chapter;
use App\Models\Story;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Chapter\ChapterRepositoryInterface;
use App\Repositories\Story\StoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;

class HomeController extends Controller
{
    public function __construct(
        protected StoryRepositoryInterface $storyRepository,
        protected ChapterRepositoryInterface $chapterRepository,
        protected CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function index(Request $request)
    {
        $setting = Helper::getSetting();

        $objectSEO = (object) [
            'name' => $setting ? $setting->title : 'Suu Truyện',
            'description' => $setting ? $setting->description : 'Đọc truyện online, truyện hay. Suu Truyện luôn tổng hợp và cập nhật các chương truyện một cách nhanh nhất.',
            'keywords' => 'doc truyen, doc truyen online, truyen hay, truyen chu',
            'no_index' => $setting ? !$setting->index : env('NO_INDEX'),
            'meta_type' => 'WebPage',
            'url_canonical' => route('home'),
            'image' => asset('assets/frontend/images/logo_text.png'),
            'site_name' => 'Suu Truyện'
        ];

        Helper::setSEO($objectSEO);

        $storiesHot = $this->storyRepository->getStoriesHot(16);
        $storiesNewIds = $this->storyRepository->getStoriesNewIds()->toArray();
        $storiesNew = $this->storyRepository->getStoriesNew($storiesNewIds);
        $chapterLast = $this->chapterRepository->getChapterLast($storiesNewIds) ?? [];

        $storiesFullIds = $this->storyRepository->getStoriesFullIds()->toArray();
        $storiesFull = $this->storyRepository->getStoriesFull($storiesFullIds);
        $chapterLastOffFull = $this->chapterRepository->getChapterLast($storiesFullIds);

        $storiesNew->map(function ($story) use ($chapterLast) {
            foreach ($chapterLast as $chapter) {
                if ($chapter->story_id == $story->id) {
                    return $story->chapter_last = $chapter;
                }
            }
        });

        $storiesFull->map(function ($story) use ($chapterLastOffFull) {
            foreach ($chapterLastOffFull as $chapter) {
                if ($chapter->story_id == $story->id) {
                    return $story->chapter_last = $chapter;
                }
            }
        });

        // $categories = Helper::getCategoies();

        return view('Frontend.home', compact('storiesHot', 'storiesNew', 'storiesFull'));
    }

    public function getListStoryHot(Request $request)
    {
        $res = ['success' => false];

        $category = $this->categoryRepository->find(intval($request->input('category_id')), ['stories']);
        $stories = $category->stories()->where('status', '=', Story::STATUS_ACTIVE)->limit(16)->get();

        $param = [
            'categoryIdSelected' => intval($request->input('category_id')),
            'categories' => Helper::getCategoies(),
            'storiesHot' => $stories
        ];
        $html = view('Frontend.sections.main.stories_hot', $param)->toHtml();

        $res['success'] = true;
        $res['html'] = $html;

        return response()->json($res);
    }
    public function getListStoryHotRandom(Request $request)
    {
        $res = ['success' => false];

        $stories = $this->storyRepository->getStoriesHotRandom(16);

        $param = [
            'categoryIdSelected' => 0,
            'categories' => Helper::getCategoies(),
            'storiesHot' => $stories
        ];

        $html = view('Frontend.sections.main.stories_hot', $param)->toHtml();

        $res['success'] = true;
        $res['html'] = $html;

        return response()->json($res);
    }

    public function searchStory(Request $request)
    {
        $res = ['success' => false];

        $stories = $this->storyRepository->getStoryWithByKeyWord($request->input('key_word'));

        $res['success'] = true;
        $res['stories'] = $stories;

        return response()->json($res);
    }

    public function mainSearchStory(Request $request)
    {
        // dd($request->get('key_word'));
        $stories = $this->storyRepository->getStoryWithByKeyWord($request->get('key_word'));

        $storiesIds = [];
        if (count($stories) > 0) {
            foreach ($stories as $story) {
                $storiesIds[] = $story->id;
            }
        }

        $chapterLast = [];

        if ($storiesIds) {
            $chapterLast = $this->chapterRepository->getChapterLast($storiesIds);
            $stories->map(function ($story) use ($chapterLast) {
                foreach ($chapterLast as $chapter) {
                    if ($story->id == $chapter->story_id) {
                        return $story->chapter_last = $chapter;
                    }
                }
            });
        }

        $data = [
            'stories' => $stories,
            'keyWord' => $request->get('key_word')
        ];
        return view('Frontend.main_search', $data);
    }
}
