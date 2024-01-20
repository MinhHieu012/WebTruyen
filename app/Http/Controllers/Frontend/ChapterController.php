<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Models\Chapter;
use App\Repositories\Chapter\ChapterRepositoryInterface;
use App\Repositories\Story\StoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChapterController extends Controller
{
    public function __construct(
        protected StoryRepositoryInterface $storyRepository,
        protected ChapterRepositoryInterface $chapterRepository
    ) {
    }

    public function index(Request $request, $slugStory, $slugChapter)
    {
        $story = $this->storyRepository->getStoryBySlug($slugStory);
        if (!$story) {
            return abort(404);
        }

        $chapter = $this->chapterRepository->getChapterSingle($story->id, $slugChapter);
        $chapterLast = $this->chapterRepository->getChapterLastSingle($story->id);
        // dd($chapter, $story->id, $slugChapter, $slugStory);
        if (!$chapter) {
            return abort(404, 'Không tồn tại chương truyện này!');
        }

        $chapterInt = $chapter->chapter;
        $chapterBefore = null;
        $chapterAfter = null;
        if ($chapterInt > 1) {
            $chapterBefore = Chapter::query()->where('story_id', '=', $story->id)->where('chapter', '=', ($chapterInt - 1))->first();
        }
        $chapterAfter = Chapter::query()->where('story_id', '=', $story->id)->where('chapter', '=', ($chapterInt + 1))->first();

        $setting = Helper::getSetting();
        $objectSEO = (object) [
            'name' => $chapter->name,
            'description' => Str::limit($story->desc, 30),
            'keywords' => 'doc truyen, doc truyen online, truyen hay, truyen chu',
            'no_index' => $setting ? !$setting->index : env('NO_INDEX'),
            'meta_type' => 'Book',
            'url_canonical' => url()->current(),
            'image' => asset($story->image),
            'site_name' => $chapter->name,
        ];

        $objectSEO->article   = [
            'author'         => $story->author->name,
            'published_time' => $story->created_at->toAtomString(),
        ];

        Helper::setSEO($objectSEO);
        $breadcrumbEndpoint = 'Chương ' . $chapter->chapter;

        return view('Frontend.chapter', compact('story', 'chapter', 'slugChapter', 'chapterLast', 'breadcrumbEndpoint', 'chapterBefore', 'chapterAfter'));
    }

    public function getChapters(Request $request)
    {
        $res = ['success' => false];

        $listChapter = $this->chapterRepository->getListChapterByStoryId($request->input('story_id'));

        $res['chapters'] = $listChapter;
        $res['success'] = true;

        return response()->json($res);
    }
}