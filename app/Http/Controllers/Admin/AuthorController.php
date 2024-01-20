<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Author\AuthorRepositoryInterface;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function __construct(
        protected AuthorRepositoryInterface $repository,
        protected AuthorService $service
    ) {
        $this->middleware('can:xem_author_data')->only('index');
        $this->middleware('can:sua_author')->only('edit', 'update');
    }

    public function index(Request $request)
    {
        $page_title = 'Author';
        $search     = $request->get('search', []);
        $authors    = $this->service->getTable(20, [], $search);

        return view('Admin.pages.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('Admin.pages.authors.add-edit');
    }

    public function store(Request $request)
    {
        $attributes = $request->all();
        $item       = $this->repository->create($attributes);
        return redirect()->route('admin.author.index')->with('successMessage', 'Tạo thành công.');
    }

    public function show($id)
    {
        $item = $this->repository->find($id);
    }

    public function edit(Request $request, int $author_id)
    {
        $author = $this->repository->find($author_id);

        $view_data = compact('author', 'author_id');

        return view('Admin.pages.authors.add-edit', $view_data);
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->all();
        $item       = $this->repository->update($id, $attributes);

        return redirect(route('admin.author.index'))
            ->with('successMessage', 'Thay đổi thành công.');
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return back()->with('successMessage', 'Delete Susscessfully');
    }
}
