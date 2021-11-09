<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [];
        $admin = [];

        $user[] = [
            'name'        => 'user',
            'guard_name'  =>'web',
        ];
        $admin[] = [
            'name'        => 'admin',
            'guard_name'  =>'web',
        ];
        DB::table('roles')->insert($user);
        DB::table('roles')->insert($admin);
    }
}
