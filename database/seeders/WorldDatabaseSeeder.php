<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorldDatabaseSeeder extends Seeder
{
	public function run()
	{
		ini_set('memory_limit', '152M');

		$path = public_path('/database/world.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
	}
}
