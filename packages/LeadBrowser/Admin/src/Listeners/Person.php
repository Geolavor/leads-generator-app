<?php

namespace LeadBrowser\Admin\Listeners;

use LeadBrowser\Mailbox\Repositories\MailboxRepository;

class Person
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
     * @param  \LeadBrowser\Organization\Models\Person  $person
     * @return void
     */
    public function linkToEmail($person)
    {
        if (! request('email_id')) {
            return;
        }

        $this->mailboxRepository->update([
            'person_id' => $person->id,
        ], request('email_id'));
    }
}