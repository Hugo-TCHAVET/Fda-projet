<?php

namespace App\Http\Livewire;

use App\Models\Demande;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SuivreDemande extends Component
{
    use LivewireAlert;

    public $code;
    public $service;



    
    public function store(Demande $demande)
    {
        $this->validate([
            "code" => "required",
            "service" => "required",
        ]);
    
        try {
            $demande->code = $this->code;
            $demande->service = $this->service;
    
            $suivre = Demande::where('code', $demande->code)
                ->where('service', $demande->service)
                ->first();
    
            if ($suivre) {
                return redirect()->route('recherche-demande', ['suivre' => $suivre->id]);
            } else {
                $this->alert('error', 'Le Code de suivi que vous avez inséré est incorrect.', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
    
                return redirect()->back();
            }
        } catch (Exception $th) {
            // Gérer l'exception si nécessaire
        }
    }
    
    
  
    public function render()
    {
        return view('livewire.suivre-demande');
    }
}