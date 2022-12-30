<?php

namespace LeadBrowser\Admin\Notifications\Contact;

use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class ContactForm extends Mailable
{
    use SendGrid;

    /**
     * @param string $email
     * @param string $subject
     * @param string $content
     * @return void
     */
    public function __construct($email, $subject, $content)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the mail representation of the notification.
     */
    public function build()
    {
        return $this
            ->to('mariusz@konstelacja.co')
            ->from('mariusz@konstelacja.co')
            ->subject('[contactform] ' . $this->subject)
            // ->tag('contact')
            ->view('admin::emails.contact.create', [
                'email' => $this->email,
                'subject' => $this->subject,
                'content' => $this->content,
            ]);
    }
}