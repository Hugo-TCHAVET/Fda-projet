<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PrintPage extends Component
{
    public $demandes;

    public function render()
    {
        return view('livewire.print-page', ['demandes' => $this->demandes]);
    }

    
}