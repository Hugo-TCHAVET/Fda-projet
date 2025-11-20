<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Demande;
use Livewire\Component;

class IndexAdmin extends Component
{
    public function render()
    {
        $nbreformation = Demande::where('service',"Formation")->count();
        $nbrepromotion = Demande::where('service',"Assistance")->count();
        $nbrefinancier = Demande::where('service',"Financier")->count();


        $currentYear = Carbon::now()->year;

        $monthlyData = [
            'formation' => [],
            'promotion' => [],
            'financier' => []
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
            $monthlyData['financier'][] = Demande::where('service', "Financier")
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
        }

        

        $proformation = Demande :: where('service',"Formation")
                                 ->where('type_demande',"professionnel")
                                 ->count();

        $strformation = Demande :: where('service',"Formation")
                                 ->where('type_demande',"structure")
                                 ->count();

        $ongformation = Demande :: where('service',"Formation")
                                 ->where('type_demande',"ONG")
                                 ->count();



         $propromotion = Demande :: where('service',"Assistance")
                                 ->where('type_demande',"professionnel")
                                 ->count();

        
        $strpromotion = Demande :: where('service',"Assistance")
                                 ->where('type_demande',"structure")
                                 ->count();  
                                 
         $ongpromotion = Demande :: where('service',"Assistance")
                                 ->where('type_demande',"ONG")
                                 ->count();



    
        $profinancier = Demande :: where('service',"Financier")
                                 ->where('type_demande',"professionnel")
                                 ->count();
                                 
                                 
                                   
        $strfinancier = Demande :: where('service',"Financier")
                                    ->where('type_demande',"structure")
                                    ->count();  


        $ongfinancier = Demande :: where('service',"Financier")
                                    ->where('type_demande',"ONG")
                                    ->count();
        
        $nbrepromotion = Demande::where('service',"Assistance")->count();
        return view('livewire.index-admin',compact('nbreformation','ongfinancier','strfinancier','profinancier',
        'ongpromotion','strpromotion','propromotion','ongformation','strformation','proformation','nbrefinancier',
        'nbrepromotion','monthlyData'));
    }
}