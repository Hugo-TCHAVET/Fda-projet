<?php

use App\Support\MigrationEtat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->string('etat', 20)->nullable()->index();
            $table->unsignedSmallInteger('exercice')->nullable()->index();
            $table->dateTime('cloturee_le')->nullable();
            $table->foreignId('cloturee_par')->nullable()->constrained('users')->nullOnDelete();
        });

        $resultat = MigrationEtat::remplir();
        Log::info('migration-etat', $resultat);

        DB::statement("ALTER TABLE demandes MODIFY etat VARCHAR(20) NOT NULL DEFAULT 'en_attente', MODIFY exercice SMALLINT UNSIGNED NOT NULL");
    }

    public function down()
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cloturee_par');
            $table->dropColumn(['etat', 'exercice', 'cloturee_le']);
        });
    }
};
