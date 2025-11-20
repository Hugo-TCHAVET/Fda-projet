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
                'contact' => 'required|integer',
                'titre_activite' => 'required|string',
                'obejectif_activite' => 'required|string',
                'debut_activite' => 'required|date',
                'fin_activite' => 'required|date|after:debut_activite',
                'dure_activite' => 'required|integer',
                'budget' => 'required|numeric',
                'piece' => 'required|file|mimes:pdf|max:204800',
                'localisations' => 'required|array|min:1',
                'localisations.*.departement_id' => 'required|exists:departements,id',
                'localisations.*.commune_id' => 'required|exists:communes,id',
                'localisations.*.lieux' => 'required|string',
                'localisations.*.homme_touche' => 'required|integer|min:0'
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

            // Création de la demande
            $demande = Demande::create($demandePayload);

            // Création des localisations
            foreach ($request->input('localisations') as $localisation) {
                $demande->localisations()->create($localisation);
            }


            return redirect()->back()->with('success', 'Votre demande a été envoyée avec succès!');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de la demande: ' . $e->getMessage());
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
                'branche' => 'required|exists:braches,id',
                'corps' => 'required|exists:corps,id',
                'metier' => 'required|exists:metiers,id',
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'sexe' => 'required|string',
                'ifu' => [
                    'required',
                    'string', 
                    'size:13', 
                    'regex:/^[0-9]+$/' ,
                ],
                'contact' => 'required|integer',
                'titre_activite' => 'required|string',
                'obejectif_activite' => 'required|string',
                'debut_activite' => 'required|date',
                'fin_activite' => 'required|date|after:debut_activite',
                'dure_activite' => 'required|integer',
                'budget' => 'nullable|numeric',
                'piece' => 'nullable|file|mimes:pdf|max:204800',
                'localisations' => 'required|array|min:1',
                'localisations.*.departement_id' => 'required|exists:departements,id',
                'localisations.*.commune_id' => 'required|exists:communes,id',
                'localisations.*.lieux' => 'required|string',
                'localisations.*.homme_touche' => 'required|integer|min:0',
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
        $request->validate([
            'service' => 'required|string',
            'code' => 'required|string',
        ]);

        $demande = Demande::where('service', $request->input('service'))
            ->where('code', $request->input('code'))
            ->first();

        if (!$demande) {
            return back()->with('erreur', 'Aucune demande trouvée pour ces informations.')->withInput();
        }

        return view('Client.recherchedemande', compact('demande'));
    }

    public function Contact()
    {
        return view('Client.contact');
    }

    public function About()
    {
        return view('Client.about');
    }

    public function nousContacter(Request $request)
    {
        // Validation et traitement du formulaire de contact
        $validated = $request->validate([
            'nom' => 'required|string',
            'sujet' => 'required|string',
            'message' => 'required|string',
        ]);


        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès!');
    }
}