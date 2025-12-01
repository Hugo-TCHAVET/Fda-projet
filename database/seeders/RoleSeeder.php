<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('users')->where('email', 'secretaire@apps.fda.bj')->update(['role' => 'secretaire']);
        DB::table('users')->whereIn('email', ['sese@apps.fda.bj', 'do@apps.fda.bj'])->update(['role' => 'verificateur']);
        DB::table('users')->whereIn('email', ['spea@apps.fda.bj', 'dg@gmail.com', 'daf@apps.fda.bj'])->update(['role' => 'directeur']);
    }
}
