<?php

namespace App\Http\Livewire;

use App\Models\Corp;
use App\Models\Brache;
use App\Models\Metier;
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
    public $message;

    public function update(int $demandeId)
    {
        $demande = Demande::find($demandeId);

        if ($demande) {
            $this->demande = $demande; // Store the model object, not just ID, to avoid $demande->id crash in view if view expects object
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
                $this->branche = $branche ? $branche->nom : null;
            } else {
                $this->branche = null;
            }

            if ($demande->corps) {
                $corps = Corp::where('id', $demande->corps)->first();
                $this->corps = $corps ? $corps->nom : null;
            } else {
                $this->corps = null;
            }

            if ($demande->metier) {
                $metier = Metier::where('id', $demande->metier)->first();
                $this->metier = $metier ? $metier->nom : null;
            } else {
                $this->metier = null;
            }
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $demandes = Demande::query()
            ->where(function ($query) {
                // Verified (valide=1), Approved (valide=2), or Report Deposited (usually implies approved)
                $query->where('valide', '>=', 1)
                    ->orWhere('rapport_depose', 1);
            })
            ->where(function ($query) {
                $query->where('structure', 'like', '%' . $this->search . '%')
                    ->orWhere('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('prenom', 'like', '%' . $this->search . '%');
            })
            ->orderBy('rapport_depose', 'desc') // Show rapports deposited first (1 before 0)
            ->orderBy('updated_at', 'desc')
            ->paginate(6);

        return view('livewire.suivi-demandes', compact('demandes'));
    }
}
