<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const COLONNES = ['status', 'statut', 'statuts', 'valide', 'suspendre', 'rejeter'];

    public function up()
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->dropColumn(self::COLONNES);
        });

        Schema::dropIfExists('demande_localisations_clotures');
        Schema::dropIfExists('demandes_clotures');
    }

    // The state now lives in demandes.etat and closed demandes in demandes itself: restore a backup to go back.
    // An empty down() would let the earlier rollbacks drop etat and cloturee_le, reopening every closed demande.
    public function down()
    {
        throw new RuntimeException('Retour arrière impossible : les anciennes colonnes d\'état sont supprimées. Restaurer la sauvegarde de la base.');
    }
};
