<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    /**
     * @return mixed|\Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return new Category();
    }

    public function getCategoryBySlug($slug)
    {
        return $this->getModel()
            ->query()
            ->with(['stories', 'stories.author'])
            ->where('slug', '=', $slug)->first();
    }

    public function getCategories()
    {
        return $this->getModel()->query()->pluck('name', 'id')->toArray();
    }
}
