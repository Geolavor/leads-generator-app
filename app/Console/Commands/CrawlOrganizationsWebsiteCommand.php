<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use LeadBrowser\Extractor\Jobs\WebsiteCrawlerData;
use LeadBrowser\Organization\Models\Organization;

class CrawlOrganizationsWebsiteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl-organizations-website';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '1512M');
        ini_set('max_execution_time', '18880');

        $organizations = Organization::where('crawled_at', null)->limit(100)->pluck('id')->toArray();

        foreach ($organizations as $key => $organization) {
            WebsiteCrawlerData::dispatch(null, null, null, $organization);
            Log::info("Organization website was crawled: " . $key);
        }

        return 0;
    }
}
