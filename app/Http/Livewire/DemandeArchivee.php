<?php

namespace App\Http\Livewire;

use App\Models\Demande;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DemandeArchivee extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';

    public $anneeFiltre;
    public $search = '';

    public function mount()
    {
        // Par défaut, afficher l'année en cours
        $this->anneeFiltre = date('Y');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingAnneeFiltre()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Demande::where('valide', 2)
            ->where('buget_prevu', '!=', null)
            ->where('archivee', true);

        // Filtrer par année si une année est sélectionnée
        if ($this->anneeFiltre) {
            $query->where('annee_exercice', $this->anneeFiltre);
        }

        // Recherche
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('structure', 'like', '%' . $this->search . '%')
                    ->orWhere('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('prenom', 'like', '%' . $this->search . '%')
                    ->orWhere('contact', 'like', '%' . $this->search . '%');
            });
        }

        $demandes = $query->orderBy('date_archivage', 'desc')
            ->orderBy('date_approbation', 'desc')
            ->paginate(10);

        // Récupérer toutes les années disponibles pour le filtre (DISTINCT)
        $anneesDisponibles = Demande::where('archivee', true)
            ->whereNotNull('annee_exercice')
            ->distinct()
            ->orderBy('annee_exercice', 'desc')
            ->pluck('annee_exercice');

        return view('livewire.demande-archivee', compact('demandes', 'anneesDisponibles'));
    }
}
