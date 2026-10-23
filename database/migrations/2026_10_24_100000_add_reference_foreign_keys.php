<?php

use App\Support\Orphelins;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const REFERENCES = [
        'branche' => ['branche_id', 'braches'],
        'corps' => ['corps_id', 'corps'],
        'metier' => ['metier_id', 'metiers'],
    ];

    public function up()
    {
        foreach (self::REFERENCES as $colonne => [, $table]) {
            $orphelins = Orphelins::neutraliser('demandes', $colonne, $table);
            if ($orphelins !== []) {
                Log::warning('orphelins-references', ['colonne' => $colonne, 'orphelins' => $orphelins]);
            }
        }

        // One statement: MySQL DDL commits implicitly, so a column-by-column rename could stop half done.
        $changements = collect(self::REFERENCES)
            ->map(fn ($cible, $colonne) => "CHANGE {$colonne} {$cible[0]} BIGINT UNSIGNED NULL")
            ->implode(', ');
        DB::statement("ALTER TABLE demandes {$changements}");

        Schema::table('demandes', function (Blueprint $table) {
            foreach (self::REFERENCES as [$nouvelle, $reference]) {
                $table->foreign($nouvelle)->references('id')->on($reference)->nullOnDelete();
            }
        });
    }

    public function down()
    {
        Schema::table('demandes', function (Blueprint $table) {
            foreach (self::REFERENCES as [$nouvelle]) {
                $table->dropForeign([$nouvelle]);
                // MySQL named the index it created for the foreign key after the constraint.
                $table->dropIndex("demandes_{$nouvelle}_foreign");
            }
        });

        $changements = collect(self::REFERENCES)
            ->map(fn ($cible, $colonne) => "CHANGE {$cible[0]} {$colonne} VARCHAR(255) NULL")
            ->implode(', ');
        DB::statement("ALTER TABLE demandes {$changements}");
    }
};
