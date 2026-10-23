<?php

namespace App\Http\Livewire;

use App\Models\Demande;
use App\Exports\DemandesClotureesExport;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class ExercicesClotures extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';

    public $anneeFiltre;
    public $search = '';

    public function mount()
    {
        // Par défaut, afficher l'année la plus récente clôturée
        $derniereAnnee = Demande::cloturees()->max('exercice');
        $this->anneeFiltre = $derniereAnnee ?: null;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingAnneeFiltre()
    {
        $this->resetPage();
    }

    /**
     * Exporte les demandes clôturées en Excel
     */
    public function exportExcel()
    {
        $fileName = 'demandes_cloturees';
        if ($this->anneeFiltre) {
            $fileName .= '_' . $this->anneeFiltre;
        }
        $fileName .= '_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new DemandesClotureesExport($this->anneeFiltre), $fileName);
    }

    public function render()
    {
        // Si aucune année sélectionnée, retourner des données vides
        if (!$this->anneeFiltre) {
            return $this->renderEmpty();
        }

        // Calcul des statistiques pour l'année sélectionnée
        $demandesStats = Demande::cloturees()->where('exercice', $this->anneeFiltre)->get();

        $totalDemandes = $demandesStats->count();

        $montantTotalDemande = (int) $demandesStats->sum('budget');
        $montantTotalAppuye = (int) $demandesStats->sum('budget_accorde');

        // Statistiques par type de service
        $nbreformation = Demande::cloturees()->where('exercice', $this->anneeFiltre)
            ->where('service', 'Formation')
            ->count();

        $nbrepromotion = Demande::cloturees()->where('exercice', $this->anneeFiltre)
            ->where('service', 'Assistance')
            ->count();

        // Formation par type
        $proformation = Demande::cloturees()->where('exercice', $this->anneeFiltre)
            ->where('service', 'Formation')
            ->where('type_demande', 'professionnel')
            ->count();

        $strformation = Demande::cloturees()->where('exercice', $this->anneeFiltre)
            ->where('service', 'Formation')
            ->where('type_demande', 'structure')
            ->count();

        $ongformation = Demande::cloturees()->where('exercice', $this->anneeFiltre)
            ->where('service', 'Formation')
            ->where('type_demande', 'ONG')
            ->count();

        // Assistance/Promotion par type
        $propromotion = Demande::cloturees()->where('exercice', $this->anneeFiltre)
            ->where('service', 'Assistance')
            ->where('type_demande', 'professionnel')
            ->count();

        $strpromotion = Demande::cloturees()->where('exercice', $this->anneeFiltre)
            ->where('service', 'Assistance')
            ->where('type_demande', 'structure')
            ->count();

        $ongpromotion = Demande::cloturees()->where('exercice', $this->anneeFiltre)
            ->where('service', 'Assistance')
            ->where('type_demande', 'ONG')
            ->count();

        // Requête pour les demandes
        $query = Demande::cloturees()->where('exercice', $this->anneeFiltre);

        // Recherche
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('structure', 'like', '%' . $this->search . '%')
                    ->orWhere('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('prenom', 'like', '%' . $this->search . '%')
                    ->orWhere('contact', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%');
            });
        }

        $demandes = $query->orderBy('cloturee_le', 'desc')
            ->orderBy('date_approbation', 'desc')
            ->paginate(10);

        // Récupérer toutes les années disponibles pour le filtre
        $anneesDisponibles = Demande::cloturees()->select('exercice')
            ->distinct()
            ->orderBy('exercice', 'desc')
            ->pluck('exercice')
            ->toArray();

        // Si aucune année disponible, créer un tableau vide pour éviter les erreurs
        if (empty($anneesDisponibles)) {
            $anneesDisponibles = [];
            // Réinitialiser l'année filtre si aucune donnée
            if (!$totalDemandes) {
                $this->anneeFiltre = null;
            }
        }

        return view('livewire.exercices-clotures', compact(
            'demandes',
            'anneesDisponibles',
            'totalDemandes',
            'montantTotalDemande',
            'montantTotalAppuye',
            'nbreformation',
            'nbrepromotion',
            'proformation',
            'strformation',
            'ongformation',
            'propromotion',
            'strpromotion',
            'ongpromotion'
        ));
    }

    /**
     * Retourne une vue avec des données vides quand il n'y a pas de données clôturées
     */
    private function renderEmpty()
    {
        $anneesDisponibles = Demande::cloturees()->select('exercice')
            ->distinct()
            ->orderBy('exercice', 'desc')
            ->pluck('exercice')
            ->toArray();

        return view('livewire.exercices-clotures', [
            'demandes' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 6),
            'anneesDisponibles' => $anneesDisponibles,
            'totalDemandes' => 0,
            'montantTotalDemande' => 0,
            'montantTotalAppuye' => 0,
            'nbreformation' => 0,
            'nbrepromotion' => 0,
            'proformation' => 0,
            'strformation' => 0,
            'ongformation' => 0,
            'propromotion' => 0,
            'strpromotion' => 0,
            'ongpromotion' => 0,
        ]);
    }
}
