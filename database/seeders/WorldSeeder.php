<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nnjeim\World\Actions\SeedAction;

class WorldSeeder extends Seeder
{
	public function run()
	{
		$path = public_path('./world.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
	}
}
