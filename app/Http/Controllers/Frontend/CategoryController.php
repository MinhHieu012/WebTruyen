<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Models\Story;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Chapter\ChapterRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        protected ChapterRepositoryInterface $chapterRepository
    )
    {
        
    }

    public function index(Request $request, $slug) {
        $category = $this->categoryRepository->getCategoryBySlug($slug);
        $stories = $category->stories->where('status', '=', Story::STATUS_ACTIVE);

        $setting = Helper::getSetting();
        $objectSEO = (object) [
            'name' => $category->name,
            'description' => 'Đọc truyện online, truyện hay. Suu Truyện luôn tổng hợp và cập nhật các chương truyện một cách nhanh nhất.',
            'keywords' => str_replace('-', ' ', $category->slug) .', '.'doc truyen, doc truyen online, truyen hay, truyen chu',
            'no_index' => $setting ? !$setting->index : env('NO_INDEX'),
            'meta_type' => 'WebPage',
            'url_canonical' => url()->current(),
            'image' => asset('assets/frontend/images/logo_text.png'),
            'site_name' => $category->name,
        ];

        Helper::setSEO($objectSEO);

        // $storiesIds = [];
        // if (count($stories) > 0) {
        //     foreach ($stories as $story) {
        //         $storiesIds[] = $story->id;
        //     }
        // }

        // $chapterLast = [];

        // if ($storiesIds) {
        //     $chapterLast = $this->chapterRepository->getChapterLast($storiesIds);
        //     $stories->map(function ($story) use ($chapterLast) {
        //         foreach ($chapterLast as $chapter) {
        //             if ($story->id == $chapter->story_id) {
        //                 return $story->chapter_last = $chapter;
        //             }
        //         }
        //     });
        // }

        return view('Frontend.category', compact('category', 'stories'));
    }
}
