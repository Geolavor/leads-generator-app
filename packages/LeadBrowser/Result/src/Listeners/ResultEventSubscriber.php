<?php

namespace LeadBrowser\Result\Listeners;

use App\Mail\Result\ResultEditMail;
use LeadBrowser\Payment\Models\Usage;
use LeadBrowser\Result\Models\Result;
use Illuminate\Support\Facades\Auth;
use LeadBrowser\User\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResultEventSubscriber
{
    protected $user;
    protected $eventCreator;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = Auth::id() ?? 1;
    }

    /**
     * Result created listener
     */
    public function onResultCreated($event)
    {
        // event( new WalletPayed($currentUser->id, $currentUser->balance() - 1));
        // $user_id = $event->result->user_id;
        
        $result = Result::findOrFail($event->result->id);

        $user = User::findOrFail($result->user_id);

        if($user) {

            $subscription = $user->subscription;

            /**
             * Calculate wallet only when is payable
             */
            if($result->is_payable) {
                /**
                 * If user has bonus coin
                 */
                if ($user->bonus_coin > 0) {
                    // $user->update([
                    //     'bonus_coin' => DB::raw('bonus_coin - 1'),
                    // ]);
                    $user->decrement('bonus_coin');
                }

                if($subscription) {
                    Usage::where('subscription_id', $subscription['id'])->update([
                        'used' => DB::raw('used + 1'),
                    ]);
                }
                
            }
        }
    }
    /**
     * Result updated listener
     */
    public function onResultUpdated($event)
    {
    }

    /**
     * Result deleted listener
     */
    public function onResultDeleted($event)
    {
    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'LeadBrowser\Result\Events\ResultCreated',
            'LeadBrowser\Result\Listeners\ResultEventSubscriber@onResultCreated'
        );

        $events->listen(
            'LeadBrowser\Result\Events\ResultUpdated',
            'LeadBrowser\Result\Listeners\ResultEventSubscriber@onResultUpdated'
        );
        $events->listen(
            'LeadBrowser\Result\Events\ResultDeleted',
            'LeadBrowser\Result\Listeners\ResultEventSubscriber@onResultDeleted'
        );
    }
}
