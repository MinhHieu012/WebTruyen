<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoryRequest;
use App\Models\Story;
use App\Repositories\Author\AuthorRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Story\StoryRepositoryInterface;
use App\Services\StoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class StoryController extends Controller
{
    public function __construct(
        protected StoryRepositoryInterface $repository,
        protected StoryService $service,
        protected AuthorRepositoryInterface $authorRepository,
        protected CategoryRepositoryInterface $categoryRepository
    ) {
        $this->middleware('can:xem_story_data')->only('index');
        $this->middleware('can:sua_story_data')->only('update');
        $this->middleware('can:them_story_data')->only('store');
        $this->middleware('can:xoa_story_data')->only('destroy');
    }

    public function index(Request $request)
    {
        $page_title = 'Story';
        $search     = $request->get('search', []);
        $results    = $this->repository->paginate(20, [], $search);
        $stories = $this->service->getTable(20, ['star'], $search);
        $categories = $this->getCategoies();
        $authors = $this->getAuthors();

        return view('Admin.pages.stories.index', compact('stories', 'categories', 'authors'));
    }

    public function create()
    {
        $formOptions['action'] = route('admin.story.store');
        $formOptions['method'] = 'POST';
        $story = null;
        $authors = $this->getAuthors();
        $categories = $this->getCategoies();

        $categories_belong = [];

        return view('Admin.pages.stories.show', compact('formOptions', 'story', 'authors', 'categories', 'categories_belong'));
    }

    public function store(StoryRequest $request)
    {
        $attributes = $request->all();
        $slug = Str::slug($request->input('name'));

        $slug = $this->getStorySlugExist($slug);
        $attributes['slug'] = $slug;
        // dd($attributes);

        $story       = $this->service->createStory($attributes);
        $story->categories()->sync($request->input('category_ids'));

        return redirect()->route('admin.story.index')->with('successMessage', 'Thêm mới truyện thành công');
    }

    protected function getStorySlugExist($slug) {
        $existSlug = Story::query()->where('slug', '=', $slug)->first();

        if ($existSlug) {
            $slug = $slug . rand(1, 20);
            $this->getStorySlugExist($slug);
        }

        return $slug;
    }

    public function show(Request $request, $id)
    {
        $search     = $request->get('search', []);
        $story = $this->repository->find($id, ['categories']);
        
        $chapters = $this->service->getTableChapters(50, $search, $story);

        $formOptions['action'] = route('admin.story.update', $story->id);
        $formOptions['method'] = 'PUT';
        $authors = $this->getAuthors();
        $categories = $this->getCategoies();

        $categories_belong = $story->categories->pluck('name', 'id')->toArray();

        return view('Admin.pages.stories.show', compact('story', 'chapters', 'story', 'formOptions', 'authors', 'categories', 'categories_belong'));
    }

    public function edit($id)
    {
        $item = $this->repository->find($id);
    }

    protected function getAuthors() {
        $authors = $this->authorRepository->getAuthors();
        $authors = Arr::prepend($authors, '-- Chọn tác giả --', '');
        return $authors;
    }

    protected function getCategoies() {
        $categories = $this->categoryRepository->getCategories();
        return $categories;
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->except('category_ids');

        if ($request->hasFile('image')) {
            // Cập nhật tệp mới nếu có
            $file = $request->file('image');
            $savePath = public_path('images/stories'); 
            $fileName = $file->getClientOriginalName();

            // Kiểm tra và tạo thư mục nếu nó chưa tồn tại
            if (!file_exists($savePath)) {
                mkdir($savePath, 0755, true);
            }
            $storedPath = $file->move('images/stories', $fileName);
            $attributes['image'] = '/images/stories'.'/'.$fileName;
        }
        $story       = $this->repository->update($id, $attributes);
        $story->categories()->sync($request->input('category_ids'));

        return back()->with('successMessage', 'Thay đổi thành công.');
    }

    public function updateAttribute(Request $request, $id) {
        $res = ['success' => false];

        // dd($request->input(), $id);
        $story = $this->repository->find(intval($id));
        if (!$story) {
            $res['mess'] = 'Truyện không tồn tại';
        }

        $save = $story->update($request->input(), $request->input());
        if ($save) {
            $res['success'] = true;
        }
        
        return response()->json($res);
    }

    public function destroy($id)
    {
        $res = ['success' => false];

        $delete = $this->service->deleteStory($id);

        if ($delete) {
            $res['success'] = true;
        }

        return response()->json($res);
    }
}
