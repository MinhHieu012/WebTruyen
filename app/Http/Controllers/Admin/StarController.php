<?php

namespace App\Http\Controllers\Admin;

use App\Models\Star;
use App\Repositories\Star\StarRepositoryInterface;
use App\Services\StarService;
use Illuminate\Http\Request;

class StarController extends Controller
{
    public function __construct(
        protected StarRepositoryInterface $repository,
        protected StarService $service
    ) {
    }

    public function index(Request $request)
    {
        $page_title = 'Star';
        $search     = $request->get('search', []);
        $results    = $this->repository->paginate(20, [], $search);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $attributes = $request->all();
        $item       = $this->repository->create($attributes);
    }

    public function show($id)
    {
        $item = $this->repository->find($id);
    }

    public function edit($id)
    {
        $item = $this->repository->find($id);
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->all();
        $item       = $this->repository->update($id, $attributes);
    }

    public function updateSingle(Request $request)
    {
        $request->validate(
            [
                'stars' => ['required', 'numeric'],
                'count' => ['required', 'numeric']
            ],
            [],
            [
                'stars' => 'Số sao',
                'count' => 'Tổng lượt đánh giá'
            ]
        );

        $res = ['success' => false];

        $star = $this->repository->getStarWithByStoryId(intval($request->input('story_id')));

        if (!$star) {
            $star = new Star();
        }
        $star->story_id = intval($request->input('story_id'));
        $star->controller_name = 'StoryController';
        $star->stars = $request->input('stars');
        $star->count = $request->input('count');
        $star->approved = Star::IS_APPROVED;
        
        if ($star->save()) {
            $res['success'] = true;
        }

        return response()->json($res);
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
    }
}
