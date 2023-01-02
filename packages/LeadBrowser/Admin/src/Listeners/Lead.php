<?php

namespace LeadBrowser\Admin\Listeners;

use LeadBrowser\Mailbox\Repositories\MailboxRepository;

class Lead
{
    /**
     * MailboxRepository object
     *
     * @var \LeadBrowser\Mailbox\Repositories\MailboxRepository
     */
    protected $mailboxRepository;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Mailbox\Repositories\MailboxRepository  $mailboxRepository
     *
     * @return void
     */
    public function __construct(MailboxRepository $mailboxRepository)
    {
        $this->mailboxRepository = $mailboxRepository;
    }

    /**
     * @param  \LeadBrowser\Lead\Models\Lead  $lead
     * @return void
     */
    public function linkToEmail($lead)
    {
        if (! request('email_id')) {
            return;
        }

        $this->mailboxRepository->update([
            'lead_id' => $lead->id,
        ], request('email_id'));
    }
}