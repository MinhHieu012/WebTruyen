<?php

namespace App\Repositories\Story;

use App\Models\Story;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StoryRepository extends BaseRepository implements StoryRepositoryInterface
{

    /**
     * @return mixed|\Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return new Story();
    }

    public function getStoriesActive()
    {
        return $this->getModel()::query()->where('status', '=', Story::STATUS_ACTIVE)->get();
    }

    public function getStoriesHot($limit)
    {
        return $this->getModel()::query()->where('status', '=', Story::STATUS_ACTIVE)->where('is_hot', '=', Story::IS_HOT)->limit($limit)->get();
    }

    public function getStoriesNewOld()
    {
        // DB::table('stories')
        //     ->select('stories.*', 'categories.name as category_name')
        //     ->join(DB::raw('(SELECT story_id, MAX(id) as max_id FROM chapters GROUP BY story_id) as latestChapters'), function ($join) {
        //         $join->on('latestChapters.story_id', '=', 'stories.id');
        //     })
        //     ->join('chapters', function ($join) {
        //         $join->on('latestChapters.max_id', '=', 'chapters.id');
        //     })
        //     ->join('category_story', 'stories.id', '=', 'category_story.story_id')
        //     ->join('categories', 'category_story.category_id', '=', 'categories.id')
        //     ->addSelect(DB::raw('MAX(chapters.id) as max_chapter_id'))
        //     ->groupBy('stories.id', 'categories.name')
        //     ->get();

        return DB::table('stories')
            ->where('stories.status', '=', Story::STATUS_ACTIVE)
            ->select('stories.*', 'categories.name as category_name')
            ->join(DB::raw('(SELECT story_id, MAX(id) as max_id FROM chapters GROUP BY story_id) as latestChapters'), function ($join) {
                $join->on('latestChapters.story_id', '=', 'stories.id');
            })
            ->join('chapters', function ($join) {
                $join->on('latestChapters.max_id', '=', 'chapters.id');
            })
            ->join('categorie_storie', 'stories.id', '=', 'categorie_storie.storie_id')
            ->join('categories', 'categorie_storie.categorie_id', '=', 'categories.id')
            ->addSelect(DB::raw('MAX(chapters.id) as max_chapter_id'), 'chapters.name as chapter_last_name')
            ->groupBy('stories.id', 'category_name')
            ->orderBy('stories.id', 'desc')
            ->get();
    }

    public function getStoriesNew($ids)
    {
        $now = Carbon::now()->toDateTimeString();
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->subHours(24))->toDateTimeString();

        return $this->getModel()
            ->query()
            ->with(['categories'])
            ->whereIn('id', $ids)
            ->where('is_new', '=', Story::IS_NEW)
            // ->where('updated_at', '>=', $startDate)
            // ->where('updated_at', '<=', $now)
            ->limit(20)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function getStoriesNewIds()
    {
        return $this->getModel()
            ->query()
            ->where('status', '=', Story::STATUS_ACTIVE)
            ->where('is_new', '=', Story::IS_NEW)
            ->where('status', '=', Story::STATUS_ACTIVE)
            ->pluck('id');
    }

    public function getStoriesFull($ids)
    {
        return $this->getModel()
            ->where('is_full', '=', Story::FULL)
            ->whereIn('id', $ids)
            ->where('status', '=', Story::STATUS_ACTIVE)
            ->get();
    }

    public function getStoriesFullIds()
    {
        return $this->getModel()
            ->query()
            ->where('is_full', '=', Story::FULL)
            ->where('status', '=', Story::STATUS_ACTIVE)
            ->pluck('id');
    }

    public function getStoryBySlug($slug, $with = [])
    {
        return $this->getModel()
            ->query()
            // ->with(['categories', 'author', 'author.stories'])
            ->with($with)
            ->where('slug', '=', $slug)
            ->where('status', '=', Story::STATUS_ACTIVE)
            ->first();
    }

    public function getStoriesHotRandom($limit)
    {
        return $this->getModel()
            ->query()->inRandomOrder()->where('status', '=', Story::STATUS_ACTIVE)->where('is_hot', '=', Story::IS_HOT)->limit($limit)->get();
    }

    public function getStoryWithByKeyWord($keyWord)
    {
        return $this->getModel()->query()->with(['author'])->where('name', 'LIKE', '%' . $keyWord . '%')->get();
    }

    public function getStoriesWithChaptersCount($value)
    {
        return $this->getModel()->query()->where('status', '=', Story::STATUS_ACTIVE)->withCount('chapters')->has('chapters', '>=', $value[0])->has('chapters', '<=', $value[1])->get();
    }
}
