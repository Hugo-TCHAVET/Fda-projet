<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Demande;
use Livewire\Component;

class IndexAdmin extends Component
{
    public function render()
    {
        $nbreformation = Demande::where('service', "Formation")->where('valide', '>=', 1)->count();
        $nbrepromotion = Demande::where('service', "Assistance")->where('valide', '>=', 1)->count();
        // $nbrefinancier = Demande::where('service', "Financier")->count();


        $currentYear = Carbon::now()->year;

        $monthlyData = [
            'formation' => [],
            'promotion' => [],
            // 'financier' => []
        ];


        for ($month = 1; $month <= 12; $month++) {
            $monthlyData['formation'][] = Demande::where('service', "Formation")
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
            $monthlyData['promotion'][] = Demande::where('service', "Assistance")
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
            // $monthlyData['financier'][] = Demande::where('service', "Financier")
            //     ->whereYear('created_at', $currentYear)
            //     ->whereMonth('created_at', $month)
            //     ->count();
        }



        $proformation = Demande::where('service', "Formation")
            ->where('type_demande', "professionnel")
            ->where('valide', '>=', 1)
            ->count();

        $strformation = Demande::where('service', "Formation")
            ->where('type_demande', "structure")
            ->where('valide', '>=', 1)
            ->count();

        $ongformation = Demande::where('service', "Formation")
            ->where('type_demande', "ONG")
            ->where('valide', '>=', 1)
            ->count();



        $propromotion = Demande::where('service', "Assistance")
            ->where('type_demande', "professionnel")
            ->where('valide', '>=', 1)
            ->count();


        $strpromotion = Demande::where('service', "Assistance")
            ->where('type_demande', "structure")
            ->where('valide', '>=', 1)
            ->count();

        $ongpromotion = Demande::where('service', "Assistance")
            ->where('type_demande', "ONG")
            ->where('valide', '>=', 1)
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

        $nbrepromotion = Demande::where('service', "Assistance")->where('valide', '>=', 1)->count();

        $totaldemandes = Demande::where('valide', '>=', 1)->count();

        $demandesapprouvees = Demande::where('valide', 2)->count();
        $demandesrejetees = Demande::where('suspendre', 1)->count();

        // Montant total demandé (demandes non approuvées : valide = 2 || valide = 1)
        $montantTotalDemande = Demande::where('valide', '>=', 1)
            ->get()
            ->sum(function ($demande) {
                return (float) $demande->budget;
            });

        // Montant total appuyé (demandes approuvées : valide == 2)
        $montantTotalAppuye = Demande::where('valide', 2)
            ->get()
            ->sum(function ($demande) {
                return (float) $demande->buget_prevu;
            });

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
            'monthlyData',
            'totaldemandes',
            'demandesapprouvees',
            'demandesrejetees',
            'montantTotalDemande',
            'montantTotalAppuye'
        ));
    }
}
