<?php

namespace App\Http\Livewire;

use App\Models\Demande;
use App\Services\ClotureExercice;
use Illuminate\Support\Facades\Gate;
use App\Exports\DemandesApprouveesExport;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
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
    public $nbDemandesAReporter = 0;
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
    public $ifu;
    public $contact;
    public $titre_activite;
    public $objectif_activite;
    public $debut_activite;
    public $fin_activite;
    public $duree_activite;
    public $departement;
    public $commune;
    public $lieux;
    public $homme_touche;
    public $budget;
    public $piece;
    public $budget_accorde;



    protected function rules()
    {
        return [
            'budget_accorde' => 'required',

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
            $this->prenom = $demande->prenom;
            $this->structure = $demande->structure;
            $this->service = $demande->service;
            $this->type_demande = $demande->type_demande;
            $this->sexe = $demande->sexe;
            $this->ifu = $demande->ifu;
            $this->contact = $demande->contact;
            $this->titre_activite = $demande->titre_activite;
            $this->objectif_activite = $demande->objectif_activite;
            $this->debut_activite = $demande->debut_activite;
            $this->fin_activite = $demande->fin_activite;
            $this->duree_activite = $demande->duree_activite;
            $this->departement = $demande->departement;
            $this->commune = $demande->commune;
            $this->lieux = $demande->lieux;
            $this->homme_touche = $demande->homme_touche;
            $this->budget = $demande->budget;
            $this->piece = $demande->piece;
            $this->budget_accorde = $demande->budget_accorde;

            $this->branche = $demande->branche?->nom;
            $this->corps = $demande->corps?->nom;
            $this->metier = $demande->metier?->nom;
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
            $demande = Demande::allocations()->enCours()->find($this->demandeIdArchive);

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

        $apercu = ClotureExercice::apercu((int) $this->annee_cloture);

        $this->nbDemandesACloturer = $apercu['cloturees'];
        $this->nbDemandesAReporter = $apercu['reportees'];
        $this->budgetTotalACloturer = $apercu['montant_accorde'];
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
        $this->reset(['annee_cloture', 'nbDemandesACloturer', 'nbDemandesAReporter', 'budgetTotalACloturer']);
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
        if (Gate::denies('cloturer-exercice')) {
            $this->alert('error', 'Vous n\'êtes pas autorisé à clôturer un exercice.');
            return;
        }

        $this->validate($this->rulesCloture(), $this->messagesCloture());
        $annee = (int) $this->annee_cloture;

        try {
            $resultat = ClotureExercice::cloturer($annee, auth()->user());

            if ($resultat['cloturees'] + $resultat['reportees'] === 0) {
                $this->alert('warning', "Aucune demande en cours pour l'exercice {$annee}.", [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                ]);
                return;
            }

            $this->showModalCloture = false;
            $this->reset(['annee_cloture', 'nbDemandesACloturer', 'nbDemandesAReporter', 'budgetTotalACloturer']);
            $this->resetValidation();
            $this->resetPage();

            $suivant = $annee + 1;
            $this->alert('success', "Exercice {$annee} clôturé : {$resultat['cloturees']} allocation(s) clôturée(s), {$resultat['reportees']} demande(s) reportée(s) sur {$suivant}.", [
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

        $demandes = Demande::allocations()->enCours()
            ->where('archivee', false)
            ->orderBy('date_approbation', 'desc')
            ->paginate(10);

        return view('livewire.demande-approuve', compact('demandes'));
    }
}
