<?php

namespace App\Http\Livewire;

use App\Models\Corp;
use App\Models\Brache;
use App\Models\Metier;
use App\Models\Demande;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

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

    public function render()
    {

        // Exclure les demandes archivées
        $demandes = Demande::where('valide', 2)
            ->where('buget_prevu', '!=', null)
            ->where('archivee', false) // Exclure les archivées
            ->orderBy('date_approbation', 'desc')
            ->paginate(6);

        return view('livewire.demande-approuve', compact('demandes'));
    }
}
