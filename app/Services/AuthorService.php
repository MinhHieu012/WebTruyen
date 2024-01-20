<?php

namespace App\Services;

use App\Repositories\Author\AuthorRepositoryInterface;
use App\Services\BaseService;
use App\Models\Author;

class AuthorService extends BaseService
{
    public function __construct(
        protected AuthorRepositoryInterface $repository
    )
    {
        parent::__construct();
    }

    public function setModel()
    {
        return new Author();
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
            ->orderByDesc('updated_at')
            ->paginate($limit);

        return $results;
    }
}
