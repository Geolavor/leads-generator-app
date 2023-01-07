<?php

namespace LeadBrowser\Admin\Http\Controllers\Mailbox;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use LeadBrowser\Mailbox\Mails\Mailbox;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Lead\Repositories\LeadRepository;
use LeadBrowser\Mailbox\Repositories\MailboxRepository;
use LeadBrowser\Mailbox\Repositories\AttachmentRepository;

class MailboxController extends Controller
{
    /**
     * LeadRepository object
     *
     * @var \LeadBrowser\Mailbox\Repositories\LeadRepository
     */
    protected $leadRepository;

    /**
     * MailboxRepository object
     *
     * @var \LeadBrowser\Mailbox\Repositories\MailboxRepository
     */
    protected $mailboxRepository;

    /**
     * AttachmentRepository object
     *
     * @var \LeadBrowser\Mailbox\Repositories\AttachmentRepository
     */
    protected $attachmentRepository;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Lead\Repositories\LeadRepository  $leadRepository
     * @param \LeadBrowser\Mailbox\Repositories\MailboxRepository  $mailboxRepository
     * @param \LeadBrowser\Mailbox\Repositories\AttachmentRepository  $attachmentRepository
     *
     * @return void
     */
    public function __construct(
        LeadRepository $leadRepository,
        MailboxRepository $mailboxRepository,
        AttachmentRepository $attachmentRepository
    )
    {
        $this->leadRepository = $leadRepository;

        $this->mailboxRepository = $mailboxRepository;

        $this->attachmentRepository = $attachmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (! request('route')) {
            return redirect()->route('mail.index', ['route' => 'inbox']);
        }

        if (! bouncer()->hasPermission('mail.' . request('route'))) {
            abort(401, 'This action is unauthorized');
        }

        switch (request('route')) {
            case 'compose':
                return view('admin::mail.compose');

            default:
                if (request()->ajax()) {
                    return app(\LeadBrowser\Admin\DataGrids\Mailbox\MailboxDataGrid::class)->toJson();
                }

                return view('admin::mail.index');
        }
    }

    /**
     * Display a resource.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $mailbox = $this->mailboxRepository
                ->with(['mailboxs', 'attachments', 'mailboxs.attachments', 'lead', 'employee'])
                ->findOrFail(request('id'));

        if (request('route') == 'draft') {
            return view('admin::mail.compose', compact('mailbox'));
        } else {
            return view('admin::mail.view', compact('mailbox'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'reply_to' => 'required|array|min:1',
            'reply'    => 'required',
        ]);

        Event::dispatch('mailbox.create.before');

        $uniqueId = time() . '@' . config('mail.domain');

        $referenceIds = [];

        if ($parentId = request('parent_id')) {
            $parent = $this->mailboxRepository->findOrFail($parentId);

            $referenceIds = $parent->reference_ids ?? [];
        }

        $mailbox = $this->mailboxRepository->create(array_merge(request()->all(), [
            'source'        => 'web',
            'from'          => config('mail.from.address'),
            'user_type'     => 'admin',
            'folders'       => request('is_draft') ? ['draft'] : ['outbox'],
            'name'          => auth()->guard('user')->user()->name,
            'unique_id'     => $uniqueId,
            'message_id'    => $uniqueId,
            'reference_ids' => array_merge($referenceIds, [$uniqueId]),
            'user_id'       => auth()->guard('user')->user()->id,
        ]));

        if (! request('is_draft')) {
            try {
                Mail::send(new Mailbox($mailbox));

                $this->mailboxRepository->update([
                    'folders' => ['inbox', 'sent']
                ], $mailbox->id);
            } catch (\Exception $e) {}
        }

        Event::dispatch('mailbox.create.after', $mailbox);

        if (request('is_draft')) {
            session()->flash('success', trans('admin::app.mail.saved-to-draft'));

            return redirect()->route('mail.index', ['route' => 'draft']);
        }

        session()->flash('success', trans('admin::app.mail.create-success'));

        return redirect()->route('mail.index', ['route'   => 'inbox']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        Event::dispatch('mailbox.update.before', $id);

        $data = request()->all();

        if (! is_null(request('is_draft'))) {
            $data['folders'] = request('is_draft') ? ['draft'] : ['outbox'];
        }

        $mailbox = $this->mailboxRepository->update($data, request('id') ?? $id);

        Event::dispatch('mailbox.update.after', $mailbox);

        if (! is_null(request('is_draft')) && ! request('is_draft')) {
            try {
                Mail::send(new Mailbox($mailbox));

                $this->mailboxRepository->update([
                    'folders' => ['inbox', 'sent']
                ], $mailbox->id);
            } catch (\Exception $e) {}
        }

        if (! is_null(request('is_draft'))) {
            if (request('is_draft')) {
                session()->flash('success', trans('admin::app.mail.saved-to-draft'));

                return redirect()->route('mail.index', ['route' => 'draft']);
            } else {
                session()->flash('success', trans('admin::app.mail.create-success'));

                return redirect()->route('mail.index', ['route' => 'inbox']);
            }
        }

        if (request()->ajax()) {
            $response = [
                'message' => trans('admin::app.mail.update-success'),
            ];

            if (request('lead_id')) {
                $response['html'] = view('admin::common.custom-attributes.view', [
                    'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                        'entity_type' => 'leads',
                    ]),
                    'entity'           => $this->leadRepository->find(request('lead_id')),
                ])->render();
            }

            return response()->json($response);
        } else {
            session()->flash('success', trans('admin::app.mail.update-success'));

            return redirect()->back();

        }
    }

    /**
     * Run process inbound parse mailbox
     *
     * @return \Illuminate\Http\Response
     */
    public function inboundParse()
    {
        $mailboxContent = file_get_contents(base_path('mailbox.txt'));

        $this->mailboxRepository->processInboundParseMail($mailboxContent);

        return response()->json([], 200);
    }

