<?php

namespace LeadBrowser\Core\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocalesTableSeeder::class);
        $this->call(CMSPagesTableSeeder::class);
        $this->call(PopulationSeeder::class);
    }
}
