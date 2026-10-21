<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLES = ['demandes', 'demandes_clotures'];

    public function up()
    {
        foreach (self::TABLES as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->integer('effectif_handicape_homme')->nullable()->after('date_depot_rapport');
                $table->integer('effectif_handicape_femme')->nullable()->after('effectif_handicape_homme');
                $table->text('observations_rapport')->nullable()->after('effectif_handicape_femme');
                $table->string('rapport_fichier')->nullable()->after('observations_rapport');
            });
        }
    }

    public function down()
    {
        foreach (self::TABLES as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['effectif_handicape_homme', 'effectif_handicape_femme', 'observations_rapport', 'rapport_fichier']);
            });
        }
    }
};
