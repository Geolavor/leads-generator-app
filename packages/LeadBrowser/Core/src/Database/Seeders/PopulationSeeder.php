<?php

namespace LeadBrowser\Core\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PopulationSeeder extends Seeder
{
    public function run()
    {
        DB::table('population_sources')->delete();

        DB::table('population_sources')->insert([
            [
                'id'     => 1,
                'name'   => 'Small towns',
                'number' => '50000',
            ], [
                'id'     => 2,
                'name'   => 'Medium-sized cities',
                'number' => '300000',
            ], [
                'id'     => 3,
                'name'   => 'Big cities',
                'number' => '1765000',
            ]
        ]);
    }
}