    /**
     * Download file from storage
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function download($id)
    {
        $attachment = $this->attachmentRepository->findOrFail($id);

        return Storage::download($attachment->path);
    }

    /**
     * Mass Update the specified resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function massUpdate()
    {
        foreach (request('rows') as $mailboxId) {
            Event::dispatch('mailbox.update.before', $mailboxId);

            $this->mailboxRepository->update([
                'folders' => request('folders'),
            ], $mailboxId);

            Event::dispatch('mailbox.update.after', $mailboxId);
        }

        return response()->json([
            'message' => trans('admin::app.mail.mass-update-success'),
        ]);
    }

    /*
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mailbox = $this->mailboxRepository->findOrFail($id);

        try {
            Event::dispatch('mailbox.' . request('type') . '.before', $id);

            $parentId = $mailbox->parent_id;

            if (request('type') == 'trash') {
                $this->mailboxRepository->update([
                    'folders' => ['trash'],
                ], $id);
            } else {
                $this->mailboxRepository->delete($id);
            }

            Event::dispatch('mailbox.' . request('type') . '.after', $id);

            if (request()->ajax()) {
                return response()->json([
                    'message' => trans('admin::app.mail.delete-success'),
                ], 200);
            } else {
                session()->flash('success', trans('admin::app.mail.delete-success'));

                if ($parentId) {
                    return redirect()->back();
                } else {
                    return redirect()->route('mail.index', ['route' => 'inbox']);
                }
            }
        } catch(\Exception $exception) {
            if (request()->ajax()) {
                return response()->json([
                    'message' => trans('admin::app.mail.delete-failed'),
                ], 400);
            } else {
                session()->flash('warning', trans('admin::app.mail.delete-failed'));

                return redirect()->back();
            }
        }
    }

    /**
     * Mass Delete the specified resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        foreach (request('rows') as $mailboxId) {
            Event::dispatch('mailbox.' . request('type') . '.before', $mailboxId);

            if (request('type') == 'trash') {
                $this->mailboxRepository->update([
                    'folders' => ['trash'],
                ], $mailboxId);
            } else {
                $this->mailboxRepository->delete($mailboxId);
            }

            Event::dispatch('mailbox.' . request('type') . '.after', $mailboxId);
        }

        return response()->json([
            'message' => trans('admin::app.mail.destroy-success'),
        ]);
    }
}
