<?php

namespace App\Repositories\Story;

use App\Repositories\BaseRepositoryInterface;

interface StoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getStoriesActive();
    public function getStoriesHot($limit);
    public function getStoriesNew($ids);
    public function getStoriesNewIds();
    public function getStoriesFull($ids);
    public function getStoriesFullIds();
    public function getStoryBySlug($slug);
    public function getStoriesHotRandom($limit);
    public function getStoryWithByKeyWord($keyWord);
    public function getStoriesWithChaptersCount($value);
}
