<?php

namespace App\Http\Livewire;

use App\Models\Demande;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PostAppui extends Component
{
    use WithPagination;
    use LivewireAlert;

    // Propriétés pour le formulaire modal
    public $demandeId;
    public $structure;
    public $effectif_homme_forme;
    public $effectif_femme_forme;
    public $showModal = false;

    // Statistiques
    public $totalStructures = 0;
    public $structuresAvecRapport = 0;
    public $ratio = 0.0;

    protected function rules()
    {
        return [
            'effectif_homme_forme' => 'required|integer|min:0',
            'effectif_femme_forme' => 'required|integer|min:0',
        ];
    }

    protected $messages = [
        'effectif_homme_forme.required' => 'Le nombre d\'hommes formés est requis.',
        'effectif_homme_forme.integer' => 'Le nombre d\'hommes formés doit être un nombre entier.',
        'effectif_homme_forme.min' => 'Le nombre d\'hommes formés ne peut pas être négatif.',
        'effectif_femme_forme.required' => 'Le nombre de femmes formées est requis.',
        'effectif_femme_forme.integer' => 'Le nombre de femmes formées doit être un nombre entier.',
        'effectif_femme_forme.min' => 'Le nombre de femmes formées ne peut pas être négatif.',
    ];

    /**
     * Ouvre le modal pour renseigner le rapport post-appui
     */
    public function edit(int $demandeId)
    {
        $demande = Demande::find($demandeId);

        if ($demande) {
            $this->demandeId = $demande->id;
            $this->structure = $demande->structure;
            $this->effectif_homme_forme = $demande->effectif_homme_forme ?? '';
            $this->effectif_femme_forme = $demande->effectif_femme_forme ?? '';
            $this->showModal = true;
        } else {
            $this->alert('error', 'Demande introuvable.');
        }
    }

    /**
     * Ferme le modal
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['demandeId', 'structure', 'effectif_homme_forme', 'effectif_femme_forme']);
        $this->resetValidation();
    }

    /**
     * Soumet le formulaire de rapport post-appui
     */
    public function store()
    {
        $this->validate();

        try {
            $demande = Demande::find($this->demandeId);

            if ($demande) {
                $demande->update([
                    'rapport_depose' => true,
                    'effectif_homme_forme' => $this->effectif_homme_forme,
                    'effectif_femme_forme' => $this->effectif_femme_forme,
                    'date_depot_rapport' => now(),
                ]);

                $this->alert('success', 'Rapport post-appui enregistré avec succès !');
                $this->closeModal();
                $this->resetPage(); // Réinitialise la pagination
            } else {
                $this->alert('error', 'Demande introuvable.');
            }
        } catch (\Exception $e) {
            $this->alert('error', 'Une erreur est survenue lors de l\'enregistrement.');
        }
    }

    public function render()
    {
        // Récupérer les demandes approuvées (valide = 2 et buget_prevu != null)
        $demandes = Demande::where('valide', 2)
            ->where('buget_prevu', '!=', null)
            ->paginate(6);

        // Calculer les statistiques
        $this->totalStructures = Demande::where('valide', 2)
            ->where('buget_prevu', '!=', null)
            ->count();

        $this->structuresAvecRapport = Demande::where('valide', 2)
            ->where('buget_prevu', '!=', null)
            ->where('rapport_depose', true)
            ->count();

        $this->ratio = $this->totalStructures > 0
            ? round(($this->structuresAvecRapport / $this->totalStructures) * 100, 1)
            : 0.0;

        return view('livewire.post-appui', compact('demandes'));
    }
}
