<?php

namespace LeadBrowser\Admin\Http\Controllers\Search;

use Illuminate\Support\Facades\Event;
use LeadBrowser\Search\Repositories\SearchRepository;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Search\Models\SearchLocations;

class TagController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        Event::dispatch('search.tag.create.before', $id);

        // $search = $this->searchRepository->find($id);
        $search = SearchLocations::findOrFail($id);

        if (! $search->tags->contains(request('id'))) {
            $search->tags()->attach(request('id'));
        }

        Event::dispatch('search.tag.create.after', $search);
        
        return response()->json([
            'status'  => true,
            'message' => trans('admin::app.search.tag-create-success'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $searchId
     * @param  integer  $tagId
     * @return \Illuminate\Http\Response
     */
    public function delete($searchId)
    {
        Event::dispatch('search.tag.delete.before', $searchId);

        // $search = $this->searchRepository->find($searchId);
        $search = SearchLocations::findOrFail($searchId);

        $search->tags()->detach(request('tag_id'));

        Event::dispatch('search.tag.delete.after', $search);
        
        return response()->json([
            'status'  => true,
            'message' => trans('admin::app.search.tag-destroy-success'),
        ], 200);
    }
}