<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryRepositoryInterface $repository,
        protected CategoryService $service
    ) {
        $this->middleware('can:xem_category_data')->only('index');
        $this->middleware('can:sua_category')->only('edit', 'update');
    }

    public function index(Request $request)
    {
        $page_title = 'Category';
        $search     = $request->get('search', []);
        $results    = $this->repository->paginate(20, [], $search);
        $categories = $this->service->getTable(20, [], $search);

        return view('Admin.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        $item = $this->repository->getModel();
        $item->id = 0;
        $action = route('admin.category.store');
        $view_data = compact('item', 'action');

        return view('Admin.pages.categories.add-edit', $view_data);
    }

    public function store(Request $request)
    {
        $attributes = $request->all();
        $attributes['slug'] = Str::slug($request->input('name'));
        $item       = $this->repository->create($attributes);

        return redirect(route('admin.category.index'))
            ->with('success', 'Thêm thành công.');
    }

    public function show($id)
    {
        $item = $this->repository->find($id);
    }

    public function edit($id)
    {
        $item = $this->repository->find($id, ['stories']);
        $action = route('admin.category.update', $id);
        $view_data = compact('item', 'action');

        return view('Admin.pages.categories.add-edit', $view_data);
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->all();
        $item       = $this->repository->update($id, $attributes);

        return redirect(route('admin.category.index'))
            ->with('success', 'Thay đổi thành công.');
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return back()->with('success', 'Delete Susscessfully');
    }
}
