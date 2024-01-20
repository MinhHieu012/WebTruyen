<?php

namespace App\Repositories\Chapter;

use App\Repositories\BaseRepositoryInterface;

interface ChapterRepositoryInterface extends BaseRepositoryInterface
{
    public function getChapterLast($storyIds);
    public function getChaptersByStoryId($storyId);
    public function getListChapterByStoryId($storyId);
    public function getChaptersNewByStoryId($storyId);
    public function getChapterSingle($storyId, $slug);
}
