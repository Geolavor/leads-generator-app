<?php

namespace LeadBrowser\Mailbox\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailbox extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Mailbox instance.
     *
     * @var  \LeadBrowser\Mailbox\Contracts\Mailbox  $mailbox
     */
    public $mailbox;

    /**
     * Create a new mailbox instance.
     *
     * @param  \LeadBrowser\Mailbox\Contracts\Mailbox  $mailbox
     * @return void
     */
    public function __construct($mailbox)
    {
        $this->mailbox = $mailbox;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->to($this->mailbox->reply_to)
            ->replyTo($this->mailbox->parent_id ? $this->mailbox->parent->unique_id : $this->mailbox->unique_id)
            ->cc($this->mailbox->cc ?? [])
            ->bcc($this->mailbox->bcc ?? [])
            ->subject($this->mailbox->parent_id ? $this->mailbox->parent->subject : $this->mailbox->subject)
            ->html($this->mailbox->reply);
        
        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader('Message-ID', $this->mailbox->message_id);

            $message->getHeaders()->addTextHeader('References', $this->mailbox->parent_id
                ? implode(' ', $this->mailbox->parent->reference_ids)
                : implode(' ', $this->mailbox->reference_ids)
            );
        });

        foreach ($this->mailbox->attachments as $attachment) {
            $this->attachFromStorage($attachment->path);
        }

        return $this;
    }
}