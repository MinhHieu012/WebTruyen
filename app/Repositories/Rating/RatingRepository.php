<?php

namespace App\Repositories\Rating;

use App\Models\Rating;
use App\Models\Story;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class RatingRepository extends BaseRepository implements RatingRepositoryInterface
{

    /**
     * @return mixed|\Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return new Rating();
    }

    public function getRatingByType($type)
    {
        return $this->getModel()->query()->where('type', '=', $type)->first();
    }

    public function getStories($arrStoryIds)
    {
        return Story::query()->with(['categories'])->whereIn('id', $arrStoryIds)
        ->orderByRaw('FIELD(id, ' . implode(',', $arrStoryIds) . ')')
        ->get();
    }
}
