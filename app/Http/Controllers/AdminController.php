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
                        'statuts' => "Approuver",
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
        $branche = Brache::where('id', $demande->branche)->first();
        $corps = Corp::where('id', $demande->corps)->first();
        $metier = Metier::where('id', $demande->metier)->first();
        $departement = Departement::where('id', $demande->departement)->first();
        $commune = Commune::where('id', $demande->commune)->first();
        if ($demande) {



            $dompdf = new Dompdf();

            // Charger la vue avec les données
            $view = view('Admin.pdf')->with(['demande' => $demande])->render();

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
    }

    public function statistiques()
    {
        $serviceData = Demande::groupBy('service')
            ->selectRaw('service, count(*) as count')
            ->get();

        $sexeData = Demande::groupBy('sexe')
            ->selectRaw('sexe, count(*) as count')
            ->get();

        $totalDemandes = Demande::count();

        $departementData = Departement::leftJoin('demandes', 'departements.id', '=', 'demandes.departement')
            ->groupBy('departements.id', 'departements.nom')
            ->selectRaw('departements.id, departements.nom as nom_departement, count(demandes.id) as count')
            ->get()
            ->map(function ($item) use ($totalDemandes) {
                $item['percentage'] = $totalDemandes > 0 ? ($item['count'] / $totalDemandes) * 100 : 0;
                return $item;
            });

        $demandeurData = Demande::groupBy('type_demande')
            ->selectRaw('type_demande, count(*) as count')
            ->get()
            ->map(function ($item) use ($totalDemandes) {
                $item['percentage'] = $totalDemandes > 0 ? ($item['count'] / $totalDemandes) * 100 : 0;
                return $item;
            });

        // $postAppuiBranche = Brache::leftJoin('demandes', 'braches.id', '=', 'demandes.branche')
        //     ->groupBy('braches.id', 'braches.nom')
        //     ->selectRaw('braches.id, braches.nom as nom_branche, count(demandes.id) as count')
        //     ->get()
        //     ->map(function ($item) use ($totalDemandes) {
        //         $item['percentage'] = $totalDemandes > 0 ? ($item['count'] / $totalDemandes) * 100 : 0;
        //         return $item;
        //     });

        $effectifsParBranche = Brache::leftJoin('demandes', 'braches.id', '=', 'demandes.branche')
            ->selectRaw("
                braches.id,
                braches.nom AS nom_branche,
                COALESCE(SUM(demandes.homme_touche), 0) AS total_hommes,
                COALESCE(SUM(demandes.femme_touche), 0) AS total_femmes,
                COALESCE(SUM(demandes.homme_touche + demandes.femme_touche), 0) AS effectif_total
            ")
            // TODO: appliquer un filtre sur le statut des demandes lorsqu’on saura lequel utiliser
            ->groupBy('braches.id', 'braches.nom')
            ->orderBy('braches.nom')
            ->get();

        return view('Statistique.index', [
            'serviceData' => $serviceData,
            'sexeData' => $sexeData,
            'departementData' => $departementData,
            'demandeurData' => $demandeurData,
            'effectifsParBranche' => $effectifsParBranche,
        ]);
    }

    public function postAppui()
    {
        return view('Statistique.post-appui');
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

    public function updateDemande(Request $request, $id)
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

        $demande = Demande::findOrFail($id);
        $demande->update($request->except('localisations'));
        $demande->localisations()->delete();
        foreach ($request->localisations as $loc) {
            $demande->localisations()->create($loc);
        }
        Alert::toast('Demande modifiée avec succès !', 'success')->position('top-end')->timerProgressBar();
        return redirect()->route('liste.demande');
    }
}
