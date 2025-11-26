<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('demande_localisations_clotures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_cloture_id'); // Référence vers demandes_clotures
            $table->unsignedBigInteger('demande_id_original'); // ID original pour traçabilité
            $table->unsignedBigInteger('departement_id');
            $table->unsignedBigInteger('commune_id');
            $table->string('lieux');
            $table->integer('homme_touche');
            $table->integer('femme_touche')->nullable(); // Inclus pour cohérence avec le modèle
            $table->timestamps();

            $table->foreign('demande_cloture_id')->references('id')->on('demandes_clotures')->onDelete('cascade');
            $table->foreign('departement_id')->references('id')->on('departements')->onDelete('cascade');
            $table->foreign('commune_id')->references('id')->on('communes')->onDelete('cascade');

            // Index
            $table->index('demande_cloture_id');
            $table->index('demande_id_original');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('demande_localisations_clotures');
    }
};
