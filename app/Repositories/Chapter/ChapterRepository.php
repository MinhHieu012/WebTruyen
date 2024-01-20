<?php

namespace App\Repositories\Chapter;

use App\Models\Chapter;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ChapterRepository extends BaseRepository implements ChapterRepositoryInterface
{

    /**
     * @return mixed|\Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return new Chapter();
    }

    public function getChapterLast($storyIds)
    {
        if (!$storyIds) {
            return null;
        }
        $chapter = Chapter::first();
        if ($chapter) {
            return DB::table('chapters as c')
                ->join(DB::raw('(SELECT MAX(id) AS max_id FROM chapters WHERE story_id IN (' . implode(',', $storyIds) . ') GROUP BY story_id) latest_chapters'), 'c.id', '=', 'latest_chapters.max_id')
                ->select('c.*')
                ->get();
        } else {
            return null;
        }
    }

    public function getChaptersByStoryId($storyId)
    {
        return $this->getModel()
            ->query()
            ->where('story_id', '=', $storyId)
            ->paginate(50);
    }

    public function getListChapterByStoryId($storyId)
    {
        return $this->getModel()
            ->query()
            ->where('story_id', '=', $storyId)
            ->select(['id', 'name', 'slug', 'chapter'])
            ->get();
    }

    public function getChaptersNewByStoryId($storyId)
    {
        return $this->getModel()
            ->query()
            ->where('story_id', '=', $storyId)
            ->where('is_new', '=', Chapter::IS_NEW)
            ->orderBy('chapter', 'desc')
            ->select('id', 'name', 'slug')
            ->get();
    }

    public function getChapterSingle($storyId, $slug)
    {
        return $this->getModel()
            ->query()
            ->where('story_id', '=', $storyId)
            ->where('slug', '=', $slug)
            ->first();
    }

    public function getChapterLastSingle($storyId)
    {
        return $this->getModel()
            ->query()
            ->where('story_id', '=', $storyId)
            ->orderBy('id', 'DESC')
            ->first();
    }
}
