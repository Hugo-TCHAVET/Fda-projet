<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;


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
});


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('Admin.index');
    });

    Route::get('/liste_demande', [AdminController::class, 'ListeDemande'])->name('liste.demande');
    Route::get('/detail_demande/{id}', [AdminController::class, 'show'])->name('demande.show');
    Route::get('/suspendre_demande/{id}', [AdminController::class, 'Suspendre'])->name('demande.message');
    Route::post('/suspendre/{id}', [AdminController::class, 'updateMessage'])->name('demande.suspendre');
    Route::get('/delete/{id}', [AdminController::class, 'delete'])->name('demande.delete');

    Route::get('/edit_demande/{id}', [AdminController::class, 'edit'])->name('demande.edit');
    Route::put('/update_demande/{id}', [AdminController::class, 'updateDemande'])->name('update.demande');

    Route::get('/budget_demande/{id}', [AdminController::class, 'Budget'])->name('demande.budget');
    Route::post('/budget/{id}', [AdminController::class, 'updateBudget'])->name('demande.prixbudget');
    Route::get('/pdf/{id}', [AdminController::class, 'generatePdfForDemande'])->name('demande.pdf');

    Route::get('/telecharger_piece/{id}', [AdminController::class, 'telecharger'])->name('demande.piece');
    Route::get('/demande_approuve', [AdminController::class, 'DemandeApprouve'])->name('demande.approve');
    Route::get('/demande_suspendu', [AdminController::class, 'DemandeSuspendu'])->name('demande.suspendu');
    Route::get('/demande_verifier', [AdminController::class, 'DemandeVerifier'])->name('demande.verifier');

    Route::get('/statistiques', [AdminController::class, 'statistiques'])->name('statistiques.admin');
    Route::get('/post-appui', [AdminController::class, 'postAppui'])->name('post-appui');
});


Route::get('/service', [ClientController::class, 'index'])->name('client.service');
Route::get('/formulaire', [ClientController::class, 'Formulaire'])->name('client.formulaire');
Route::get('/suivre_demande', [ClientController::class, 'SuivreDemande'])->name('client.demande');
Route::post('/demande/store', [ClientController::class, 'store'])->name('demande.store');
Route::get('/demande/modifier/{id}', [ClientController::class, 'modifier'])->name('demande.modifier');
Route::put('/demande/update/{id}', [ClientController::class, 'update'])->name('demande.update');
Route::get('/contact', [ClientController::class, 'Contact'])->name('client.contact');
Route::get('/A_propos', [ClientController::class, 'About'])->name('client.about');
Route::post('/recherche_demande', [ClientController::class, 'RechercheDemande'])->name('recherche-demande');
Route::post('/nous_contacter', [ClientController::class, 'nousContacter'])->name('contact.submit');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
