<?php

namespace App\Services;

use App\Repositories\Star\StarRepositoryInterface;
use App\Services\BaseService;
use App\Models\Star;

class StarService extends BaseService
{
    public function __construct(
        protected StarRepositoryInterface $repository
    )
    {
        parent::__construct();
    }

    public function setModel()
    {
        return new Star();
    }
}
