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
            'email'             => 'admin@example.com',
            'password'          => bcrypt('admin123'),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'status'            => 1,
            'role_id'           => 1,
            'view_permission'   => 'global',
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);

        /**
         * Testing user
         */
        // for ($i=0; $i < 20; $i++) { 
        //     $user = new User();
        //     $user->name        = 'Test User' . Str::random(5);
        //     $user->email       = Str::random(5) . '@konstelacja.co';
        //     $user->password    = bcrypt('password');
        //     $user->created_at  = date('Y-m-d H:i:s');
        //     $user->updated_at  = date('Y-m-d H:i:s');
        //     $user->status      = 1;
        //     $user->role_id     = 2;
        //     $user->view_permission = 'individual';
        //     $user->save();

        //     // $user->deposit(20);
        // }
    }
}
