<?php

namespace LeadBrowser\Core\Console\Commands;

use Carbon\Carbon;
use LeadBrowser\Core\Models\BlackList;
use LeadBrowser\Organization\Models\Email;
use Illuminate\Console\Command;
use Laravel\Cashier\Subscription;

class LastDaysSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'LastDaysSubscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear limits';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $subscriptions = Subscription::where('ends_at', '>', Carbon::now())->get();

        foreach ($subscriptions as $item) {
            
        }
    }
}
