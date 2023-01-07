<?php

namespace LeadBrowser\API\Http\Controllers\V1\Search;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use LeadBrowser\API\Http\Controllers\V1\Controller;
use LeadBrowser\API\Http\Resources\V1\Search\SearchResource;
use LeadBrowser\Search\Repositories\SearchRepository;
use LeadBrowser\User\Models\User;

class SearchLocationsController extends Controller
{
       /**
     * Search repository instance.
     *
     * @var \LeadBrowser\Search\Repositories\SearchRepository
     */
    protected $searchRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\Search\Repositories\SearchRepository  $searchRepository
     * @return void
     */
    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;

        $this->addEntityTypeInRequest('search');
    }

    /**
     * Display a listing of the searchs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 123;
        // $searchs = $this->allResources($this->searchRepository);

        // return SearchResource::collection($searchs);
    }

    /**
     * Show resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $resource = $this->searchRepository->find($id);

        return new SearchResource($resource);
    }
    
    /**
     * Get the details for current logged in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request)
    {
        Event::dispatch('search.location.text.create.before');

        $currentUser = User::where('token', $request->token)->first();

        $data = request()->all();

        /**
         * Check if User has subscription and enough usages
         */
        $subscription = $currentUser->subscription;
        $usage = $currentUser->usage;
        
        // if(!$subscription) {
        // if(auth()->user()->email_verified_at == null) {
        //     session()->flash('warning', trans('admin::app.search.create-false'));
        //     return;
        // }

        $data['user_id'] = $currentUser->id;

        /**
         * If user dosen't have enough coins in wallet
         */
        if(($currentUser->bonus_coin > 0) && $currentUser->bonus_coin < $data['expected_items'] || ($usage['available'] - $usage['used']) < $data['expected_items']) {
            session()->flash('warning', trans('admin::app.search.you-dont-have-enough-coins'));
            return redirect()->back();
        }

        $search = $this->searchRepository->create($data);

        Event::dispatch('search.location.text.create.after', $search);

        session()->flash('success', trans('admin::app.search.create-success'));

        return response([
            'data'    => new SearchResource($search),
            'message' => __('admin::app.search.create-success'),
        ]);
    }

    /**
     * Update the details for current logged in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }
}
