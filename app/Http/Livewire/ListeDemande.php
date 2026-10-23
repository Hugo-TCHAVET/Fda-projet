<?php

namespace App\Http\Livewire;

use Dompdf\Dompdf;


use App\Models\Commune;
use App\Enums\EtatDemande;
use App\Models\Demande;
use App\Exceptions\TransitionInterdite;
use Livewire\Component;
use Barryvdh\DomPDF\PDF;
use App\Models\Departement;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use App\Notifications\SuspendreNotification;
use Illuminate\Support\Facades\Notification;
use Jantinnerezo\LivewireAlert\LivewireAlert;



class ListeDemande extends Component
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
    public $message;


    protected function rules()
    {
        return [
            'message' => 'required',

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
            $this->code = $demande->code;
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
            $this->lieux = $demande->lieux;
            $this->homme_touche = $demande->homme_touche;
            $this->budget = $demande->budget;
            $this->piece = $demande->piece;
            $this->message = $demande->message;



            if ($demande->departement) {
                $departement = Departement::where('id', $demande->departement)->first();
                $this->departement = $departement->nom;
            }


            if ($demande->commune) {
                $commune = Commune::where('id', $demande->commune)->first();
                $this->commune = $commune->nom;
            }

            $this->branche = $demande->branche?->nom;
            $this->corps = $demande->corps?->nom;
            $this->metier = $demande->metier?->nom;
        } else {
            return redirect()->back();
        }
    }

    ///////////////////////// Transmetre ///////////////////////////////////////
    public function Transmetre(int $demandeId)
    {
        try {
            Demande::findOrFail($demandeId)->transmettre();
        } catch (TransitionInterdite $e) {
            $this->alert('error', $e->getMessage());
            return;
        }

        $this->alert('success', 'Votre demande a été envoyé avec succes!', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }

    public function render()
    {

        // dd($anneeActive);
        $demandes = Demande::etat(EtatDemande::EnAttente)->enCours()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.liste-demande', compact('demandes'));
    }
}
