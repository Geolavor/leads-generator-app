<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NamesDatabaseSeeder extends Seeder
{
	public function run()
	{
		ini_set('memory_limit', '152M');

		$path = public_path('/database/names.sql');
		$sql = file_get_contents($path);
		DB::unprepared($sql);
	}
}
