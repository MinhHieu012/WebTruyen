<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Chapter\ChapterRepositoryInterface;
use App\Repositories\Story\StoryRepositoryInterface;
use App\Services\ChapterService;
use Error;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function __construct(
        protected ChapterRepositoryInterface $repository,
        protected ChapterService $service,
        protected StoryRepositoryInterface $storyRepository
    ) {
        $this->middleware('can:sua_chapter')->only('edit');
    }

    public function index(Request $request)
    {
        $page_title = 'Chapter';
        $search     = $request->get('search', []);
        $results    = $this->repository->paginate(20, [], $search);
    }

    public function create($story_id)
    {
        $story = $this->storyRepository->find(intval($story_id));

        $chapter = null;

        return view('Admin.pages.chapters.edit', compact('chapter', 'story'));
    }

    public function store(Request $request)
    {
        $attributes = $request->all();
        $slug = Str::slug($request->input('name'));
        $attributes['slug'] = $slug;

        $chapter       = $this->repository->create($attributes);

        return redirect()->route('admin.story.show', ['story' => $chapter->story_id])->with('successMessage', 'Thêm mới chapter thành công.');
    }

    public function show($id)
    {
        $item = $this->repository->find($id);
    }

    public function edit($id)
    {
        $chapter = $this->repository->find($id);
        if (!$chapter) {
            return throw(new Error('Truyện không tồn tại'));
        }
        $story = $this->storyRepository->find(intval($chapter->story_id));

        return view('Admin.pages.chapters.edit', compact('chapter', 'story'));
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->all();
        $slug = Str::slug($request->input('name'));
        $attributes['slug'] = $slug;
        $chapter       = $this->repository->update($id, $attributes);

        return redirect()->route('admin.story.show', ['story' => $chapter->story_id])->with('successMessage', 'Thay đổi thành công.');
    }

    public function destroy($id)
    {
        $res = ['success' => false];

        $this->repository->delete($id);

        $res['success'] = true;

        return response()->json($res);
    }
}
