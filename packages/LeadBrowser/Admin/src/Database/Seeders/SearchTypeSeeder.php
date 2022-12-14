<?php

namespace LeadBrowser\Admin\Database\Seeders;

use Carbon\Carbon;
use LeadBrowser\Lead\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SearchTypeSeeder extends Seeder
{

    public function run()
    {

        // $now = Carbon::now();

        // DB::table('search_types')->delete();

        // $data = [];
        // $csv = array_map("str_getcsv", file("/Users/mariusz/Desktop/leadbrowser/storage/database/types.csv")); 
        // $header = array_shift($csv); 

        // $code = array_search("code", $header, true);
        // $name = array_search("name", $header, true);

        // DB::table('search_types')->delete();

        // foreach ($csv as $key => $row) {

        //     $num = (string)$row[$code];

        //     if (!isset($num)) continue;

        //     $val = $num;

        //     if (strlen($num) >= 4) {
        //         $num = substr($num, 0, -2);
        //     }

        //     $data = [
        //         'id'            => $val,
        //         'parent_id'     => $num == $val ? 0 : $num,
        //         'name'          => $row[$name],
        //         'rate'          => 0,
        //         'created_at'    => $now,
        //         'updated_at'    => $now,
        //     ];

        //     DB::table('search_types')->insert($data);
        // }

    }
}