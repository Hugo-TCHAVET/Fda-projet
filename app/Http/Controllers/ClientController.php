<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\DemandeLocalisation;
use App\Models\Brache;
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

class ClientController extends Controller
{
    public function formulaire()
    {
        $branches = Brache::all();
        $corp = Corp::all();
        $metiers = Metier::all();
        $departements = Departement::all();
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
                'branche' => 'nullable|exists:braches,id',
                'corps' => 'nullable|exists:corps,id',
                'metier' => 'nullable|exists:metiers,id',
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'sexe' => 'required|string',
                'ifu' => [
                    'required',
                    'string',
                    'size:13',
                    'regex:/^[0-9]+$/',
                ],
                'contact' => 'nullable|integer',
                'titre_activite' => 'required|string',
                'obejectif_activite' => 'required|string',
                'debut_activite' => 'nullable|date',
                'fin_activite' => 'nullable|date|after:debut_activite',
                'dure_activite' => 'nullable|integer',
                'departement' => 'nullable|exists:departements,id',
                'commune' => 'nullable|exists:communes,id',
                'lieux' => 'nullable|string',
                'homme_touche' => 'nullable|integer|min:0',
                'budget' => 'required|numeric',
                'piece' => 'nullable|file|mimes:pdf|max:204800',
                'localisations' => 'nullable|array',
                'localisations.*.departement_id' => 'nullable|exists:departements,id',
                'localisations.*.commune_id' => 'nullable|exists:communes,id',
                'localisations.*.lieux' => 'nullable|string',
                'localisations.*.homme_touche' => 'nullable|integer|min:0'
            ]);

            // Génération du code unique
            $faker = Faker::create();
            $code = strtoupper($faker->bothify('?##-????-????-????'));

            // Gestion du fichier
            if ($request->hasFile('piece') && $request->file('piece')->isValid()) {
                $file = $request->file('piece');
                $filePath = Storage::disk('uploads')->putFile('piece', $file);
                $validated['piece'] = $filePath;
            }

            // Ajout du code
            $validated['code'] = $code;

            // Adapter les champs pour la table 'demandes' (colonnes legacy en string)
            $demandePayload = $validated;
            // Ne pas tenter d'insérer le tableau 'localisations' dans 'demandes'
            unset($demandePayload['localisations']);
            $demandePayload['branche'] = (string) $request->input('branche');
            $demandePayload['corps'] = (string) $request->input('corps');
            $demandePayload['metier'] = (string) $request->input('metier');

            // Compatibilité: certaines colonnes existent encore dans 'demandes'
            // On les hydrate avec la première localisation
            $firstLocalisation = collect($request->input('localisations', []))->first();
            if ($firstLocalisation) {
                $demandePayload['departement'] = (string) ($firstLocalisation['departement_id'] ?? '');
                $demandePayload['commune'] = (string) ($firstLocalisation['commune_id'] ?? '');
                $demandePayload['lieux'] = (string) ($firstLocalisation['lieux'] ?? '');
                $demandePayload['homme_touche'] = (string) ($firstLocalisation['homme_touche'] ?? '0');
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

            return redirect()->back()->with('success', 'Votre demande a été envoyée avec succès!');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la demande: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'envoi de votre demande. Veuillez réessayer.');
        }
    }

    public function modifier($id)
    {
        $demande = Demande::with(['localisations.departement', 'localisations.commune'])->findOrFail($id);
        $branches = Brache::all();
        $corp = Corp::all();
        $metiers = Metier::all();
        $departements = Departement::all();
        $communes = Commune::all();

        // Vérifier que la demande existe et a les données nécessaires
        if (!$demande) {
            abort(404, 'Demande non trouvée');
        }

        return view('Client.modifier-formulaire', compact('demande', 'branches', 'corp', 'metiers', 'departements', 'communes'));
    }

    public function update(Request $request, $id)
    {
        try {
            $demande = Demande::findOrFail($id);

            // Validation des données principales
            $validated = $request->validate([
                'structure' => 'required|string',
                'service' => 'required|string',
                'type_demande' => 'required|string',
                'branche' => 'nullable|exists:braches,id',
                'corps' => 'nullable|exists:corps,id',
                'metier' => 'nullable|exists:metiers,id',
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'sexe' => 'required|string',
                'ifu' => [
                    'required',
                    'string',
                    'size:13',
                    'regex:/^[0-9]+$/',
                ],
                'contact' => 'nullable|integer',
                'titre_activite' => 'required|string',
                'obejectif_activite' => 'required|string',
                'debut_activite' => 'nullable|date',
                'fin_activite' => 'nullable|date|after:debut_activite',
                'dure_activite' => 'nullable|integer',
                'budget' => 'nullable|numeric',
                'piece' => 'nullable|file|mimes:pdf|max:204800',
                'localisations' => 'nullable|array',
                'localisations.*.departement_id' => 'nullable|exists:departements,id',
                'localisations.*.commune_id' => 'nullable|exists:communes,id',
                'localisations.*.lieux' => 'nullable|string',
                'localisations.*.homme_touche' => 'nullable|integer|min:0',
            ]);

            // Gestion du fichier (optionnel pour la modification)
            if ($request->hasFile('piece') && $request->file('piece')->isValid()) {
                $file = $request->file('piece');
                $filePath = Storage::disk('uploads')->putFile('piece', $file);
                $validated['piece'] = $filePath;
            }

            // Adapter les champs pour la table 'demandes'
            $payload = $validated;
            unset($payload['localisations']);
            $payload['branche'] = (string) $request->input('branche');
            $payload['corps'] = (string) $request->input('corps');
            $payload['metier'] = (string) $request->input('metier');

            $firstLocalisation = collect($request->input('localisations', []))->first();
            if ($firstLocalisation) {
                $payload['departement'] = (string) ($firstLocalisation['departement_id'] ?? '');
                $payload['commune'] = (string) ($firstLocalisation['commune_id'] ?? '');
                $payload['lieux'] = (string) ($firstLocalisation['lieux'] ?? '');
                $payload['homme_touche'] = (string) ($firstLocalisation['homme_touche'] ?? '0');
            }

            // Mise à jour de la demande
            $demande->update($payload);

            $demande->update(['message' => null]);

            // Supprimer les anciennes localisations et créer les nouvelles
            $demande->localisations()->delete();
            foreach ($request->input('localisations') as $localisation) {
                $demande->localisations()->create($localisation);
            }

            return redirect()->back()->with('success', 'La demande a été modifiée avec succès!');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la modification de la demande: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la modification de votre demande. Veuillez réessayer.');
        }
    }

    public function SuivreDemande()
    {
        // Cette méthode devrait récupérer les demandes de l'utilisateur connecté
        // Pour l'instant, on retourne une vue vide
        return view('Client.suivredemande');
    }

    public function index()
    {
        return view('Client.service');
    }




    public function RechercheDemande(Request $request)
    {
        $code = $request->input('code');
        $service = $request->input('service');
        //dd($demande);
        // $stage = Demande1::where($demande,'code');
        //$stage1 = DB::table('demande1s')->where('code','=',$demande)->first();
        $demande = Demande::where('code', $code)
            ->where('service', $service)
            ->first();


        // $accept = DB::table('accepters')->where('code','=',$demande)->first();
        // dd($stage);
        if ($demande) {
            return view('Client.recherchedemande', compact('demande'));
        } else {
            Alert::toast('Le Code de suivie que vous avez insérer est incorrecte', 'error')->position('top-end')->timerProgressBar();
            return back();
        }
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


    public function statistiqueDepartement()
    {
        $totalDemandes = Demande::count();

        $data = Departement::leftJoin('demandes', 'departements.id', '=', 'demandes.departement')
            ->groupBy('departements.id', 'departements.nom') // Inclure departements.nom dans GROUP BY
            ->selectRaw('departements.id, departements.nom as nom_departement, count(demandes.id) as count')
            ->get();

        $data = $data->map(function ($item) use ($totalDemandes) {
            $item['percentage'] = $totalDemandes > 0 ? ($item['count'] / $totalDemandes) * 100 : 0;
            return $item;
        });

        return view('Statistique.departement', ['data' => $data]);
    }


    public function statistiqueSexe()
    {
        $data = Demande::groupBy('sexe')
            ->selectRaw('sexe, count(*) as count')
            ->get();

        return view('Statistique.sexe', ['data' => $data]);
    }

    public function statistiqueService()
    {
        $data = Demande::groupBy('service')
            ->selectRaw('service, count(*) as count')
            ->get();

        return view('Statistique.service', ['data' => $data]);
    }

    public function statistiqueDemandeur()
    {
        $totalDemandes = Demande::count();

        $data = Demande::groupBy('type_demande')
            ->selectRaw('type_demande, count(*) as count')
            ->get();

        $data = $data->map(function ($item) use ($totalDemandes) {
            $item['percentage'] = $totalDemandes > 0 ? ($item['count'] / $totalDemandes) * 100 : 0;
            return $item;
        });

        return view('Statistique.demandeur', ['data' => $data]);
    }
}
