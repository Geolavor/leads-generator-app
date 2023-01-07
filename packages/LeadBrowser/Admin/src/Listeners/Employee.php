<?php

namespace LeadBrowser\Admin\Listeners;

use LeadBrowser\Mailbox\Repositories\MailboxRepository;

class Employee
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
     * @param  \LeadBrowser\Organization\Models\Employee  $employee
     * @return void
     */
    public function linkToEmail($employee)
    {
        if (! request('email_id')) {
            return;
        }

        $this->mailboxRepository->update([
            'employee_id' => $employee->id,
        ], request('email_id'));
    }
}