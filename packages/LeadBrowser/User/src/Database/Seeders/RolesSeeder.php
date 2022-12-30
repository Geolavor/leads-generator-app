<?php

namespace LeadBrowser\User\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

        DB::table('roles')->delete();

        DB::table('roles')->insert([
            'id'              => 1,
            'name'            => 'Administrator',
            'description'     => 'Administrator role',
            'permission_type' => 'all',
        ]);

        DB::table('roles')->insert([
            'id'              => 2,
            'name'            => 'Client',
            'description'     => 'Client role',
            'permission_type' => 'custom',
            'permissions'     => '["browser", "dashboard", "search", "search.location", "search.location.text", "search.location.text.create", "search.location.text.view", "search.location.text.delete", "search.location.websites", "search.location.websites.create", "search.location.websites.view", "search.location.websites.delete", "search.database", "search.database.organizations", "search.database.organizations.view", "results", "results.view", "results.delete", "results.export", "organizations", "organizations.view", "organizations.export", "crm", "crm.leads", "crm.leads.create", "crm.leads.view", "crm.leads.edit", "crm.leads.delete", "crm.quotes", "crm.quotes.create", "crm.quotes.edit", "crm.quotes.print", "crm.quotes.delete", "crm.activities", "crm.activities.create", "crm.activities.edit", "crm.activities.delete", "crm.products", "crm.products.create", "crm.products.edit", "crm.products.delete"]',
        ]);

    }
}