<?php

namespace LeadBrowser\Admin\Http\Controllers\Lead;

use Illuminate\Support\Facades\Event;
use LeadBrowser\Lead\Repositories\LeadRepository;
use LeadBrowser\Quote\Repositories\QuoteRepository;
use LeadBrowser\Admin\Http\Controllers\Controller;

class QuoteController extends Controller
{
    /**
     * LeadRepository object
     *
     * @var \LeadBrowser\Lead\Repositories\LeadRepository
     */
    protected $leadRepository;

    /**
     * QuoteRepository object
     *
     * @var \LeadBrowser\Quote\Repositories\QuoteRepository
     */
    protected $quoteRepository;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Lead\Repositories\LeadRepository  $leadRepository
     * @param \LeadBrowser\Quote\Repositories\QuoteRepository  $quoteRepository
     *
     * @return void
     */
    public function __construct(
        LeadRepository $leadRepository,
        QuoteRepository $quoteRepository
    )
    {
        $this->leadRepository = $leadRepository;

        $this->quoteRepository = $quoteRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        Event::dispatch('leads.quote.create.before');

        $lead = $this->leadRepository->find($id);

        if (! $lead->quotes->contains(request('id'))) {
            $lead->quotes()->attach(request('id'));
        }

        Event::dispatch('leads.quote.create.after', $lead);
        
        return response()->json([
            'message' => trans('admin::app.leads.quote-create-success'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $leadId
     * @param  integer  $tagId
     * @return \Illuminate\Http\Response
     */
    public function delete($leadId)
    {
        Event::dispatch('leads.quote.delete.before', $leadId);

        $lead = $this->leadRepository->find($leadId);

        $lead->quotes()->detach(request('quote_id'));

        Event::dispatch('leads.quote.delete.after', $lead);
        
        return response()->json([
            'message' => trans('admin::app.leads.quote-destroy-success'),
        ], 200);
    }
}