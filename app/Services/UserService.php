<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserService extends BaseService
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {
        parent::__construct();
    }

    function setModel()
    {
        return new User();
    }

    public function getTable(int $limit, array $with = [], array $args = [])
    {
        $with[]  = 'roles';
        $results = $this->model::query()
            ->with($with)
            ->when($args['keyword'] ?? '', function ($query) use ($args) {
                $query->where(function ($q1) use ($args) {
                    return $q1->where('email', 'like', '%' . $args['keyword'] . '%')
                        ->orWhere('name', 'like', '%' . $args['keyword'] . '%');
                });
            })
            ->when(($args['status'] ?? null) !== null, function ($query) use ($args) {
                $query->where('status', '=', $args['status']);
            })
            ->when($args['role_id'] ?? '', function ($query) use ($args) {
                $query->whereRelation('roles', 'id', '=', $args['role_id']);
            })
            ->orderByDesc('updated_at')
            ->paginate($limit);

        return $results;
    }

    public function formOptions($model = null): array
    {
        $options = parent::formOptions($model);

        $options['default_values']['role_id'] = old('role_id') ?: $model?->roles->first()?->id;

        $options['roles']  = Role::all();
        $options['status'] = User::STATUS_TEXT;

        return $options;
    }

    public function create(array $attributes)
    {
        // $attributes['password'] = Hash::make(Str::random());

        $user = $this->repository->create($attributes);
        if ($user) {
            $this->updateOptional($user, $attributes);
        }
    }

    function updateOptional($user, $attributes)
    {
        $attributes['role_id'] = $attributes['role_id'] ?? '';
        $attributes['roles'] = (array)$attributes['role_id'];
        $user->syncRoles($attributes['roles']);
    }

    public function update(int $id, array $attributes)
    {
        $user = $this->repository->update($id, $attributes);

        if ($user) {
            $this->updateOptional($user, $attributes);
        }
        return $user;
    }
}
