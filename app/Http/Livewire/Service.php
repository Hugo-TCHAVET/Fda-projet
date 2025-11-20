<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Service extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }
    
    public function render()
    {
        return view('livewire.service');
    }
}
