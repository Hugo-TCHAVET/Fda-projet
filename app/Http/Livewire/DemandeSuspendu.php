<?php

namespace App\Http\Livewire;

use App\Models\Commune;
use App\Models\Demande;
use Livewire\Component;
use App\Models\Departement;
use Livewire\WithPagination;
use App\Models\Brache;
use App\Models\Corp;
use App\Models\Metier;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DemandesRejeteesExport;

class DemandeSuspendu extends Component
{
    use LivewireAlert;
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
            $this->lieux = $demande->lieux;
            $this->homme_touche = $demande->homme_touche;
            $this->femme_touche = $demande->femme_touche;
            $this->budget = $demande->budget;
            $this->piece = $demande->piece;

            if ($demande->departement) {
                $departement = Departement::where('id', $demande->departement)->first();
                $this->departement = $demande->nom;
            }


            if ($demande->commune) {
                $commune = Commune::where('id', $demande->commune)->first();
                $this->commune = $demande->nom;
            }



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

    public function render()
    {


        $demandes = Demande::where('suspendre', 1)->paginate(10);

        return view('livewire.demande-suspendu', compact('demandes'));
    }

    public function Transmetre(int $demandeId)
    {
        $demande = Demande::find($demandeId);
        if ($demande) {
            $demande->update([
                'valide' => 1,
                'statut' => 'En cours de traitement',
                'date_transmission' => now(),
                'suspendre' => 0
            ]);
            if (method_exists($this, 'alert')) {
                $this->alert('success', 'Votre demande a été envoyée avec succès!', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
            }
        }
    }

    public function exportExcel()
    {
        return Excel::download(new DemandesRejeteesExport, 'demandes_rejetees.xlsx');
    }
}
