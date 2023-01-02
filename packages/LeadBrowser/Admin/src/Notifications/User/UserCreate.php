<?php

namespace LeadBrowser\Admin\Notifications\User;

use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class UserCreate extends Mailable
{
    use SendGrid;

    /**
     * @param  object  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the mail representation of the notification.
     */
    public function build()
    {
        return $this
            ->to($this->user->email)
            ->subject(trans('admin::app.mail.user.register-subject'))
            ->view('admin::emails.users.create', [
                'user_name' => $this->user->name,
            ]);
    }
}