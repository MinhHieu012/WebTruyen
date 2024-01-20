<?php


namespace App\Repositories;

use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * Get all
     * @return mixed|Collection
     */
    public function all($with = null);

    /**
     * @param array $with
     * @param array $args
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function lists(array $with = [], array $args = []);

    /**
     * Get paginate
     * @param int $limit
     * @param array $with
     * @param array $args
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $limit, array $with = [], array $args = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * Get one
     * @param int $id
     * @param array $with
     * @return mixed|\Illuminate\Database\Eloquent\Model
     */
    public function find(int $id, array $with = []);

    /**
     * @param int $id
     * @return mixed
     */
    public function findOrFail(int $id, $with = []);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes = []);

    public function createMany(array $sources = []);

    /**
     * Update
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(int $id, array $attributes = []);

    public function updateArr(array $ids, array $attributes = []);

    /**
     * Delete
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    public function formOptions($model = null): array;

    /**
     * Get one
     * @param $arrId
     * @param $with
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getByArrId($arrId, $with);

    public function getByRequest($with = [], $requestParams = [], $showOption = []);

    public function showOption($query, $showOption);

    public function max($column);

    public function min($column);

    public function findOrCreate($conditions, $attributes);
}
