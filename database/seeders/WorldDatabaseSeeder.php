<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorldDatabaseSeeder extends Seeder
{
	public function run()
	{
		ini_set('memory_limit', '152M');

		$tables = ['world.sql', 'cities.sql'];

		foreach ($tables as $key => $table) {
			$path = public_path('/database/' . $table);
			$sql = file_get_contents($path);
			DB::unprepared($sql);
		}
	}
}
