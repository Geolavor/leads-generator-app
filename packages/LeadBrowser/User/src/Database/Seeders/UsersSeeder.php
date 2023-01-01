<?php

namespace LeadBrowser\User\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use LeadBrowser\User\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            'id'                => 1,
            'name'              => 'Mariusz Malek',
            'email'             => 'admin@leadbrowser.co',
            'password'          => bcrypt('password'),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'status'            => 1,
            'role_id'           => 1,
            'view_permission'   => 'global',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'bonus_coin'        => '500'
        ]);
    }
}
