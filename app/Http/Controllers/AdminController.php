<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Corp;
use App\Models\Brache;
use App\Models\Metier;
use App\Models\Commune;
use App\Models\Demande;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\SuspendreNotification;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{
    //

    public function index()
    {
        return view('Admin.index');
    }

    public function ListeDemande()
    {
        return view('Admin.listedemande');
    }

    public function DemandeApprouve()
    {
        return view('Admin.demandeApprouve');
    }

    public function DemandeArchivee()
    {
        return view('Admin.demandeArchivee');
    }

    public function DemandeSuspendu()
    {
        return view('Admin.demandeSuspendu');
    }

    public function DemandeVerifier()
    {
        return view('Admin.demandeVerifier');
    }


    public function show($id)
    {
        $demande = Demande::find($id);
        $branche = Brache::where('id', $demande->branche)->first();
        $corps = Corp::where('id', $demande->corps)->first();
        $metier = Metier::where('id', $demande->metier)->first();
        $departement = Departement::where('id', $demande->departement)->first();
        $commune = Commune::where('id', $demande->commune)->first();
        $localisations = $demande->localisations()->with(['departement', 'commune'])->get();
        return view('Admin.show', compact('demande', 'branche', 'corps', 'metier', 'commune', 'departement', 'localisations'));
    }


    public function telecharger($id)
    {
        $demande = Demande::findOrFail($id);

        $filePath = 'uploads/' . $demande->piece;

        //dd($filePath);
        if ($filePath) {
            // Vérifier si le fichier existe

            return response()->download($filePath);
        } else {
            Alert::toast('Le fichier demandé n\'existe pas', 'error')->position('top-end')->timerProgressBar();
            return redirect()->back();
        }
        //dd($demande);

    }

    public function Suspendre($id)
    {

        $demande = Demande::find($id);

        return view('Admin.suspendre', compact('demande'));
    }


    public function delete($id)
    {

        $demande = Demande::find($id);

        $demande->delete();
        Alert::toast('Demande supprimer avec succès', 'success')->position('top-end')->timerProgressBar();
        return redirect()->back();
    }



    public function updateMessage(Request $request, $id)
    {
        try {
            // Utilisez la méthode de validation personnalisée
            $validatedData = $request->input('message');

            $demande = Demande::find($id);

            if ($demande) {
                $demande->update([
                    'message' => $validatedData,
                    'suspendre' => 1,
                    'statut' => "Suspendus"
                ]);

                Notification::route('mail', $demande->email)
                    ->notify(new SuspendreNotification((object)$demande));


                Alert::toast('Message de suspension enrégistré avec succès', 'success')->position('top-end')->timerProgressBar();
                return redirect()->route('liste.demande');
            } else {
                Alert::toast('Une erreur est survenue lors de l\'enrengistrement du message', 'error')->position('top-end')->timerProgressBar();
                return redirect()->back();
            }
        } catch (\Exception $e) {

            Alert::toast('Une erreur est survenue lors de l\'enrengistrement', 'error')->position('top-end')->timerProgressBar();
            return redirect()->back();
        }
    }


    public function Budget($id)
    {
        $demande = Demande::find($id);

        return view('Admin.budget', compact('demande'));
    }



    public function updateBudget(Request $request, $id)
    {

        $validatedData = $request->validate([
            'buget_prevu' => ['required', 'numeric'], // Ajout d'une validation pour que le budget soit un nombre
        ]);
        //dd('valider');


        $demande = Demande::find($id);
        // dd($validatedData);
        try {
            if ($demande) {
                if ($validatedData['buget_prevu'] <=  $demande->budget) {

                    $demande->update([
                        'buget_prevu' => $validatedData['buget_prevu'],
                        'valide' => 2,
                        'statuts' => "Approuvé",
                        'date_approbation' => now(),
                    ]);
                    Alert::toast('Budget enrégistré avec succès', 'success')->position('top-end')->timerProgressBar();
                    return redirect()->route('demande.verifier');
                } else {
                    Alert::toast('Le budget prevue est superieur a celle du budget demandé par l\'artisan', 'error')->position('top-end')->timerProgressBar();
                    return redirect()->back();
                }
            } else {
                Alert::toast('Une erreur est survenue lors de l\'enrengistrement du budget', 'error')->position('top-end')->timerProgressBar();
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Alert::toast('Une erreur est survenue lors de l\'enrengistrement', 'error')->position('top-end')->timerProgressBar();
            return redirect()->back();
        }
    }


    public function generatePdfForDemande($id)
    {
        $demande = Demande::find($id);

        if (!$demande) {
            Alert::toast('Demande introuvable', 'error')->position('top-end')->timerProgressBar();
            return redirect()->back();
        }

        $branche = $demande->branche ? Brache::where('id', $demande->branche)->first() : null;
        $corps = $demande->corps ? Corp::where('id', $demande->corps)->first() : null;
        $metier = $demande->metier ? Metier::where('id', $demande->metier)->first() : null;
        $departement = $demande->departement ? Departement::where('id', $demande->departement)->first() : null;
        $commune = $demande->commune ? Commune::where('id', $demande->commune)->first() : null;

        // Encoder le logo en base64 pour DomPDF
        $logoPath = public_path('Client/assets/lofoFDA.png');
        if (!file_exists($logoPath)) {
            $logoPath = public_path('Client/assets/img/lofoFDA.png');
        }
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        $dompdf = new Dompdf();

        // Charger la vue avec les données
        $view = view('Admin.pdf', compact('demande', 'branche', 'corps', 'metier', 'departement', 'commune', 'logoBase64'))->render();

        // Générer le PDF
        $dompdf->loadHtml($view);
        $dompdf->render();

        // Renvoyer le PDF en réponse
        return new Response(
            $dompdf->stream('demande_' . $demande->structure . '.pdf'),
            200,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function statistiques()
    {
        // --- 1. DOSSIERS REÇUS (Toutes les demandes) ---

        // G1 : Répartition par service (Reçus)
        $g1_service_recus = Demande::groupBy('service')
            ->selectRaw('service, count(*) as count')
            ->get();

        // G2 : Répartition par type demandeur (Reçus)
        $g2_demandeur_recus = Demande::groupBy('type_demande')
            ->selectRaw('type_demande, count(*) as count')
            ->get();

        // G3 : Répartition par branche (Reçus)
        $g3_branche_recus = Brache::leftJoin('demandes', 'braches.id', '=', 'demandes.branche')
            ->groupBy('braches.id', 'braches.nom')
            ->selectRaw('SUBSTRING(braches.nom, 1, 60) as nom, count(demandes.id) as count')
            ->get();

        // G12 : Effectif artisans prévus par commune (Reçus)
        $g12_effectif_commune_recus = Commune::leftJoin('demandes', 'communes.id', '=', 'demandes.commune')
            ->groupBy('communes.id', 'communes.nom')
            ->selectRaw('communes.nom, COALESCE(SUM(demandes.homme_touche), 0) as effectif')
            ->get();

        // G13 : Effectif TOTAL artisans prévus formés (Reçus)
        $g13_effectif_total_recus = Demande::sum('homme_touche');


        // --- 2. DOSSIERS APPUYÉS / ACCEPTÉS (Statut = Approuvé) ---

        // G4 : Répartition par service (Approuvés)
        $g4_service_approuves = Demande::where('statuts', 'Approuvé')
            ->groupBy('service')
            ->selectRaw('service, count(*) as count')
            ->get();

        // G5 : Répartition par type demandeur (Approuvés)
        $g5_demandeur_approuves = Demande::where('statuts', 'Approuvé')
            ->groupBy('type_demande')
            ->selectRaw('type_demande, count(*) as count')
            ->get();

        // G6 : Répartition par branche (Approuvés)
        $g6_branche_approuves = Brache::leftJoin('demandes', function ($join) {
            $join->on('braches.id', '=', 'demandes.branche')
                ->where('demandes.statuts', 'Approuvé');
        })
            ->groupBy('braches.id', 'braches.nom')
            ->selectRaw('braches.nom, count(demandes.id) as count')
            ->get();

        // G7 : Effectif artisans prévus par service (Approuvés)
        $g7_effectif_service_approuves = Demande::where('statuts', 'Approuvé')
            ->groupBy('service')
            ->selectRaw('service, SUM(homme_touche) as effectif')
            ->get();

        // G8 : Effectif artisans prévus formés par type demandeur (Approuvés)
        $g8_effectif_demandeur_approuves = Demande::where('statuts', 'Approuvé')
            ->groupBy('type_demande')
            ->selectRaw('type_demande, SUM(homme_touche) as effectif')
            ->get();

        // G9 : Effectif artisans prévus formés par branche (Approuvés)
        $g9_effectif_branche_approuves = Brache::leftJoin('demandes', function ($join) {
            $join->on('braches.id', '=', 'demandes.branche')
                ->where('demandes.statuts', 'Approuvé');
        })
            ->groupBy('braches.id', 'braches.nom')
            ->selectRaw('braches.nom, COALESCE(SUM(demandes.homme_touche), 0) as effectif')
            ->get();

        // G10 & G11 : Effectif artisans prévus formés par commune (Approuvés)
        $g10_effectif_commune_approuves = Commune::leftJoin('demandes', function ($join) {
            $join->on('communes.id', '=', 'demandes.commune')
                ->where('demandes.statuts', 'Approuvé');
        })
            ->groupBy('communes.id', 'communes.nom')
            ->selectRaw('communes.nom, COALESCE(SUM(demandes.homme_touche), 0) as effectif')
            ->get();

        // G14 : Montant total des appuis accordés par service (Approuvés)
        $g14_montant_service_approuves = Demande::where('statuts', 'Approuvé')
            ->groupBy('service')
            ->selectRaw('service, SUM(buget_prevu) as montant')
            ->get();

        // G15 : Ratio Structures ayant déposé leur rapport / Structures appuyées
        $count_approuves = Demande::where('statuts', 'Approuvé')->count();
        $count_rapports = Demande::where('statuts', 'Approuvé')->where('rapport_depose', 1)->count();

        // On prépare un petit objet pour le graphique
        $g15_ratio_data = [
            'rapports_deposes' => $count_rapports,
            'rapports_manquants' => $count_approuves - $count_rapports
        ];

        return view('Statistique.index', compact(
            'g1_service_recus',
            'g2_demandeur_recus',
            'g3_branche_recus',
            'g12_effectif_commune_recus',
            'g13_effectif_total_recus',
            'g4_service_approuves',
            'g5_demandeur_approuves',
            'g6_branche_approuves',
            'g7_effectif_service_approuves',
            'g8_effectif_demandeur_approuves',
            'g9_effectif_branche_approuves',
            'g10_effectif_commune_approuves',
            'g14_montant_service_approuves',
            'g15_ratio_data'
        ));
    }

    public function postAppui()
    {
        return view('Statistique.post-appui');
    }

    public function suiviDemandes()
    {
        return view('Admin.suivi_demandes');
    }
    public function storeDemande(Request $request)
    {
        $validated = $request->validate([
            'structure' => 'required',
            'service' => 'required',
            'type_demande' => 'required',
            'branche' => 'nullable',
            'corps' => 'nullable',
            'metier' => 'nullable',
            'nom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required',
            'email' => 'required|email',
            'ifu' => 'required|integer',
            'contact' => 'required|integer',
            'titre_activite' => 'required',
            'obejectif_activite' => 'required',
            'debut_activite' => 'required',
            'fin_activite' => 'required',
            'dure_activite' => 'required',
            'budget' => 'required',
            'localisations' => 'required|array|min:1',
            'localisations.*.departement_id' => 'required|exists:departements,id',
            'localisations.*.commune_id' => 'required|exists:communes,id',
            'localisations.*.lieux' => 'required|string',
            'localisations.*.homme_touche' => 'required|integer',
            'localisations.*.femme_touche' => 'required|integer',
        ]);

        $demande = Demande::create($request->except('localisations'));

        foreach ($request->localisations as $loc) {
            $demande->localisations()->create($loc);
        }

        Alert::toast('Demande enregistrée avec succès !', 'success')->position('top-end')->timerProgressBar();
        return redirect()->route('liste.demande');
    }

    public function edit($id)
    {
        $demande = Demande::findOrFail($id);
        $branches = Brache::all();
        $corp = Corp::all();
        $metiers = Metier::all();
        $departements = Departement::all();
        $communes = Commune::all();
        $localisations = $demande->localisations; // Relation avec les localisations

        return view('Admin.edit', compact('demande', 'branches', 'corp', 'metiers', 'departements', 'communes', 'localisations'));
    }

    public function updateDemande(Request $request, $id)
    {
        $validated = $request->validate([
            'structure' => 'required|string',
            'service' => 'required|string',
            'type_demande' => 'required|string',
            'branche' => 'nullable',
            'corps' => 'nullable',
            'metier' => 'nullable',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'sexe' => 'required|string',
            'ifu' => 'required|string',
            'contact' => 'nullable',
            'titre_activite' => 'required|string',
            'obejectif_activite' => 'required|string',
            'debut_activite' => 'nullable|date',
            'fin_activite' => 'nullable|date',
            'dure_activite' => 'nullable',
            'budget' => 'required|numeric',
            'localisations' => 'nullable|array',
            'localisations.*.departement_id' => 'nullable|exists:departements,id',
            'localisations.*.commune_id' => 'nullable|exists:communes,id',
            'localisations.*.lieux' => 'nullable|string',
            'localisations.*.homme_touche' => 'nullable|integer',
            'localisations.*.femme_touche' => 'nullable|integer',
        ]);

        $demande = Demande::findOrFail($id);

        // Mise à jour des champs principaux
        $demande->update($request->except('localisations'));

        // Mise à jour des localisations
        if ($request->has('localisations')) {
            $demande->localisations()->delete();
            // Filtrer les localisations vides avant de les créer
            foreach ($request->localisations as $loc) {
                if (!empty($loc['departement_id'])) { // On crée seulement si au moins le département est présent
                    $demande->localisations()->create($loc);
                }
            }
        }

        Alert::toast('Demande modifiée avec succès !', 'success')->position('top-end')->timerProgressBar();
        return redirect()->back();
    }
}
