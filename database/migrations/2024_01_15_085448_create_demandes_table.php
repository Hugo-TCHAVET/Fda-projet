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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('structure');
            $table->string('service');
            $table->string('type_demande');
            $table->string('branche')->nullable();
            $table->string('corps')->nullable();
            $table->string('metier')->nullable();
            $table->string('nom');
            $table->string('prenom');
            $table->string('sexe');
            $table->string('ifu');
            $table->string('contact');
            $table->string('titre_activite');
            $table->string('obejectif_activite');
            $table->string('debut_activite');
            $table->string('fin_activite');
            $table->string('dure_activite');
            $table->string('departement');
            $table->string('commune');
            $table->string('lieux');
            $table->string('homme_touche');
            $table->string('femme_touche');
            $table->string('budget');
            $table->string('piece');
            $table->string('buget_prevu')->default(0);
            $table->string('status')->default('En attente');
            $table->string('statut')->nullable();
            $table->string('statuts')->nullable();
            $table->string('valide')->default(0);
            $table->string('suspendre')->default(0);
            $table->string('rejeter')->default(0);
            $table->string('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Migration pour la table pivot demande_localisations
     */
    public function up_demande_localisations()
    {
        Schema::create('demande_localisations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_id');
            $table->unsignedBigInteger('departement_id');
            $table->unsignedBigInteger('commune_id');
            $table->string('lieux');
            $table->integer('homme_touche');
            $table->integer('femme_touche');
            $table->timestamps();

            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
            $table->foreign('departement_id')->references('id')->on('departements')->onDelete('cascade');
            $table->foreign('commune_id')->references('id')->on('communes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demandes');
    }
};
