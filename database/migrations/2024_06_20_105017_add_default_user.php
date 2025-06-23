<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('users')->insert([

            [
                "name" => 'SESE FDA',
                'email' => 'sese@gmail.com',
                'password'=> Hash::make('fdan2024'),
                
            ],

            [
                "name" => 'SPEA FDA',
                'email' => 'spea@gmail.com',
                'password'=> Hash::make('fdan2024'),
                
            ],

            [
                "name" => 'DG FDA',
                'email' => 'dg@gmail.com',
                'password'=> Hash::make('fdan2024'),
                
            ],
            [
                "name" => 'DAF FDA',
                'email' => 'daf@gmail.com',
                'password'=> Hash::make('fdan2024'),
                
            ],
            [
                "name" => 'DO FDA',
                'email' => 'do@gmail.com',
                'password'=> Hash::make('fdan2024'),
                
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};