<?php

namespace LeadBrowser\Admin\Notifications\Search;

use LeadBrowser\Search\Models\SearchLocations;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;

class LocationFinish extends Mailable
{
    /**
     * @param  object  $user
     * @return void
     */
    public function __construct($user, $searchLocations)
    {
        $this->user = $user;
        $this->searchLocations = $searchLocations;
    }

    /**
     * Build the mail representation of the notification.
     */
    public function build()
    {
        return $this
            ->to($this->user->email)
            ->subject(trans('admin::app.mail.search.location-finish'))
            ->view('admin::emails.search.location-finish', [
                'title'       => $this->searchLocations->title,
                'has_items'   => $this->searchLocations->has_items,
                'total_price' => $this->searchLocations->total_price,
                'user_name'   => $this->user->name,
            ]);
    }
}