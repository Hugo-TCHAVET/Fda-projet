<?php

use App\Support\ReintegrationClotures;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('demandes_clotures')) {
            return;
        }

        Log::info('reintegration-clotures', ReintegrationClotures::executer());
    }

    // The *_clotures tables are kept until the legacy columns are dropped, so a rollback only needs a database restore.
    public function down()
    {
        throw new RuntimeException('Retour arrière impossible : les dossiers clôturés ont été réintégrés dans demandes. Restaurer la sauvegarde de la base.');
    }
};
