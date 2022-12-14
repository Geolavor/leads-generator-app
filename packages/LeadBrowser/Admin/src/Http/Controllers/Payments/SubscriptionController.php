<?php

declare(strict_types=1);

namespace LeadBrowser\Admin\Http\Controllers\Payments;

use Carbon\Carbon;
use Illuminate\Http\Request;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Payment\Models\Plan;
use LeadBrowser\Payment\Models\Usage;
use LeadBrowser\Payment\Repositories\PlanRepository;
use LeadBrowser\User\Models\User;

class SubscriptionController extends Controller
{   
    protected $stripe;

    /**
     * Role repository instance.
     *
     * @var \LeadBrowser\User\Repositories\PlanRepository
     */
    protected $planRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\User\Repositories\PlanRepository  $planRepository
     * @return void
     */
    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function create(Request $request)
    {
        // $request->get('plan');
        $plan = Plan::findOrFail($request->plan_id);
        
        $user = $request->user();

        if ($user->subscribed($plan->name)) {
            return redirect()->route('plans.index')->with('success', 'You are already subscribed to this plan');
        }

        $paymentMethod = $request->input('payment_method');

        $subscription = $user->newSubscription($plan->name, $plan->stripe_plan)->create($paymentMethod);

        if ($request->input('promotion_code')) {
            $subscription = $subscription->withPromotionCode($request->input('promotion_code'));
        }

        /**
         * 
         */
        Usage::create([
            'subscription_id'   => $subscription->id,
            'feature_id'        => 1,
            'used'              => 0,
            'limit'             => $plan->value
        ]);

        $user->update([
            'line1'         => $request->line1,
            'line2'         => $request->line2,
            'city'          => $request->city,
            'state'         => $request->state,
            'country'       => $request->country,
            'postal_code'   => $request->postal_code,
            'trial_ends_at' => Carbon::now()->subDays(30),
        ]);
        
        return redirect()->route('plans.index')->with('success', 'Your plan subscribed successfully');
    }

    public function update($subscription)
    {
        $user = User::findOrFail(auth()->guard('user')->user()->id);

        $user->subscription($subscription)->resume();

        return redirect()->route('plans.index')->with('success', "You resumed your $subscription subscription!");
    }

    public function destroy($subscription)
    {
        $user = User::findOrFail(auth()->guard('user')->user()->id);

        if($user){
            $user->subscription($subscription)->cancelNow();
        }

        return redirect()->route('plans.index')->with('success', 'You successfully cancelled you subscription!');
    }
}