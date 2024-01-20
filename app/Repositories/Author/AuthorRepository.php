<?php

namespace App\Repositories\Author;

use App\Models\Author;
use App\Repositories\BaseRepository;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{

    /**
     * @return mixed|\Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return new Author();
    }

    public function getAuthors() {
        return $this->getModel()->query()->pluck('name', 'id')->toArray();
    }
}
