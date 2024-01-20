<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rating;
use App\Repositories\Rating\RatingRepositoryInterface;
use App\Repositories\Story\StoryRepositoryInterface;
use App\Services\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct(
        protected RatingRepositoryInterface $repository,
        protected RatingService $service,
        protected StoryRepositoryInterface $storyRepository
    )
    {
        $this->middleware('can:xem_rating_data')->only('index');
        $this->middleware('can:sua_rating_data')->only('update');
    }

    public function index(Request $request)
    {
        $page_title = 'Rating';
        // $search     = $request->get('search', []);
        // $results    = $this->repository->paginate(20, [], $search);

        $stories = $this->storyRepository->getStoriesActive();
        $ratingsDay = $this->repository->getRatingByType(Rating::TYPE_DAY);
        $ratingsMonth = $this->repository->getRatingByType(Rating::TYPE_MONTH);
        $ratingsAllTime = $this->repository->getRatingByType(Rating::TYPE_ALL_TIME);
        // dd($ratings);
        
        return view('Admin.pages.rating.index', compact('stories', 'ratingsDay', 'ratingsMonth', 'ratingsAllTime'));
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

    public function update(Request $request)
    {
        // dd($request->input());
        $res = ['success' => false];
        $dataReq = $request->input();

        $dataType = [
            1 => 'day',
            2 => 'month', 
            3 => 'all_time'
        ];

        $this->service->emptyRatings();

        foreach ($dataReq as $type => $value) {
            $data = [
                'status' => Rating::STATUS_ACTIVE
            ];
            $intDataType = array_filter($dataType, function ($item) use ($type) {
                return $item == $type;
            });
            $data['type'] = array_key_first($intDataType);
            $data['value'] = json_encode($value);
            
            $save = $this->service->saveRatings($data);
        }

        $res['success'] = true;

        return response()->json($res);
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
    }
}
