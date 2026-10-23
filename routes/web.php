<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RapportAllocationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Client.index');
})->middleware('guest');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('Admin.index');
    })->name('home')->middleware('can:view-dashboard');

    // Routes protégées par Gates
    Route::get('/liste_demande', [AdminController::class, 'ListeDemande'])
        ->name('liste.demande')
        ->middleware('can:view-liste-demandes');

    Route::get('/demande_verifier', [AdminController::class, 'DemandeVerifier'])
        ->name('demande.verifier')
        ->middleware('can:view-demandes-verifiees');

    Route::get('/demande_approuve', [AdminController::class, 'DemandeApprouve'])
        ->name('demande.approve')
        ->middleware('can:view-demandes-approuvees');

    Route::get('/demande_suspendu', [AdminController::class, 'DemandeSuspendu'])
        ->name('demande.suspendu')
        ->middleware('can:view-demandes-suspendues');

    Route::get('/suivi-demandes', [AdminController::class, 'suiviDemandes'])
        ->name('suivi.demandes')
        ->middleware('can:view-suivi-demandes');

    Route::get('/statistiques', [AdminController::class, 'statistiques'])
        ->name('statistiques.admin')
        ->middleware('can:view-statistiques');

    Route::get('/post-appui', [AdminController::class, 'postAppui'])
        ->name('post-appui')
        ->middleware('can:view-post-appui');

    Route::get('/exercices_clotures', [AdminController::class, 'ExercicesClotures'])
        ->name('exercices.clotures')
        ->middleware('can:view-dossiers-clotures');

    // Routes communes (accessibles selon les permissions définies)
    Route::get('/detail_demande/{id}', [AdminController::class, 'show'])
        ->name('demande.show')
        ->middleware('can:view-demande-details');
    Route::post('/demandes/{id}/transmission', [AdminController::class, 'transmettre'])
        ->name('demande.transmettre')
        ->middleware('can:transmit-demandes');
    Route::get('/suspendre_demande/{id}', [AdminController::class, 'Suspendre'])
        ->name('demande.message')
        ->middleware('can:process-demandes');
    Route::post('/suspendre/{id}', [AdminController::class, 'updateMessage'])
        ->name('demande.suspendre')
        ->middleware('can:process-demandes');

    Route::delete('/demandes/{id}', [AdminController::class, 'supprimer'])
        ->name('demande.delete')
        ->middleware('can:manage-demandes');

    Route::get('/edit_demande/{id}', [AdminController::class, 'edit'])
        ->name('demande.edit')
        ->middleware('can:manage-demandes');
    Route::put('/update_demande/{id}', [AdminController::class, 'updateDemande'])
        ->name('update.demande')
        ->middleware('can:manage-demandes');

    Route::get('/budget_demande/{id}', [AdminController::class, 'Budget'])
        ->name('demande.budget')
        ->middleware('can:process-demandes');
    Route::post('/budget/{id}', [AdminController::class, 'updateBudget'])
        ->name('demande.prixbudget')
        ->middleware('can:process-demandes');
    Route::get('/pdf/{id}', [AdminController::class, 'generatePdfForDemande'])
        ->name('demande.pdf')
        ->middleware('can:manage-demandes');

    Route::get('/telecharger_piece/{id}', [AdminController::class, 'telecharger'])
        ->name('demande.piece')
        ->middleware('can:manage-demandes');

    Route::get('/detail_demande_cloture/{id}', [AdminController::class, 'showCloture'])
        ->name('demande.cloture.show')
        ->middleware('can:view-dossiers-clotures');
    Route::get('/pdf_cloture/{id}', [AdminController::class, 'generatePdfForDemandeCloture'])
        ->name('demande.cloture.pdf')
        ->middleware('can:view-dossiers-clotures');
    Route::get('/telecharger_piece_cloture/{id}', [AdminController::class, 'telechargerCloture'])
        ->name('demande.cloture.piece')
        ->middleware('can:view-dossiers-clotures');

    Route::get('/rapport_allocation/{id}/fiche', [RapportAllocationController::class, 'fiche'])
        ->name('rapport.fiche')
        ->middleware('can:view-post-appui');
    Route::get('/rapport_allocation/{id}/fichier', [RapportAllocationController::class, 'fichier'])
        ->name('rapport.fichier')
        ->middleware('can:view-post-appui');

    Route::get('/formulaire', [ClientController::class, 'Formulaire'])->name('client.formulaire')->middleware('can:view-formulaire');
    Route::post('/demande/store', [ClientController::class, 'store'])->name('demande.store')->middleware('can:view-formulaire');
    // Route::get('/demande_archivee', [AdminController::class, 'DemandeArchivee'])->name('demande.archivee');
});


Route::get('/service', [ClientController::class, 'index'])->name('client.service');

Route::get('/contact', [ClientController::class, 'Contact'])->name('client.contact');
Route::get('/A_propos', [ClientController::class, 'About'])->name('client.about');
// Route::post('/nous_contacter', [ClientController::class, 'nousContacter'])->name('contact.submit');

