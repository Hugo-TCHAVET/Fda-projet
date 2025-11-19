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
            $table->boolean('rapport_depose')->default(false)->after('buget_prevu');
            $table->integer('effectif_homme_forme')->nullable()->after('rapport_depose');
            $table->integer('effectif_femme_forme')->nullable()->after('effectif_homme_forme');
            $table->date('date_depot_rapport')->nullable()->after('effectif_femme_forme');
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
            $table->dropColumn(['rapport_depose', 'effectif_homme_forme', 'effectif_femme_forme', 'date_depot_rapport']);
        });
    }
};
