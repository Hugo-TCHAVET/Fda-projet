<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\DemandeLocalisation;
use App\Models\Branche;
use App\Models\Corp;
use App\Models\Metier;
use App\Models\Departement;
use App\Models\Commune;
use App\Notifications\EnvoieNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Exception;
use FFI\Exception as FFIException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public function formulaire()
    {
        $branches = Branche::all();
        $corp = Corp::all();
        $metiers = Metier::all();
        $departements = Departement::orderBy('nom', 'asc')->get();
        $communes = Commune::all();

        return view('Client.formulaire', compact('branches', 'corp', 'metiers', 'departements', 'communes'));
    }

    public function store(Request $request)
    {
        if (!$request->has('localisations') && $request->filled(['departement', 'commune', 'lieux', 'homme_touche'])) {
            $request->merge([
                'localisations' => [[
                    'departement_id' => $request->input('departement'),
                    'commune_id' => $request->input('commune'),
                    'lieux' => $request->input('lieux'),
                    'homme_touche' => $request->input('homme_touche'),
                ]],
            ]);
        }

        try {
            // Validation des données principales
            $validated = $request->validate([
                'structure' => 'required|string',
                'service' => 'required|string',
                'type_demande' => 'required|string',
                'branche_id' => 'nullable|integer|exists:branches,id',
                'corps_id' => 'nullable|integer|exists:corps,id',
                'metier_id' => 'nullable|integer|exists:metiers,id',
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'sexe' => 'required|string',
                'ifu' => [
                    'required',
                    'string',
                    'size:13',
                    'regex:/^[0-9]+$/',
                ],
                'contact' => 'nullable|string',
                'titre_activite' => 'required|string',
                'objectif_activite' => 'required|string',
                'debut_activite' => 'nullable|date',
                'fin_activite' => 'nullable|date|after:debut_activite',
                'duree_activite' => 'nullable|integer|min:0|max:65535',
                'departement' => 'nullable|integer|exists:departements,id',
                'commune' => 'nullable|integer|exists:communes,id',
                'lieux' => 'nullable|string',
                'homme_touche' => 'nullable|integer|min:0|max:2147483647',
                'budget' => 'required|integer|min:0',
                'piece' => 'nullable|file|mimes:pdf|max:204800',
                'localisations' => 'nullable|array',
                'localisations.*.departement_id' => 'nullable|integer|exists:departements,id',
                'localisations.*.commune_id' => 'nullable|integer|exists:communes,id',
                'localisations.*.lieux' => 'nullable|string',
                'localisations.*.homme_touche' => 'nullable|integer|min:0|max:2147483647'
            ]);

            // Génération du code unique

            $code = Str::upper(Str::random(17));

            // Gestion du fichier
            if ($request->hasFile('piece') && $request->file('piece')->isValid()) {
                $file = $request->file('piece');
                $filePath = Storage::disk('uploads')->putFile('piece', $file);
                $validated['piece'] = $filePath;
            }

            // Ajout du code
            $validated['code'] = $code;

            $demandePayload = $validated;
            // Ne pas tenter d'insérer le tableau 'localisations' dans 'demandes'
            unset($demandePayload['localisations']);

            // Compatibilité: certaines colonnes existent encore dans 'demandes'
            // On les hydrate avec la première localisation
            $firstLocalisation = collect($request->input('localisations', []))->first();
            if ($firstLocalisation) {
                $demandePayload['departement'] = (string) ($firstLocalisation['departement_id'] ?? '');
                $demandePayload['commune'] = (string) ($firstLocalisation['commune_id'] ?? '');
                $demandePayload['lieux'] = (string) ($firstLocalisation['lieux'] ?? '');
                $demandePayload['homme_touche'] = $firstLocalisation['homme_touche'] ?? 0;
            }

            DB::transaction(function () use ($request, $demandePayload) {
                $demande = Demande::create($demandePayload);

                collect($request->input('localisations', []))
                    ->filter(function ($localisation) {
                        return !empty($localisation['departement_id']) && !empty($localisation['commune_id']);
                    })
                    ->each(function ($localisation) use ($demande) {
                        $demande->localisations()->create($localisation);
                    });
            });
            Alert::toast('Votre demande a été enregistrée avec succès', 'success')->position('top-end')->timerProgressBar();
            return redirect()->route('liste.demande');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la demande: ' . $e->getMessage());
            return redirect()->back()->with('toast.error', 'Une erreur est survenue lors de l\'envoi de votre demande. Veuillez réessayer!');
        }
    }

    public function index()
    {
        return view('Client.service');
    }

    public function About()
    {
        return view('Client.about');
    }

    public function Contact()
    {
        return view('Client.contact');
    }

    public function nousContacter(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ];

        Mail::to('huguesrichardmongadji@gmail.com')->send(new ContactMail($data));

        Alert::toast('Votre message a été envoyé avec succès!', 'success')->position('top-end')->timerProgressBar();
        return redirect()->route('client.contact');
    }
}
