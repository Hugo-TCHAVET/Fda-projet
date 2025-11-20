<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Brache;
use App\Models\Corp;
use App\Models\Metier;

echo "=== TEST DES RELATIONS ===\n";

// Test 1: Vérifier les branches
echo "Branches:\n";
$branches = Brache::all();
foreach ($branches as $branche) {
    echo "- ID: {$branche->id}, Nom: {$branche->nom}\n";
}

// Test 2: Vérifier les corps de métier
echo "\nCorps de métier:\n";
$corps = Corp::all();
foreach ($corps as $corp) {
    echo "- ID: {$corp->id}, Nom: {$corp->nom}, Branche ID: {$corp->branche_id}\n";
}

// Test 3: Vérifier les métiers
echo "\nMétiers (premiers 5):\n";
$metiers = Metier::take(5)->get();
foreach ($metiers as $metier) {
    echo "- ID: {$metier->id}, Nom: {$metier->nom}, Branche ID: {$metier->branche_id}, Corp ID: {$metier->corp_id}\n";
}

// Test 4: Vérifier une branche spécifique avec ses corps
echo "\nTest d'une branche avec ses corps:\n";
$branche = Brache::with('corps')->first();
if ($branche) {
    echo "Branche: {$branche->nom} (ID: {$branche->id})\n";
    echo "Corps: " . $branche->corps->count() . "\n";
    foreach ($branche->corps as $corp) {
        echo "  - {$corp->nom}\n";
    }
} 