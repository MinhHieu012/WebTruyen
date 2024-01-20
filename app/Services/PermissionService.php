<?php

namespace App\Services;

use App\Repositories\Permission\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionService extends BaseService
{
    public function __construct(
        protected PermissionRepositoryInterface $repository,
    )
    {
        parent::__construct();
    }

    public function setModel()
    {
        return new Permission();
    }

    public function getResult(array $with = [], array $args = [])
    {
        $with[]  = 'roles';
        $results = $this->model::query()
            ->with($with)
            ->when($args['keyword'] ?? '', function ($query) use ($args) {
                $query->where(function ($q1) use ($args) {
                    return $q1->where('name', 'like', '%' . $args['keyword'] . '%')
                        ->orWhere('name_2', 'like', '%' . $args['keyword'] . '%');
                });
            })
            ->when($args['role_id'] ?? '', function ($query) use ($args) {
                $query->whereRelation('roles', 'id', '=', $args['role_id']);
            })
            ->orderBy('group', 'ASC')
            ->get();

        return $results;
    }

    public function update($id, $attributes)
    {
        $permission = $this->repository->find($id);
        $permission->update([
            'group' => $attributes['group'],
        ]);
        $permission->syncRoles($attributes['roles']);
    }
}
