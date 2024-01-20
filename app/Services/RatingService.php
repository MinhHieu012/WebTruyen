<?php

namespace App\Services;

use App\Repositories\Rating\RatingRepositoryInterface;
use App\Services\BaseService;
use App\Models\Rating;

class RatingService extends BaseService
{
    public function __construct(
        protected RatingRepositoryInterface $repository
    )
    {
        parent::__construct();
    }

    public function setModel()
    {
        return new Rating();
    }

    public function emptyRatings() {
        Rating::truncate();
    }

    public function saveRatings($data) {
        $ratings = new Rating();
        $ratings->status = $data['status'];
        $ratings->type = $data['type'];
        $ratings->value = $data['value'];
        $ratings->save();
    }
}
