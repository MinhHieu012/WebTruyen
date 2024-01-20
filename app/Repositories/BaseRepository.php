<?php

namespace App\Repositories;
abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var $model \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    /**
     * @return mixed|\Illuminate\Database\Eloquent\Model
     */
    abstract public function getModel();

    public function setModel()
    {
        $this->model = $this->getModel();
    }

    public function all($with = null)
    {
        if ($with) {
            return $this->model->with($with)->get();
        }

        return $this->model->all();
    }

    public function lists(array $with = [], array $args = [])
    {
        return $this->model->with($with)->get();
    }

    public function paginate(int $limit, array $with = [], array $args = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model->with($with)->paginate($limit);
    }

    public function showOption($query, $showOption)
    {
        if (isset($showOption['orderBy']) && is_array($showOption['orderBy'])) {
            foreach ($showOption['orderBy'] as $orderBy) {
                if (isset($orderBy['column'])) {
                    $query->orderBy($orderBy['column'], $orderBy['type'] ?? 'DESC');
                }
            }
        }

        return $query->paginate($showOption['perPage'] ?? config('table.default_paginate'));
    }

    public function find(int $id, $with = [])
    {
        return $this->model->with($with)->find($id);
    }

    public function findOrFail(int $id, $with = [])
    {
        return $this->model->with($with)->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @return mixed|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes = [])
    {
        $result = $this->findOrFail($id);
        if ($result) {
            $result->update($attributes);

            return $result;
        }

        return false;
    }

    public function updateArr(array $ids, array $attributes = [])
    {
        $result = $this->model->whereIn('id', $ids);
        if ($result) {
            $result->update($attributes);

            return $result;
        }

        return false;
    }

    public function delete(int $id): bool
    {
        $result = $this->findOrFail($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function formOptions($model = null): array
    {
        $model          = $model ?: $this->getModel();
        $default_values = [];
        foreach ($model->getFillable() as $key) {
            $default_values[$key] = old($key) ?: $model->{$key};
        }
        $status = [
            '1' => 'Hoạt động',
            '0' => 'Ngừng hoạt động',
        ];

        return compact('default_values', 'status');
    }

    public function getByArrId($arrId, $with = [])
    {
        return $this->model->with($with)->whereIn('id', $arrId)->get();
    }

    public function getByRequest($with = [], $requestParams = [], $showOption = [])
    {
        $query = null;
        return $this->showOption($query, $showOption);
    }

    public function max($column)
    {
        return $this->model->max($column);
    }

    public function min($column)
    {
        return $this->model->min($column);
    }

    public function findOrCreate($conditions, $attributes)
    {
        $result = $this->model->where($conditions)->first();

        if ($result) {
            return $result;
        } else {
            return $this->model->create($attributes);
        }
    }

    public function createMany(array $sources = [])
    {
        return $this->model->insert($sources);
    }
}
