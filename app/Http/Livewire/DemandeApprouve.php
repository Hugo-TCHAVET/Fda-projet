<?php

namespace App\Http\Livewire;

use App\Models\Corp;
use App\Models\Brache;
use App\Models\Metier;
use App\Models\Demande;
use App\Models\DemandeCloture;
use App\Models\DemandeLocalisationCloture;
use App\Exports\DemandesApprouveesExport;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DemandeApprouve extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshComponent' => '$refresh'];

    // Propriétés pour le modal d'archivage
    public $showModalArchive = false;
    public $demandeIdArchive;
    public $structureArchive;
    public $annee_exercice;

    // Propriétés pour le modal de clôture
    public $showModalCloture = false;
    public $annee_cloture;
    public $nbDemandesACloturer = 0;
    public $budgetTotalACloturer = 0;

    public $demande;
    public $code;
    public $structure;
    public $service;
    public $type_demande;
    public $branche;
    public $corps;
    public $metier;
    public $nom;
    public $prenom;
    public $sexe;
    public $email;
    public $ifu;
    public $contact;
    public $titre_activite;
    public $obejectif_activite;
    public $debut_activite;
    public $fin_activite;
    public $dure_activite;
    public $departement;
    public $commune;
    public $lieux;
    public $homme_touche;
    public $femme_touche;
    public $budget;
    public $piece;
    public $buget_prevu;



    protected function rules()
    {
        return [
            'buget_prevu' => 'required',

        ];
    }

    protected function rulesArchive()
    {
        return [
            'annee_exercice' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ];
    }

    protected function messagesArchive()
    {
        return [
            'annee_exercice.required' => 'L\'année d\'exercice est requise.',
            'annee_exercice.integer' => 'L\'année doit être un nombre entier.',
            'annee_exercice.min' => 'L\'année doit être supérieure ou égale à 2000.',
            'annee_exercice.max' => 'L\'année ne peut pas être supérieure à ' . (date('Y') + 1) . '.',
        ];
    }

    protected function rulesCloture()
    {
        return [
            'annee_cloture' => 'required|integer|min:2000|max:' . date('Y'),
        ];
    }

    protected function messagesCloture()
    {
        return [
            'annee_cloture.required' => 'L\'année de clôture est requise.',
            'annee_cloture.integer' => 'L\'année doit être un nombre entier.',
            'annee_cloture.min' => 'L\'année doit être supérieure ou égale à 2000.',
            'annee_cloture.max' => 'L\'année ne peut pas être supérieure à ' . date('Y') . '.',
        ];
    }




    ////////////////////////////////////////////////////////////////////////
    ///////////////////////////////Affichage des données///////////////////
    public function update(int $demandeId)
    {
        $demande = Demande::find($demandeId);

        if ($demande) {
            $this->demande = $demande->id;
            $this->nom = $demande->nom;
            $this->email = $demande->email;
            $this->prenom = $demande->prenom;
            $this->structure = $demande->structure;
            $this->service = $demande->service;
            $this->type_demande = $demande->type_demande;
            $this->metier = $demande->metier;
            $this->sexe = $demande->sexe;
            $this->ifu = $demande->ifu;
            $this->contact = $demande->contact;
            $this->titre_activite = $demande->titre_activite;
            $this->obejectif_activite = $demande->obejectif_activite;
            $this->debut_activite = $demande->debut_activite;
            $this->fin_activite = $demande->fin_activite;
            $this->dure_activite = $demande->dure_activite;
            $this->departement = $demande->departement;
            $this->commune = $demande->commune;
            $this->lieux = $demande->lieux;
            $this->homme_touche = $demande->homme_touche;
            $this->femme_touche = $demande->femme_touche;
            $this->budget = $demande->budget;
            $this->piece = $demande->piece;
            $this->buget_prevu = $demande->buget_prevu;

            if ($demande->branche) {
                $branche = Brache::where('id', $demande->branche)->first();
                if ($branche) {
                    $this->branche = $branche->nom;
                } else {
                    $this->branche = [];
                }
            }



            if ($demande->corps) {
                $corps = Corp::where('id', $demande->corps)->first();
                if ($corps) {
                    $this->corps = $corps->nom;
                } else {
                    $this->corps = [];
                }
            }

            if ($demande->metier) {
                $metier = Metier::where('id', $demande->metier)->first();
                if ($metier) {
                    $this->metier = $metier->nom;
                } else {
                    $this->metier = [];
                }
            }
        } else {
            return redirect()->back();
        }
    }

    /**
     * Ouvre le modal d'archivage
     */
    public function openArchiveModal(int $demandeId)
    {
        $demande = Demande::find($demandeId);

        if ($demande) {
            $this->demandeIdArchive = $demande->id;
            $this->structureArchive = $demande->structure;
            $this->annee_exercice = date('Y'); // Année par défaut
            $this->showModalArchive = true;
        } else {
            $this->alert('error', 'Demande introuvable.');
        }
    }

    /**
     * Ferme le modal d'archivage
     */
    public function closeArchiveModal()
    {
        $this->showModalArchive = false;
        $this->reset(['demandeIdArchive', 'structureArchive', 'annee_exercice']);
        $this->resetValidation();
    }

    /**
     * Archive la demande
     */
    public function archiver()
    {
        $this->validate($this->rulesArchive(), $this->messagesArchive());

        try {
            $demande = Demande::find($this->demandeIdArchive);

            if ($demande) {
                $demande->update([
                    'archivee' => true,
                    'annee_exercice' => $this->annee_exercice,
                    'date_archivage' => now(),
                ]);

                // Fermer le modal d'abord
                $this->showModalArchive = false;

                // Réinitialiser les propriétés
                $this->reset(['demandeIdArchive', 'structureArchive', 'annee_exercice']);
                $this->resetValidation();

                // Réinitialiser la pagination
                $this->resetPage();

                // Afficher le message de succès
                $this->alert('success', 'Demande archivée avec succès !', [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                ]);
            } else {
                $this->alert('error', 'Demande introuvable.');
            }
        } catch (\Exception $e) {
            $this->alert('error', 'Une erreur est survenue lors de l\'archivage.');
        }
    }

    /**
     * Ouvre le modal de clôture d'exercice
     */
    public function openClotureModal()
    {
        $this->annee_cloture = date('Y') - 1; // Année précédente par défaut
        $this->calculerStatistiquesCloture();
        $this->showModalCloture = true;
    }

    /**
     * Calcule les statistiques avant clôture
     */
    public function calculerStatistiquesCloture()
    {
        if (!$this->annee_cloture) {
            return;
        }

        $demandes = Demande::whereYear('created_at', $this->annee_cloture)->get();

        $this->nbDemandesACloturer = $demandes->count();
        $this->budgetTotalACloturer = $demandes->sum(function ($demande) {
            return (float) str_replace(' ', '', $demande->buget_prevu ?? 0);
        });
    }

    /**
     * Met à jour les statistiques quand l'année change
     */
    public function updatedAnneeCloture()
    {
        $this->calculerStatistiquesCloture();
    }

    /**
     * Ferme le modal de clôture
     */
    public function closeClotureModal()
    {
        $this->showModalCloture = false;
        $this->reset(['annee_cloture', 'nbDemandesACloturer', 'budgetTotalACloturer']);
        $this->resetValidation();
    }

    /**
     * Exporte les demandes approuvées en Excel
     */
    public function exportExcel()
    {
        $fileName = 'demandes_approuvees_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new DemandesApprouveesExport(), $fileName);
    }

    /**
     * Clôture l'exercice pour une année donnée
     */
    public function cloturerExercice()
    {
        $this->validate($this->rulesCloture(), $this->messagesCloture());

        try {
            $demandesCount = Demande::whereYear('created_at', $this->annee_cloture)->count();

            if ($demandesCount === 0) {
                $this->alert('warning', 'Aucune demande trouvée pour l\'année ' . $this->annee_cloture . '.', [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                ]);
                return;
            }

            DB::transaction(function () {
                $userId = auth()->id();
                $now = now();

                // Insertion bulk des demandes clôturées
                DB::statement("
                INSERT INTO demandes_clotures (
                    demande_id_original, code, structure, service, type_demande, 
                    branche, corps, metier, nom, prenom, sexe, ifu, contact,
                    titre_activite, obejectif_activite, debut_activite, fin_activite,
                    dure_activite, departement, commune, lieux, homme_touche, budget,
                    piece, buget_prevu, rapport_depose, effectif_homme_forme, 
                    effectif_femme_forme, date_depot_rapport, status, statut, statuts,
                    valide, suspendre, rejeter, archivee, annee_exercice, 
                    date_archivage, message, date_transmission, date_approbation,
                    annee_exercice_cloture, date_cloture, user_id_cloture,
                    created_at, updated_at
                )
                SELECT 
                    id, code, structure, service, type_demande, branche, corps, 
                    metier, nom, prenom, sexe, ifu, contact, titre_activite, 
                    obejectif_activite, debut_activite, fin_activite, dure_activite,
                    departement, commune, lieux, homme_touche, budget, piece, 
                    buget_prevu, COALESCE(rapport_depose, 0), effectif_homme_forme,
                    effectif_femme_forme, date_depot_rapport, status, statut, statuts,
                    valide, suspendre, rejeter, COALESCE(archivee, 0), annee_exercice,
                    date_archivage, message, date_transmission, date_approbation,
                    ?, ?, ?, created_at, updated_at
                FROM demandes
                WHERE YEAR(created_at) = ?
            ", [$this->annee_cloture, $now, $userId, $this->annee_cloture]);

                // Insertion bulk des localisations clôturées
                DB::statement("
                INSERT INTO demande_localisations_clotures (
                    demande_cloture_id, demande_id_original, departement_id, 
                    commune_id, lieux, homme_touche, 
                    created_at, updated_at
                )
                SELECT 
                    dc.id, dl.demande_id, dl.departement_id, dl.commune_id,
                    dl.lieux, dl.homme_touche,
                    dl.created_at, dl.updated_at
                FROM demande_localisations dl
                INNER JOIN demandes d ON dl.demande_id = d.id
                INNER JOIN demandes_clotures dc ON dc.demande_id_original = d.id
                WHERE YEAR(d.created_at) = ?
                AND dc.annee_exercice_cloture = ?
            ", [$this->annee_cloture, $this->annee_cloture]);

                // Suppression bulk des localisations
                DB::statement("
                DELETE dl FROM demande_localisations dl
                INNER JOIN demandes d ON dl.demande_id = d.id
                WHERE YEAR(d.created_at) = ?
            ", [$this->annee_cloture]);

                // Suppression bulk des demandes
                DB::statement("
                DELETE FROM demandes
                WHERE YEAR(created_at) = ?
            ", [$this->annee_cloture]);
            });

            $this->showModalCloture = false;
            $this->reset(['annee_cloture', 'nbDemandesACloturer', 'budgetTotalACloturer']);
            $this->resetValidation();
            $this->resetPage();

            $this->alert('success', "Exercice {$this->annee_cloture} clôturé avec succès ! {$demandesCount} demande(s) archivée(s).", [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur clôture exercice: ' . $e->getMessage(), [
                'annee' => $this->annee_cloture,
                'user_id' => auth()->id()
            ]);

            $this->alert('error', 'Une erreur est survenue lors de la clôture de l\'exercice.', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
            ]);
        }
    }

    public function render()
    {

        // Exclure les demandes archivées
        $demandes = Demande::where('valide', 2)
            ->where('buget_prevu', '!=', null)
            ->where('archivee', false) // Exclure les archivées
            ->orderBy('date_approbation', 'desc')
            ->paginate(10);

        return view('livewire.demande-approuve', compact('demandes'));
    }
}
