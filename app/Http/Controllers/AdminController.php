<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Corp;
use App\Models\Brache;
use App\Models\Metier;
use App\Models\Commune;
use App\Models\Demande;
use App\Models\DemandeCloture;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
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

    public function ExercicesClotures()
    {
        return view('Admin.exercicesClotures');
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
        return view('Admin.show', compact('demande', 'branche', 'corps', 'metier', 'commune', 'departement', 'localisations', 'id'));
    }

    /**
     * Affiche les détails d'une demande clôturée
     */
    public function showCloture($id)
    {
        $demande = DemandeCloture::find($id);

        if (!$demande) {
            Alert::toast('Demande clôturée introuvable', 'error')->position('top-end')->timerProgressBar();
            return redirect()->route('exercices.clotures');
        }

        $branche = $demande->branche ? Brache::where('id', $demande->branche)->first() : null;
        $corps = $demande->corps ? Corp::where('id', $demande->corps)->first() : null;
        $metier = $demande->metier ? Metier::where('id', $demande->metier)->first() : null;
        $departement = $demande->departement ? Departement::where('id', $demande->departement)->first() : null;
        $commune = $demande->commune ? Commune::where('id', $demande->commune)->first() : null;
        $localisations = $demande->localisations()->with(['departement', 'commune'])->get();

        return view('Admin.show-cloture', compact('demande', 'branche', 'corps', 'metier', 'commune', 'departement', 'localisations'));
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

    /**
     * Télécharge la pièce jointe d'une demande clôturée
     */
    public function telechargerCloture($id)
    {
        $demande = DemandeCloture::findOrFail($id);

        if (!$demande->piece) {
            Alert::toast('Aucune pièce jointe disponible', 'error')->position('top-end')->timerProgressBar();
            return redirect()->route('exercices.clotures');
        }

        $filePath = 'uploads/' . $demande->piece;

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            Alert::toast('Le fichier demandé n\'existe pas', 'error')->position('top-end')->timerProgressBar();
            return redirect()->route('exercices.clotures');
        }
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
        Alert::toast('Demande supprimée avec succès', 'success')->position('top-end')->timerProgressBar();
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

                Alert::toast('Message de suspension enregistré avec succès', 'success')->position('top-end')->timerProgressBar();
                return redirect()->route('demande.suspendu');
            } else {
                Alert::toast('Une erreur est survenue lors de l\'enregistrement du message', 'error')->position('top-end')->timerProgressBar();
                return redirect()->back();
            }
        } catch (\Exception $e) {

            Alert::toast('Une erreur est survenue lors de l\'enregistrement', 'error')->position('top-end')->timerProgressBar();
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
            'date_approbation' => ['required', 'date'],
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
                        'date_approbation' => $validatedData['date_approbation'],
                    ]);
                    Alert::toast('Budget enregistré avec succès', 'success')->position('top-end')->timerProgressBar();
                    return redirect()->route('post-appui');
                } else {
                    Alert::toast('Le budget accordé est supérieur au budget demandé par l\'artisan', 'error')->position('top-end')->timerProgressBar();
                    return redirect()->back();
                }
            } else {
                Alert::toast('Une erreur est survenue lors de l\'enregistrement du budget', 'error')->position('top-end')->timerProgressBar();
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Alert::toast('Une erreur est survenue lors de l\'enregistrement', 'error')->position('top-end')->timerProgressBar();
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

    /**
     * Génère le PDF d'une demande clôturée
     */
    public function generatePdfForDemandeCloture($id)
    {
        $demande = DemandeCloture::find($id);

        if (!$demande) {
            Alert::toast('Demande clôturée introuvable', 'error')->position('top-end')->timerProgressBar();
            return redirect()->route('exercices.clotures');
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

        $view = view('Admin.pdf-cloture', compact('demande', 'branche', 'corps', 'metier', 'departement', 'commune', 'logoBase64'))->render();


        $dompdf->loadHtml($view);
        $dompdf->render();


        return new Response(
            $dompdf->stream('demande_cloture_' . $demande->structure . '_' . $demande->annee_exercice_cloture . '.pdf'),
            200,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function statistiques()
    {
        // --- 1. DOSSIERS REÇUS (Toutes les demandes) ---

        // G1 : Répartition par service (Reçus)
        $g1_service_recus = Demande::Where('valide', '>=', '1')->groupBy('service')
            ->selectRaw('service, count(*) as count')
            ->get();

        // G2 : Répartition par type demandeur (Reçus)
        $g2_demandeur_recus = Demande::Where('valide', '>=', '1')->groupBy('type_demande')
            ->selectRaw('type_demande, count(*) as count')
            ->get();

        // G3 : Répartition par branche (Reçus vs Approuvés)
        $g3_branche_recus = Brache::rightJoin('demandes', 'braches.id', '=', 'demandes.branche')
            ->where('demandes.valide', '>=', '1')
            ->groupBy('braches.id', 'braches.nom')
            ->selectRaw('SUBSTRING(braches.nom, 1, 40) as nom, count(demandes.id) as recus, sum(CASE WHEN demandes.statuts = "Approuvé" THEN 1 ELSE 0 END) as approuves')
            ->get();

        // G12 : Effectif artisans prévus par commune (Reçus)
        $g12_effectif_commune_recus = Commune::leftJoin('demandes', 'communes.id', '=', 'demandes.commune')
            ->where('demandes.valide', '>=', '1')
            ->groupBy('communes.id', 'communes.nom')
            ->selectRaw('communes.nom, COALESCE(SUM(demandes.homme_touche), 0) as effectif')
            ->get();

        // G13 : Effectif TOTAL artisans prévus formés (Reçus)
        $g13_effectif_total_recus = Demande::Where('suspendre', '0')->sum('homme_touche');


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
        $g6_branche_approuves = Brache::rightJoin('demandes', function ($join) {
            $join->on('braches.id', '=', 'demandes.branche')
                ->where('demandes.statuts', 'Approuvé');
        })
            ->groupBy('braches.id', 'braches.nom')
            ->selectRaw('braches.nom, count(demandes.id) as count')
            ->get();

        // G7 : Effectif artisans prévus par service (Approuvés)
        $g7_effectif_service_approuves = Demande::where('statuts', 'Approuvé')
            ->groupBy('service')
            ->selectRaw('service, SUM(effectif_homme_forme+effectif_femme_forme) as effectif')
            ->get();

        // G8 : Effectif artisans prévus formés par type demandeur (Approuvés)
        $g8_effectif_demandeur_approuves = Demande::where('statuts', 'Approuvé')
            ->groupBy('type_demande')
            ->selectRaw('type_demande, SUM(effectif_homme_forme+effectif_femme_forme) as effectif')
            ->having('effectif', '>', 0)
            ->get();

        // G9 : Effectif artisans prévus formés par branche (Approuvés)
        $g9_effectif_branche_approuves = Brache::leftJoin('demandes', function ($join) {
            $join->on('braches.id', '=', 'demandes.branche')
                ->where('demandes.statuts', 'Approuvé');
        })
            ->groupBy('braches.id', 'braches.nom')
            ->selectRaw('SUBSTRING(braches.nom, 1, 40) as nom, COALESCE(SUM(demandes.effectif_homme_forme+demandes.effectif_femme_forme), 0) as effectif, COUNT(demandes.id) as count')
            ->get();


        // G10 : Effectif artisans formés par commune (Approuvés) - Via table de liaison pour précision géographique
        $g10_effectif_commune_approuves = Commune::join('demande_localisations', 'communes.id', '=', 'demande_localisations.commune_id')
            ->join('demandes', 'demande_localisations.demande_id', '=', 'demandes.id')
            ->where('demandes.statuts', 'Approuvé')
            ->groupBy('communes.id', 'communes.nom')
            ->selectRaw('communes.nom, SUM(demande_localisations.homme_touche) as effectif')
            ->having('effectif', '>', 0)
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

        // G16 : Comparaison Effectif Prévu vs Effectif Post-Rapport par Département
        $g16_prevu_vs_touche = Departement::rightJoin('demandes', function ($join) {
            $join->on('departements.id', '=', 'demandes.departement')
                ->where('demandes.statuts', 'Approuvé');
        })
            ->groupBy('departements.id', 'departements.nom')
            ->orderBy('departements.nom', 'asc')
            ->selectRaw('departements.nom, 
            COALESCE(SUM(CAST(demandes.homme_touche AS UNSIGNED)), 0) as prevu,
            COALESCE(SUM(COALESCE(demandes.effectif_homme_forme, 0) + COALESCE(demandes.effectif_femme_forme, 0)), 0) as touche')
            ->get();

        // G17 : Répartition Homme/Femme réellement formés par Département
        $g17_homme_femme = Departement::rightJoin('demandes', function ($join) {
            $join->on('departements.id', '=', 'demandes.departement')
                ->where('demandes.statuts', 'Approuvé');
        })
            ->groupBy('departements.id', 'departements.nom')
            ->orderBy('departements.nom', 'asc')
            ->selectRaw('departements.nom,
            COALESCE(SUM(demandes.effectif_homme_forme), 0) as homme,
            COALESCE(SUM(demandes.effectif_femme_forme), 0) as femme')
            ->get();

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
            'g15_ratio_data',
            'g16_prevu_vs_touche',
            'g17_homme_femme'
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
        $departements = Departement::orderBy('nom', 'asc')->get();
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
            'piece' => 'nullable|file|mimes:pdf|max:20480',
            'localisations' => 'nullable|array',
            'localisations.*.departement_id' => 'nullable|exists:departements,id',
            'localisations.*.commune_id' => 'nullable|exists:communes,id',
            'localisations.*.lieux' => 'nullable|string',
            'localisations.*.homme_touche' => 'nullable|integer',
            'localisations.*.femme_touche' => 'nullable|integer',
        ]);

        $demande = Demande::findOrFail($id);

        // Gestion du fichier (optionnel pour la modification)
        if ($request->hasFile('piece') && $request->file('piece')->isValid()) {
            // Supprimer l'ancien fichier s'il existe
            if ($demande->piece && Storage::disk('uploads')->exists($demande->piece)) {
                Storage::disk('uploads')->delete($demande->piece);
            }

            // Upload du nouveau fichier
            $file = $request->file('piece');
            $filePath = Storage::disk('uploads')->putFile('piece', $file);
            $validated['piece'] = $filePath;
        }

        // Mise à jour des champs principaux (exclure localisations et piece si non fourni)
        $updateData = $request->except(['localisations', 'piece']);
        if (isset($validated['piece'])) {
            $updateData['piece'] = $validated['piece'];
        }
        $demande->update($updateData);

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
        return redirect()->route('liste.demande');
    }
}
