<?php

namespace App\Services;

use App\Repositories\Chapter\ChapterRepositoryInterface;
use App\Services\BaseService;
use App\Models\Chapter;

class ChapterService extends BaseService
{
    public function __construct(
        protected ChapterRepositoryInterface $repository
    )
    {
        parent::__construct();
    }

    public function setModel()
    {
        return new Chapter();
    }
}
