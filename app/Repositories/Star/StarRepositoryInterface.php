<?php

namespace App\Repositories\Star;

use App\Repositories\BaseRepositoryInterface;

interface StarRepositoryInterface extends BaseRepositoryInterface
{
    public function getStarWithByStoryId($storyId);
}
