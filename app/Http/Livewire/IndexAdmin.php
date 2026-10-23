<?php

namespace App\Http\Livewire;

use App\Enums\EtatDemande;
use App\Models\Demande;
use Livewire\Component;

class IndexAdmin extends Component
{
    public function render()
    {
        $nbreformation = Demande::where('service', "Formation")->recues()->enCours()->count();
        $nbrepromotion = Demande::where('service', "Assistance")->recues()->enCours()->count();
        // $nbrefinancier = Demande::where('service', "Financier")->count();


        $proformation = Demande::where('service', "Formation")
            ->where('type_demande', "professionnel")
            ->recues()->enCours()
            ->count();

        $strformation = Demande::where('service', "Formation")
            ->where('type_demande', "structure")
            ->recues()->enCours()
            ->count();

        $ongformation = Demande::where('service', "Formation")
            ->where('type_demande', "ONG")
            ->recues()->enCours()
            ->count();



        $propromotion = Demande::where('service', "Assistance")
            ->where('type_demande', "professionnel")
            ->recues()->enCours()
            ->count();


        $strpromotion = Demande::where('service', "Assistance")
            ->where('type_demande', "structure")
            ->recues()->enCours()
            ->count();

        $ongpromotion = Demande::where('service', "Assistance")
            ->where('type_demande', "ONG")
            ->recues()->enCours()
            ->count();




        // $profinancier = Demande::where('service', "Financier")
        //     ->where('type_demande', "professionnel")
        //     ->count();



        // $strfinancier = Demande::where('service', "Financier")
        //     ->where('type_demande', "structure")
        //     ->count();


        // $ongfinancier = Demande::where('service', "Financier")
        //     ->where('type_demande', "ONG")
        //     ->count();

        $nbrepromotion = Demande::where('service', "Assistance")->recues()->enCours()->count();

        $totaldemandes = Demande::recues()->enCours()->count();

        $demandesapprouvees = Demande::allocations()->enCours()->count();
        $demandessuspendues = Demande::etat(EtatDemande::Suspendue)->enCours()->count();
        $demandesencours = Demande::etat(EtatDemande::Transmise)->enCours()->count();

        $montantTotalDemande = (int) Demande::recues()->enCours()->sum('budget');
        $montantTotalAppuye = (int) Demande::allocations()->enCours()->sum('budget_accorde');

        return view('livewire.index-admin', compact(
            'nbreformation',
            // 'ongfinancier',
            // 'strfinancier',
            // 'profinancier',
            'ongpromotion',
            'strpromotion',
            'propromotion',
            'ongformation',
            'strformation',
            'proformation',
            // 'nbrefinancier',
            'nbrepromotion',
            'totaldemandes',
            'demandesapprouvees',
            'demandessuspendues',
            'demandesencours',
            'montantTotalDemande',
            'montantTotalAppuye'
        ));
    }
}
