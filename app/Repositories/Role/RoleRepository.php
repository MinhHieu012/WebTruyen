<?php

namespace App\Repositories\Role;

use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Role();
    }

    public function lists(array $with = [], array $args = [])
    {
        return $this->model->with($with)->withCount('users')->get();
    }
}
