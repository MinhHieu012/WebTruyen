<?php

namespace App\Services;

use App\Repositories\Story\StoryRepositoryInterface;
use App\Services\BaseService;
use App\Models\Story;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Chapter\ChapterRepositoryInterface;

class StoryService extends BaseService
{
    public function __construct(
        protected StoryRepositoryInterface $repository,
        protected CategoryRepositoryInterface $categoryRepository,
        protected ChapterRepositoryInterface $chapterRepository
    ) {
        parent::__construct();
    }

    public function setModel()
    {
        return new Story();
    }

    public function getTable(int $limit, array $with = [], array $args = [])
    {
        $results = $this->model::query()
            ->with($with)
            ->when($args['keyword'] ?? '', function ($query) use ($args) {
                $query->where(function ($q1) use ($args) {
                    return $q1->where('name', 'like', '%' . $args['keyword'] . '%');
                });
            })
            ->when($args['category_id'] ?? '', function ($query) use ($args) {
                $query->whereHas('categories', function($query) use ($args) {
                    $query->where('categories.id', $args['category_id']);
                });
            })
            ->when($args['author_id'] ?? '', function ($query) use ($args) {
                $query->whereHas('author', function($query) use ($args) {
                    $query->where('authors.id', $args['author_id']);
                });
            })
            ->orderByDesc('created_at')
            ->paginate($limit);

        return $results;
    }

    public function getTableChapters(int $limit, array $args = [], $story)
    {
        return $story->chapters()
            ->when($args['keyword'] ?? '', function ($query) use ($args) {
                $query->where(function ($q1) use ($args) {
                    return $q1->where('name', 'like', '%' . $args['keyword'] . '%');
                });
            })
            ->orderBy('chapter', 'DESC')
            ->paginate($limit);
    }

    public function deleteStory($id)
    {
        $story = $this->model->find($id);

        $story->categories()->detach();
        $story->chapters()->delete();
        $story->delete();

        return true;
    }

    public function createStory($attributes) {
        $story = $this->model->create($attributes);
        return $story;
    }
}
