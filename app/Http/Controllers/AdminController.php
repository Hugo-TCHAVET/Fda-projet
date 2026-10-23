<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Corp;
use App\Models\Branche;
use App\Models\Metier;
use App\Models\Commune;
use App\Enums\EtatDemande;
use App\Models\Demande;
use App\Exceptions\TransitionInterdite;
use App\Services\StatistiquesBeneficiaires;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\HeaderUtils;
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
        $branche = $demande->branche;
        $corps = $demande->corps;
        $metier = $demande->metier;
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
        $demande = Demande::cloturees()->find($id);

        if (!$demande) {
            Alert::toast('Demande clôturée introuvable', 'error')->position('top-end')->timerProgressBar();
            return redirect()->route('exercices.clotures');
        }

        $branche = $demande->branche;
        $corps = $demande->corps;
        $metier = $demande->metier;
        $departement = $demande->departement ? Departement::where('id', $demande->departement)->first() : null;
        $commune = $demande->commune ? Commune::where('id', $demande->commune)->first() : null;
        $localisations = $demande->localisations()->with(['departement', 'commune'])->get();

        return view('Admin.show-cloture', compact('demande', 'branche', 'corps', 'metier', 'commune', 'departement', 'localisations'));
    }


    public function telecharger($id)
    {
        $demande = Demande::findOrFail($id);

        if (!$demande->piece || !Storage::disk('uploads')->exists($demande->piece)) {
            Alert::toast('Le fichier demandé n\'existe pas', 'error')->position('top-end')->timerProgressBar();
            return redirect()->back();
        }

        return Storage::disk('uploads')->download($demande->piece);
    }

    /**
     * Télécharge la pièce jointe d'une demande clôturée
     */
    public function telechargerCloture($id)
    {
        $demande = Demande::cloturees()->findOrFail($id);

        if (!$demande->piece) {
            Alert::toast('Aucune pièce jointe disponible', 'error')->position('top-end')->timerProgressBar();
            return redirect()->route('exercices.clotures');
        }

        if (!Storage::disk('uploads')->exists($demande->piece)) {
            Alert::toast('Le fichier demandé n\'existe pas', 'error')->position('top-end')->timerProgressBar();
            return redirect()->route('exercices.clotures');
        }

        return Storage::disk('uploads')->download($demande->piece);
    }

    public function suspendre($id)
    {

        $demande = Demande::find($id);

        return view('Admin.suspendre', compact('demande'));
    }

    public function transmettre($id)
    {
        $demande = Demande::find($id);

        if (!$demande) {
            Alert::toast('Demande introuvable', 'error')->position('top-end')->timerProgressBar();
            return redirect()->back();
        }

        try {
            $demande->transmettre();
        } catch (TransitionInterdite $e) {
            Alert::toast($e->getMessage(), 'error')->position('top-end')->timerProgressBar();
            return redirect()->back();
        }

        Alert::toast('Demande transmise avec succès!', 'success')->position('top-end')->timerProgressBar();
        return redirect()->route('liste.demande');
    }


    public function supprimer($id)
    {
        Demande::enCours()->findOrFail($id)->delete();
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
                $demande->suspendre((string) $validatedData);

                Alert::toast('Message de suspension enregistré avec succès', 'success')->position('top-end')->timerProgressBar();
                return redirect()->route('demande.suspendu');
            } else {
                Alert::toast('Une erreur est survenue lors de l\'enregistrement du message', 'error')->position('top-end')->timerProgressBar();
                return redirect()->back();
            }
        } catch (TransitionInterdite $e) {
            Alert::toast($e->getMessage(), 'error')->position('top-end')->timerProgressBar();
            return redirect()->back();
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
            'budget_accorde' => ['required', 'integer', 'min:0'],
            'date_approbation' => ['required', 'date'],
        ]);
        //dd('valider');


        $demande = Demande::find($id);
        // dd($validatedData);
        try {
            if ($demande) {
                $demande->approuver((int) $validatedData['budget_accorde'], $validatedData['date_approbation']);
                Alert::toast('Budget enregistré avec succès', 'success')->position('top-end')->timerProgressBar();
                return redirect()->route('demande.approve');
            } else {
                Alert::toast('Une erreur est survenue lors de l\'enregistrement du budget', 'error')->position('top-end')->timerProgressBar();
                return redirect()->back();
            }
        } catch (TransitionInterdite $e) {
            Alert::toast($e->getMessage(), 'error')->position('top-end')->timerProgressBar();
            return redirect()->back();
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

        $branche = $demande->branche;
        $corps = $demande->corps;
        $metier = $demande->metier;
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

        return $this->telechargementPdf($dompdf, 'demande_' . $demande->structure . '.pdf');
    }

    /**
     * Génère le PDF d'une demande clôturée
     */
    public function generatePdfForDemandeCloture($id)
    {
        $demande = Demande::cloturees()->find($id);

        if (!$demande) {
            Alert::toast('Demande clôturée introuvable', 'error')->position('top-end')->timerProgressBar();
            return redirect()->route('exercices.clotures');
        }

        $branche = $demande->branche;
        $corps = $demande->corps;
        $metier = $demande->metier;
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


        return $this->telechargementPdf($dompdf, 'demande_cloture_' . $demande->structure . '_' . $demande->exercice . '.pdf');
    }

    private function telechargementPdf(Dompdf $dompdf, string $nomFichier)
    {
        // Structure names are free text: HeaderUtils rejects '/' and '\' in both names, and '%' in the ASCII fallback.
        $nomFichier = str_replace(['/', '\\'], '-', $nomFichier);

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => HeaderUtils::makeDisposition('attachment', $nomFichier, Str::ascii(str_replace('%', '-', $nomFichier))),
        ]);
    }

    public function statistiques()
    {
        // --- 1. DOSSIERS REÇUS (Toutes les demandes) ---

        // G1 : Répartition par service (Reçus)
        $g1_service_recus = Demande::recues()->enCours()->groupBy('service')
            ->selectRaw('service, count(*) as count')
            ->get();

        // G2 : Répartition par type demandeur (Reçus)
        $g2_demandeur_recus = Demande::recues()->enCours()->groupBy('type_demande')
            ->selectRaw('type_demande, count(*) as count')
            ->get();

        // G3 : Répartition par branche (Reçus vs Approuvés)
        $g3_branche_recus = Branche::rightJoin('demandes', 'branches.id', '=', 'demandes.branche_id')
            ->whereIn('demandes.etat', ['transmise', 'suspendue', 'approuvee'])->whereNull('demandes.cloturee_le')
            ->groupBy('branches.id', 'branches.nom')
            ->selectRaw('SUBSTRING(branches.nom, 1, 40) as nom, count(demandes.id) as recus, sum(CASE WHEN demandes.etat = "approuvee" THEN 1 ELSE 0 END) as approuves')
            ->get();

        // G12 : Effectif artisans prévus par commune (Reçus)
        $g12_effectif_commune_recus = Commune::leftJoin('demandes', 'communes.id', '=', 'demandes.commune')
            ->whereIn('demandes.etat', ['transmise', 'suspendue', 'approuvee'])->whereNull('demandes.cloturee_le')
            ->groupBy('communes.id', 'communes.nom')
            ->selectRaw('communes.nom, COALESCE(SUM(demandes.homme_touche), 0) as effectif')
            ->get();

        // G13 : Effectif TOTAL artisans prévus formés (Reçus)
        $g13_effectif_total_recus = Demande::enCours()->where('etat', '!=', EtatDemande::Suspendue->value)->sum('homme_touche');


        // --- 2. DOSSIERS APPUYÉS / ACCEPTÉS (Statut = Approuvé) ---

        // G4 : Répartition par service (Approuvés)
        $g4_service_approuves = Demande::allocations()->enCours()
            ->groupBy('service')
            ->selectRaw('service, count(*) as count')
            ->get();

        // G5 : Répartition par type demandeur (Approuvés)
        $g5_demandeur_approuves = Demande::allocations()->enCours()
            ->groupBy('type_demande')
            ->selectRaw('type_demande, count(*) as count')
            ->get();

        // G6 : Répartition par branche (Approuvés)
        $g6_branche_approuves = Demande::allocations()->enCours()
            ->leftJoin('branches', 'branches.id', '=', 'demandes.branche_id')
            ->selectRaw("COALESCE(branches.nom, 'Non renseigné') as nom, count(demandes.id) as count")
            ->groupByRaw("COALESCE(branches.nom, 'Non renseigné')")
            ->toBase()
            ->get();

        // G7 : Effectif artisans prévus par service (Approuvés)
        $g7_effectif_service_approuves = Demande::allocations()->enCours()
            ->groupBy('service')
            ->selectRaw('service, SUM(effectif_homme_forme+effectif_femme_forme) as effectif')
            ->get();

        // G8 : Effectif artisans prévus formés par type demandeur (Approuvés)
        $g8_effectif_demandeur_approuves = Demande::allocations()->enCours()
            ->groupBy('type_demande')
            ->selectRaw('type_demande, SUM(effectif_homme_forme+effectif_femme_forme) as effectif')
            ->having('effectif', '>', 0)
            ->get();

        // G10 : Effectif artisans formés par commune (Approuvés) - Via table de liaison pour précision géographique
        $g10_effectif_commune_approuves = Commune::join('demande_localisations', 'communes.id', '=', 'demande_localisations.commune_id')
            ->join('demandes', 'demande_localisations.demande_id', '=', 'demandes.id')
            ->where('demandes.etat', 'approuvee')->whereNull('demandes.cloturee_le')
            ->groupBy('communes.id', 'communes.nom')
            ->selectRaw('communes.nom, SUM(demande_localisations.homme_touche) as effectif')
            ->having('effectif', '>', 0)
            ->get();

        // G14 : Montant total des appuis accordés par service (Approuvés)
        $g14_montant_service_approuves = Demande::allocations()->enCours()
            ->groupBy('service')
            ->selectRaw('service, SUM(budget_accorde) as montant')
            ->get();

        // G15 : Ratio Structures ayant déposé leur rapport / Structures appuyées
        $count_approuves = Demande::allocations()->enCours()->count();
        $count_rapports = Demande::allocations()->enCours()->where('rapport_depose', 1)->count();

        // On prépare un petit objet pour le graphique
        $g15_ratio_data = [
            'rapports_deposes' => $count_rapports,
            'rapports_manquants' => $count_approuves - $count_rapports
        ];

        // G16 : Comparaison Effectif Prévu vs Effectif Post-Rapport par Département
        $g16_prevu_vs_touche = Demande::allocations()->enCours()
            ->leftJoin('departements', 'departements.id', '=', 'demandes.departement')
            ->selectRaw("COALESCE(departements.nom, 'Non renseigné') as nom,
            COALESCE(SUM(demandes.homme_touche), 0) as prevu,
            COALESCE(SUM(COALESCE(demandes.effectif_homme_forme, 0) + COALESCE(demandes.effectif_femme_forme, 0)), 0) as touche")
            ->groupByRaw("COALESCE(departements.nom, 'Non renseigné')")
            ->orderBy('nom')
            ->toBase()
            ->get();

        // G17 : Répartition Homme/Femme réellement formés par Département
        $g17_homme_femme = Demande::allocations()->enCours()
            ->leftJoin('departements', 'departements.id', '=', 'demandes.departement')
            ->selectRaw("COALESCE(departements.nom, 'Non renseigné') as nom,
            COALESCE(SUM(demandes.effectif_homme_forme), 0) as homme,
            COALESCE(SUM(demandes.effectif_femme_forme), 0) as femme")
            ->groupByRaw("COALESCE(departements.nom, 'Non renseigné')")
            ->orderBy('nom')
            ->toBase()
            ->get();

        $beneficiaires = StatistiquesBeneficiaires::pourDemandes();
        $benef_couverture = $beneficiaires->couverture();
        $benef_sexe = $beneficiaires->parSexe();
        $benef_handicap = $beneficiaires->parHandicap();
        $benef_branche = $beneficiaires->repartition('branche');
        $benef_service = $beneficiaires->repartition('service');

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
            'g10_effectif_commune_approuves',
            'g14_montant_service_approuves',
            'g15_ratio_data',
            'g16_prevu_vs_touche',
            'g17_homme_femme',
            'benef_couverture',
            'benef_sexe',
            'benef_handicap',
            'benef_branche',
            'benef_service'
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

    public function edit($id)
    {
        $demande = Demande::enCours()->findOrFail($id);
        $branches = Branche::all();
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
            'branche_id' => 'nullable|integer|exists:branches,id',
            'corps_id' => 'nullable|integer|exists:corps,id',
            'metier_id' => 'nullable|integer|exists:metiers,id',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'sexe' => 'required|string',
            'ifu' => 'required|string',
            'contact' => 'nullable',
            'titre_activite' => 'required|string',
            'objectif_activite' => 'required|string',
            'debut_activite' => 'nullable|date',
            'fin_activite' => 'nullable|date',
            'duree_activite' => 'nullable|integer|min:0|max:65535',
            'budget' => 'required|integer|min:0',
            'piece' => 'nullable|file|mimes:pdf|max:20480',
            'localisations' => 'nullable|array',
            'localisations.*.departement_id' => 'nullable|integer|exists:departements,id',
            'localisations.*.commune_id' => 'nullable|integer|exists:communes,id',
            'localisations.*.lieux' => 'nullable|string',
            'localisations.*.homme_touche' => 'nullable|integer|min:0|max:2147483647',
        ]);

        $demande = Demande::enCours()->findOrFail($id);
        $updateData = collect($validated)->except(['localisations', 'piece'])->all();

        // Gestion du fichier (optionnel pour la modification)
        if ($request->hasFile('piece') && $request->file('piece')->isValid()) {
            // Supprimer l'ancien fichier s'il existe
            if ($demande->piece && Storage::disk('uploads')->exists($demande->piece)) {
                Storage::disk('uploads')->delete($demande->piece);
            }

            // Upload du nouveau fichier
            $file = $request->file('piece');
            $updateData['piece'] = Storage::disk('uploads')->putFile('piece', $file);
        }

        $demande->update($updateData);

        if (isset($validated['localisations'])) {
            $demande->localisations()->delete();
            foreach ($validated['localisations'] as $loc) {
                if (!empty($loc['departement_id'])) { // On crée seulement si au moins le département est présent
                    $demande->localisations()->create($loc);
                }
            }
        }

        Alert::toast('Demande modifiée avec succès !', 'success')->position('top-end')->timerProgressBar();
        return redirect()->route('liste.demande');
    }
}
