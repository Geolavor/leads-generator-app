<?php

namespace LeadBrowser\Integrations\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use LeadBrowser\User\Models\User;

class IntegrationsSeeder extends Seeder
{
    public function run()
    {
        DB::table('integrations')->delete();

        $list = [
            ['name' => 'gmail', 'image' => 'gmail.png'],
            ['name' => 'hubspot', 'image' => 'hubspot.svg'],
            ['name' => 'integromat', 'image' => 'integromat.png'],
            ['name' => 'intercom', 'image' => 'intercom.svg'],
            ['name' => 'pipedrive', 'image' => 'pipedrive.svg'],
            ['name' => 'salesforce', 'image' => 'salesforce.svg'],
            ['name' => 'slack', 'image' => 'slack.svg'],
            ['name' => 'trello', 'image' => 'trello.svg'],
            ['name' => 'zapier', 'image' => 'zapier.svg'],
            ['name' => 'zoho', 'image' => 'zogo.png']
        ];

        foreach ($list as $value) {
            DB::table('integrations')->insert([
                'name' => $value['name'],
                'image' => $value['image'],
                'source' => 'url-api-token',
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

    }
}
