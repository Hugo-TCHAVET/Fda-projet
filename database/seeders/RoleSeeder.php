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
        DB::table('users')->where('email', 'secretaire@gmail.com')->update(['role' => 'secretaire']);
        DB::table('users')->whereIn('email', ['sese@gmail.com', 'do@gmail.com'])->update(['role' => 'verificateur']);
        DB::table('users')->whereIn('email', ['spea@gmail.com', 'dg@gmail.com', 'daf@gmail.com'])->update(['role' => 'directeur']);
    }
}
