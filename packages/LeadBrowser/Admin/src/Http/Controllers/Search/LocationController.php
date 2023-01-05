<?php

namespace LeadBrowser\Admin\Http\Controllers\Search;

use Illuminate\Support\Facades\Event;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Attribute\Http\Requests\AttributeForm;
use LeadBrowser\Search\Models\SearchLocations;
use LeadBrowser\Search\Repositories\SearchRepository;

class LocationController extends Controller
{
    /**
     * SearchRepository object
     *
     * @var \LeadBrowser\Search\Repositories\SearchRepository
     */
    protected $searchRepository;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Search\Repositories\SearchRepository  $searchRepository
     *
     * @return void
     */
    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;

        request()->request->add(['entity_type' => 'search']);
    }
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(\LeadBrowser\Admin\DataGrids\Search\SearchLocationDataGrid::class)->toJson();
        }

        return view('admin::search.location.index');
    }

    /**
     * Display a resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        // $search = $this->searchRepository->findOrFail($id);
        $search = SearchLocations::findOrFail($id);

        $currentUser = auth()->guard('user')->user();

        if ($currentUser->view_permission != 'global') {
            if ($currentUser->view_permission == 'group') {
                $userIds = app('\LeadBrowser\User\Repositories\UserRepository')->getCurrentUserGroupsUserIds();

                if (! in_array($search->user_id, $userIds)) {
                    return redirect()->route('search.location.index');
                }
            } else {
                if ($search->user_id != $currentUser->id) {
                    return redirect()->route('search.location.index');
                }
            }
        }

        $search['market_size'] = $search->location_market_size;

        // dd($search);

        return view('admin::search.location.view', compact('search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::search.location.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeForm $request)
    {
        Event::dispatch('search.location.text.create.before');

        $currentUser = auth()->guard('user')->user();
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

        return redirect()->route('search.location.view', $search->id);
    }

    /**
     * More a newly created resource in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @return \Illuminate\Http\Response
     */
    public function more(AttributeForm $request)
    {
        Event::dispatch('search.more.before');

        $data = request()->all();

        $search = $this->searchRepository->more($data);

        Event::dispatch('search.more.after', $search);

        session()->flash('success', trans('admin::app.search.create-success'));

        return redirect()->route('search.location.view', $search->id);
    }

    /**
     * Search search results
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $results = $this->searchRepository->findWhere([
            ['name', 'like', '%' . urldecode(request()->input('query')) . '%']
        ]);

        return response()->json($results);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $this->searchRepository->findOrFail($id);
        $location = SearchLocations::findOrFail($id);

        try {
            Event::dispatch('settings.search.delete.before', $id);

            // TODO
            // $this->searchRepository->delete($id);
            $location->delete();

            Event::dispatch('settings.search.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.search.search')]),
            ], 200);
        } catch(\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.response.destroy-failed', ['name' => trans('admin::app.search.search')]),
            ], 400);
        }
    }

    /**
     * Mass Delete the specified resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        foreach (request('rows') as $searchId) {
            Event::dispatch('search.delete.before', $searchId);

            $this->searchRepository->delete($searchId);

            Event::dispatch('search.delete.after', $searchId);
        }

        return response()->json([
            'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.search.title')]),
        ]);
    }
}
