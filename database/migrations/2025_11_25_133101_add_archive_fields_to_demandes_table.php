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
        Schema::table('demandes', function (Blueprint $table) {
            $table->boolean('archivee')->default(false)->after('rejeter');
            $table->integer('annee_exercice')->nullable()->after('archivee');
            $table->dateTime('date_archivage')->nullable()->after('annee_exercice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->dropColumn(['archivee', 'annee_exercice', 'date_archivage']);
        });
    }
};
