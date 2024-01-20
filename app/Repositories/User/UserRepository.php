<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * @return mixed|\Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return new User();
    }

    public function getByEmail($email)
    {
        return $this->model::query()
            ->where('email', $email)
            ->where('status', User::STATUS_ACTIVE)
            ->first();
    }
}
