<?php

namespace App\Repositories\Star;

use App\Models\Star;
use App\Repositories\BaseRepository;

class StarRepository extends BaseRepository implements StarRepositoryInterface
{

    /**
     * @return mixed|\Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return new Star();
    }

    public function getStarWithByStoryId($storyId)
    {
        return $this->getModel()->query()->where('story_id', '=', $storyId)->first();
    }
}
