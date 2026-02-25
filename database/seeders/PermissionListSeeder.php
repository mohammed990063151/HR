<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionListSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permission_lists')->insert([
            ['permission_name'=>'Holidays','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'Y','import'=>'Y','export'=>'N'],
            ['permission_name'=>'Leaves','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'N','import'=>'N','export'=>'N'],
            ['permission_name'=>'Clients','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'N','import'=>'N','export'=>'N'],
            ['permission_name'=>'Projects','read'=>'Y','write'=>'N','create'=>'Y','delete'=>'N','import'=>'N','export'=>'N'],
            ['permission_name'=>'Tasks','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'Y','import'=>'N','export'=>'N'],
            ['permission_name'=>'Chats','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'Y','import'=>'N','export'=>'N'],
            ['permission_name'=>'Assets','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'Y','import'=>'N','export'=>'N'],
            ['permission_name'=>'Timing Sheets','read'=>'Y','write'=>'Y','create'=>'Y','delete'=>'Y','import'=>'N','export'=>'N'],
        ]);
    }
}
