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
        Schema::table('demande_localisations_clotures', function (Blueprint $table) {
            $table->dropColumn('femme_touche');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demande_localisations_clotures', function (Blueprint $table) {
            $table->integer('femme_touche')->nullable();
        });
    }
};
