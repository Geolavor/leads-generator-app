<?php

namespace LeadBrowser\Admin\Notifications\Claim;

use LeadBrowser\Search\Models\SearchLocations;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;

class DataClaim extends Mailable
{
    /**
     * @param string $email
     * @param string $token
     * @return void
     */
    public function __construct(string $email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Build the mail representation of the notification.
     */
    public function build()
    {
        $url = env('APP_URL').'/claim/'.$this->token;
        
        return $this
            ->to($this->email)
            ->subject(trans('admin::app.mail.claim.claim-verify'))
            ->view('admin::emails.claim.claim-verify', [
                'email'   => $this->email,
                'url'     => $url
            ]);
    }
}