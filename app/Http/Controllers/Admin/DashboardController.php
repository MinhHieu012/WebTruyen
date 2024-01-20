<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chapter;
use App\Models\Story;
use App\Models\Rating;
use App\Repositories\Rating\RatingRepositoryInterface;

class DashboardController extends Controller
{
    public function __construct(
        protected RatingRepositoryInterface $ratingRepository
    )
    {
        
    }

    public function index()
    {
        $totalStory = Story::query()->count();
        $totalChapter = Chapter::query()->count();
       
        $ratingsDay = $this->ratingRepository->getRatingByType(Rating::TYPE_DAY);
        $arrStoryIdsRatingsDay = $this->getStoryIds(json_decode($ratingsDay->value ?? '', true)) ?? [];
        $storiesDay = $this->ratingRepository->getStories($arrStoryIdsRatingsDay);

        $ratingsMonth = $this->ratingRepository->getRatingByType(Rating::TYPE_MONTH);
        $arrStoryIdsRatingsMonth = $this->getStoryIds(json_decode($ratingsMonth->value ?? '', true)) ?? [];
        $storiesMonth = $this->ratingRepository->getStories($arrStoryIdsRatingsMonth);

        $ratingsAllTime = $this->ratingRepository->getRatingByType(Rating::TYPE_ALL_TIME);
        $arrStoryIdsRatingsAllTime = $this->getStoryIds(json_decode($ratingsAllTime->value ?? '', true)) ?? [];
        $storiesAllTime = $this->ratingRepository->getStories($arrStoryIdsRatingsAllTime);

        $data = [
            'totalStory' => $totalStory,
            'totalChapter' => $totalChapter,
            'ratingsDay' => $ratingsDay,
            'storiesDay' => $storiesDay,
            'ratingsMonth' => $ratingsMonth,
            'storiesMonth' => $storiesMonth,
            'ratingsAllTime' => $ratingsAllTime,
            'storiesAllTime' => $storiesAllTime
        ];

        return view('Admin.pages.dashboard.index', $data);
    }

    protected function getStoryIds($ratings) {
        $result = [];

        if ($ratings) {
            foreach ($ratings as $rating) {
                $result[] = intval($rating['id']);
            }
        }
        
        return $result;
    }
}
