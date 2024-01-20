<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Models\Rating;
use App\Repositories\Author\AuthorRepositoryInterface;
use App\Repositories\Chapter\ChapterRepositoryInterface;
use App\Repositories\Rating\RatingRepositoryInterface;
use App\Repositories\Story\StoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    public function __construct(
        protected StoryRepositoryInterface $storyRepository,
        protected ChapterRepositoryInterface $chapterRepository,
        protected AuthorRepositoryInterface $authorRepository,
        protected RatingRepositoryInterface $ratingRepository
    ) {
    }

    public function index(Request $request, $slug)
    {
        $story = $this->storyRepository->getStoryBySlug($slug, ['categories', 'author', 'author.stories', 'star']);
        if (!$story) {
            abort(404, 'Truyện không tồn tại');
        }
        $chapters = $this->chapterRepository->getChaptersByStoryId($story->id);
        $chaptersNew = $this->chapterRepository->getChaptersNewByStoryId($story->id);
        // dd($chapters);

        $ratingsDay = $this->ratingRepository->getRatingByType(Rating::TYPE_DAY);
        $arrStoryIdsRatingsDay = $this->getStoryIds(json_decode($ratingsDay->value ?? '', true)) ?? [];
        $storiesDay = $this->ratingRepository->getStories($arrStoryIdsRatingsDay) ?? [];

        $ratingsMonth = $this->ratingRepository->getRatingByType(Rating::TYPE_MONTH);
        $arrStoryIdsRatingsMonth = $this->getStoryIds(json_decode($ratingsMonth->value ?? '', true)) ?? [];
        $storiesMonth = $this->ratingRepository->getStories($arrStoryIdsRatingsMonth) ?? [];

        $ratingsAllTime = $this->ratingRepository->getRatingByType(Rating::TYPE_ALL_TIME);
        $arrStoryIdsRatingsAllTime = $this->getStoryIds(json_decode($ratingsAllTime->value ?? '', true)) ?? [];
        $storiesAllTime = $this->ratingRepository->getStories($arrStoryIdsRatingsAllTime) ?? [];

        $setting = Helper::getSetting();
        $objectSEO = (object) [
            'name' => $story->name,
            'description' => Str::limit($story->desc, 30),
            'keywords' => str_replace('-', ' ', $story->slug) . ', ' . 'doc truyen, doc truyen online, truyen hay, truyen chu',
            'no_index' => $setting ? !$setting->index : env('NO_INDEX'),
            'meta_type' => 'Book',
            'url_canonical' => url()->current(),
            'image' => asset($story->image),
            'site_name' => $story->name,
        ];

        $objectSEO->article   = [
            'author'         => $story->author->name,
            'published_time' => $story->created_at->toAtomString(),
        ];

        Helper::setSEO($objectSEO);

        return view('Frontend.story', compact('story', 'chapters', 'chaptersNew', 'slug', 'ratingsDay', 'ratingsMonth', 'ratingsAllTime', 'storiesDay', 'storiesMonth', 'storiesAllTime'));
    }

    protected function getStoryIds($ratings)
    {
        $result = [];

        if ($ratings) {
            foreach ($ratings as $rating) {
                $result[] = $rating['id'];
            }
        }

        return $result;
    }

    public function followChaptersCount(Request $request)
    {
        // dd($request->input());
        $stories = $this->storyRepository->getStoriesWithChaptersCount($request->input('value'));
        if ($request->input('value')[1] != 999999999) {
            $title = $request->input('value')[0] . ' - ' . $request->input('value')[1] . ' chương';
        } else {
            $title = 'Trên ' . $request->input('value')[0] . ' chương';
        }

        $ratingsDay = $this->ratingRepository->getRatingByType(Rating::TYPE_DAY);
        $arrStoryIdsRatingsDay = $this->getStoryIds(json_decode($ratingsDay->value, true));
        $storiesDay = $this->ratingRepository->getStories($arrStoryIdsRatingsDay);

        $ratingsMonth = $this->ratingRepository->getRatingByType(Rating::TYPE_MONTH);
        $arrStoryIdsRatingsMonth = $this->getStoryIds(json_decode($ratingsMonth->value, true));
        $storiesMonth = $this->ratingRepository->getStories($arrStoryIdsRatingsMonth);

        $ratingsAllTime = $this->ratingRepository->getRatingByType(Rating::TYPE_ALL_TIME);
        $arrStoryIdsRatingsAllTime = $this->getStoryIds(json_decode($ratingsAllTime->value, true));
        $storiesAllTime = $this->ratingRepository->getStories($arrStoryIdsRatingsAllTime);

        return view('Frontend.follow_chapter_count', compact('title', 'stories', 'ratingsDay', 'ratingsMonth', 'ratingsAllTime', 'storiesDay', 'storiesMonth', 'storiesAllTime'));
    }
}
