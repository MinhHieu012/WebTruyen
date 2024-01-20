<?php

namespace App\Repositories\Author;

use App\Repositories\BaseRepositoryInterface;

interface AuthorRepositoryInterface extends BaseRepositoryInterface
{
    public function getAuthors();
}
