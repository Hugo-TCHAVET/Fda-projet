<?php

namespace App\Http\Livewire;

use App\Models\Demande;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SuiviDemandes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshComponent' => '$refresh'];

    public $search = '';

    // Properties for modal
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
    public $message;

    public function update(int $demandeId)
    {
        $demande = Demande::find($demandeId);

        if ($demande) {
            $this->demande = $demande; // Store the model object, not just ID, to avoid $demande->id crash in view if view expects object
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
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $demandes = Demande::recues()->enCours()
            ->where(function ($query) {
                $query->where('structure', 'like', '%' . $this->search . '%')
                    ->orWhere('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('prenom', 'like', '%' . $this->search . '%');
            })
            ->orderBy('rapport_depose', 'desc') // Show rapports deposited first (1 before 0)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('livewire.suivi-demandes', compact('demandes'));
    }
}
