<?php

namespace LeadBrowser\API\Http\Controllers\V1\Mail;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use LeadBrowser\Mailbox\Mails\Email;
use LeadBrowser\Mailbox\Repositories\AttachmentRepository;
use LeadBrowser\Mailbox\Repositories\MailboxRepository;
use LeadBrowser\Lead\Repositories\LeadRepository;
use LeadBrowser\API\Http\Controllers\V1\Controller;
use LeadBrowser\API\Http\Resources\V1\Mailbox\EmailResource;

class EmailController extends Controller
{
    /**
     * Lead repository instance.
     *
     * @var \LeadBrowser\Mailbox\Repositories\LeadRepository
     */
    protected $leadRepository;

    /**
     * Email repository instance.
     *
     * @var \LeadBrowser\Mailbox\Repositories\MailboxRepository
     */
    protected $mailboxRepository;

    /**
     * Attachment repository instance.
     *
     * @var \LeadBrowser\Mailbox\Repositories\AttachmentRepository
     */
    protected $attachmentRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\Lead\Repositories\LeadRepository  $leadRepository
     * @param  \LeadBrowser\Mailbox\Repositories\MailboxRepository  $mailboxRepository
     * @param  \LeadBrowser\Mailbox\Repositories\AttachmentRepository  $attachmentRepository
     * @return void
     */
    public function __construct(
        LeadRepository $leadRepository,
        MailboxRepository $mailboxRepository,
        AttachmentRepository $attachmentRepository
    ) {
        $this->leadRepository = $leadRepository;

        $this->mailboxRepository = $mailboxRepository;

        $this->attachmentRepository = $attachmentRepository;
    }

    /**
     * Display a listing of the emails.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = $this->allResources($this->mailboxRepository);

        return EmailResource::collection($emails);
    }

    /**
     * Show resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $resource = $this->mailboxRepository->find($id);

        return new EmailResource($resource);
    }

    /**
     * Store a newly created email in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'reply_to' => 'required|array|min:1',
            'reply'    => 'required',
        ]);

        Event::dispatch('email.create.before');

        $uniqueId = time() . '@' . config('mail.domain');

        $referenceIds = [];

        if ($parentId = request('parent_id')) {
            $parent = $this->mailboxRepository->findOrFail($parentId);

            $referenceIds = $parent->reference_ids ?? [];
        }

        $email = $this->mailboxRepository->create(array_merge(request()->all(), [
            'source'        => 'web',
            'from'          => config('mail.from.address'),
            'user_type'     => 'admin',
            'folders'       => request('is_draft') ? ['draft'] : ['outbox'],
            'name'          => auth()->guard()->user()->name,
            'unique_id'     => $uniqueId,
            'message_id'    => $uniqueId,
            'reference_ids' => array_merge($referenceIds, [$uniqueId]),
            'user_id'       => auth()->guard()->user()->id,
        ]));

        if (! request('is_draft')) {
            try {
                Mail::send(new Email($email));

                $this->mailboxRepository->update([
                    'folders' => ['inbox', 'sent'],
                ], $email->id);
            } catch (\Exception $e) {}
        }

        Event::dispatch('email.create.after', $email);

        if (request('is_draft')) {
            return response([
                'data'    => new EmailResource($email),
                'message' => __('admin::app.mail.saved-to-draft'),
            ]);
        }

        return response([
            'data'    => new EmailResource($email),
            'message' => __('admin::app.mail.create-success'),
        ]);
    }

    /**
     * Update the specified email in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        Event::dispatch('email.update.before', $id);

        $data = request()->all();

        if (! is_null(request('is_draft'))) {
            $data['folders'] = request('is_draft') ? ['draft'] : ['outbox'];
        }

        $email = $this->mailboxRepository->update($data, request('id') ?? $id);

        Event::dispatch('email.update.after', $email);

        if (! is_null(request('is_draft')) && ! request('is_draft')) {
            try {
                Mail::send(new Email($email));

                $this->mailboxRepository->update([
                    'folders' => ['inbox', 'sent'],
                ], $email->id);
            } catch (\Exception $e) {}
        }

        if (! is_null(request('is_draft'))) {
            if (request('is_draft')) {
                return response([
                    'data'    => new EmailResource($email),
                    'message' => __('admin::app.mail.saved-to-draft'),
                ]);
            } else {
                return response([
                    'data'    => new EmailResource($email),
                    'message' => __('admin::app.mail.create-success'),
                ]);
            }
        }

        $response = [
            'data'    => new EmailResource($email),
            'message' => __('admin::app.mail.update-success'),
        ];

        if (request('lead_id')) {
            $response['html'] = view('admin::common.custom-attributes.view', [
                'customAttributes' => app('LeadBrowser\Attribute\Repositories\AttributeRepository')->findWhere([
                    'entity_type' => 'leads',
                ]),
                'entity'           => $this->leadRepository->find(request('lead_id')),
            ])->render();
        }

        return response($response);
    }

    /**
     * Remove the specified email from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Event::dispatch('email.' . request('type') . '.before', $id);

            if (request('type') == 'trash') {
                $this->mailboxRepository->update([
                    'folders' => ['trash'],
                ], $id);
            } else {
                $this->mailboxRepository->delete($id);
            }

            Event::dispatch('email.' . request('type') . '.after', $id);

            return response([
                'message' => __('admin::app.mail.delete-success'),
            ]);
        } catch (\Exception $exception) {
            return response([
                'message' => __('admin::app.mail.delete-failed'),
            ], 500);
        }
    }

    /**
     * Mass update the specified emails.
     *
     * @return \Illuminate\Http\Response
     */
    public function massUpdate()
    {
        foreach (request('rows') as $emailId) {
            Event::dispatch('email.update.before', $emailId);

            $this->mailboxRepository->update([
                'folders' => request('folders'),
            ], $emailId);

            Event::dispatch('email.update.after', $emailId);
        }

        return response([
            'message' => __('admin::app.mail.mass-update-success'),
        ]);
    }

    /**
     * Mass delete the specified emails.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        foreach (request('rows') as $emailId) {
            Event::dispatch('email.' . request('type') . '.before', $emailId);

            if (request('type') == 'trash') {
                $this->mailboxRepository->update([
                    'folders' => ['trash'],
                ], $emailId);
            } else {
                $this->mailboxRepository->delete($emailId);
            }

            Event::dispatch('email.' . request('type') . '.after', $emailId);
        }

        return response([
            'message' => __('admin::app.mail.destroy-success'),
        ]);
    }

    /**
     * Download file from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $attachment = $this->attachmentRepository->findOrFail($id);

        return Storage::download($attachment->path);
    }
}
