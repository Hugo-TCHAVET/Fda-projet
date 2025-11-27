<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Commune;
use App\Models\Departement;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/departements', function () {
    $departements = Departement::orderBy('nom', 'asc')->get();
    return response()->json($departements);
});

Route::get('/communes/{departement_id}', function ($departement_id) {
    $communes = Commune::where('departement_id', $departement_id)
        ->orderBy('nom', 'asc')
        ->get();
    return response()->json($communes);
});

Route::get('/corps/{branche_id}', function ($branche_id) {
    // Correction: la colonne est 'branche_id' (et non 'brache_id')
    $corps = \App\Models\Corp::where('branche_id', $branche_id)->get();
    return response()->json($corps);
});

Route::get('/metiers/{corp_id}', function ($corp_id) {
    $metiers = \App\Models\Metier::where('corp_id', $corp_id)->get();
    return response()->json($metiers);
});
