<?php

namespace LeadBrowser\Core\Console\Commands;

use LeadBrowser\Core\Models\BlackList;
use LeadBrowser\Organization\Models\Email;
use Illuminate\Console\Command;

class ClearByBlackList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ClearByBlacklist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all emails by blacklist';

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
        $black_list = BlackList::where('status_id', 2)->get();

        foreach ($black_list as $item) {
            $email = Email::where('email', $item->email)->first();
            $email->delete();
        }
    }
}
