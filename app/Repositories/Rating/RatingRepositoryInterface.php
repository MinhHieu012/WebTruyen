<?php

namespace App\Repositories\Rating;

use App\Repositories\BaseRepositoryInterface;

interface RatingRepositoryInterface extends BaseRepositoryInterface
{
    public function getRatingByType($type);
    public function getStories($arrStoryIds);
}
