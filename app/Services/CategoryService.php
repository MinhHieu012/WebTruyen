<?php

namespace App\Services;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Services\BaseService;
use App\Models\Category;

class CategoryService extends BaseService
{
    public function __construct(
        protected CategoryRepositoryInterface $repository
    )
    {
        parent::__construct();
    }

    public function setModel()
    {
        return new Category();
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
            ->orderByDesc('created_at')
            ->paginate($limit);

        return $results;
    }
}
