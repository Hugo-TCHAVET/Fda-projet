<?php

namespace App\Http\Livewire;

use App\Enums\EtatDemande;
use App\Models\Demande;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DemandeVerifier extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshComponent' => '$refresh'];



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



    public function render()
    {

        $demandes = Demande::etat(EtatDemande::Transmise)->enCours()
            ->orderBy('date_transmission', 'desc')
            ->paginate(10);

        return view('livewire.demande-verifier', compact('demandes'));
    }
}
