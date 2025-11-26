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
        Schema::create('demandes_clotures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_id_original'); // ID original de la demande
            
            // Tous les champs de la table demandes
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
            $table->string('contact')->nullable();
            $table->string('titre_activite');
            $table->string('obejectif_activite');
            $table->string('debut_activite')->nullable();
            $table->string('fin_activite')->nullable();
            $table->string('dure_activite')->nullable();
            $table->string('departement')->nullable();
            $table->string('commune')->nullable();
            $table->string('lieux')->nullable();
            $table->string('homme_touche')->nullable();
            $table->string('budget');
            $table->string('piece')->nullable();
            $table->string('buget_prevu')->default('0');
            $table->boolean('rapport_depose')->default(false);
            $table->integer('effectif_homme_forme')->nullable();
            $table->integer('effectif_femme_forme')->nullable();
            $table->dateTime('date_depot_rapport')->nullable();
            $table->string('status')->default('En attente');
            $table->string('statut')->nullable();
            $table->string('statuts')->nullable();
            $table->string('valide')->default('0');
            $table->string('suspendre')->default('0');
            $table->string('rejeter')->default('0');
            $table->boolean('archivee')->default(false);
            $table->integer('annee_exercice')->nullable();
            $table->dateTime('date_archivage')->nullable();
            $table->string('message')->nullable();
            $table->timestamp('date_transmission')->nullable();
            $table->dateTime('date_approbation')->nullable();
            $table->timestamps(); // created_at et updated_at
            
            // Champs spécifiques à la clôture
            $table->integer('annee_exercice_cloture');
            $table->dateTime('date_cloture');
            $table->unsignedBigInteger('user_id_cloture')->nullable();
            
            // Index pour améliorer les performances
            $table->index('annee_exercice_cloture');
            $table->index('demande_id_original');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demandes_clotures');
    }
};
