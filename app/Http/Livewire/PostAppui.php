<?php

namespace App\Http\Livewire;

use App\Models\Demande;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PostAppui extends Component
{
    use WithPagination;
    use WithFileUploads;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshComponent' => '$refresh'];
    // Propriétés pour le formulaire modal
    public $demandeId;
    public $structure;
    public $effectif_homme_forme;
    public $effectif_femme_forme;
    public $effectif_handicape_homme;
    public $effectif_handicape_femme;
    public $observations_rapport;
    public $rapport_fichier;
    public $date_depot_rapport;
    public $handicapFacultatif = false;
    public $showModal = false;

    // Statistiques
    public $totalStructures = 0;
    public $structuresAvecRapport = 0;
    public $ratio = 0.0;

    public function mount()
    {
        $this->date_depot_rapport = now()->format('Y-m-d');
    }

    protected function rules()
    {
        // A report saved before disability data existed may stay "non renseigné" rather than be forced to 0.
        $handicap = $this->estAncienRapportSansHandicap() ? 'nullable|required_with:%s' : 'required';

        return [
            'effectif_homme_forme' => 'required|integer|min:0',
            'effectif_femme_forme' => 'required|integer|min:0',
            'effectif_handicape_homme' => sprintf($handicap, 'effectif_handicape_femme') . '|integer|min:0|lte:effectif_homme_forme',
            'effectif_handicape_femme' => sprintf($handicap, 'effectif_handicape_homme') . '|integer|min:0|lte:effectif_femme_forme',
            'observations_rapport' => 'nullable|string|max:5000',
            'rapport_fichier' => 'nullable|file|mimes:pdf|max:10240',
            'date_depot_rapport' => 'required|date',
        ];
    }

    protected $messages = [
        'effectif_homme_forme.required' => 'Le nombre d\'hommes formés est requis.',
        'effectif_homme_forme.integer' => 'Le nombre d\'hommes formés doit être un nombre entier.',
        'effectif_homme_forme.min' => 'Le nombre d\'hommes formés ne peut pas être négatif.',
        'effectif_femme_forme.required' => 'Le nombre de femmes formées est requis.',
        'effectif_femme_forme.integer' => 'Le nombre de femmes formées doit être un nombre entier.',
        'effectif_femme_forme.min' => 'Le nombre de femmes formées ne peut pas être négatif.',
        'effectif_handicape_homme.required' => 'Le nombre d\'hommes handicapés formés est requis.',
        'effectif_handicape_homme.required_with' => 'Renseignez aussi le nombre d\'hommes handicapés, ou laissez les deux champs vides.',
        'effectif_handicape_homme.integer' => 'Le nombre d\'hommes handicapés formés doit être un nombre entier.',
        'effectif_handicape_homme.min' => 'Le nombre d\'hommes handicapés formés ne peut pas être négatif.',
        'effectif_handicape_homme.lte' => 'Le nombre d\'hommes handicapés ne peut pas dépasser le nombre d\'hommes formés.',
        'effectif_handicape_femme.required' => 'Le nombre de femmes handicapées formées est requis.',
        'effectif_handicape_femme.required_with' => 'Renseignez aussi le nombre de femmes handicapées, ou laissez les deux champs vides.',
        'effectif_handicape_femme.integer' => 'Le nombre de femmes handicapées formées doit être un nombre entier.',
        'effectif_handicape_femme.min' => 'Le nombre de femmes handicapées formées ne peut pas être négatif.',
        'effectif_handicape_femme.lte' => 'Le nombre de femmes handicapées ne peut pas dépasser le nombre de femmes formées.',
        'observations_rapport.max' => 'Les observations ne peuvent pas dépasser 5000 caractères.',
        'rapport_fichier.mimes' => 'Le rapport doit être un fichier PDF.',
        'rapport_fichier.max' => 'Le rapport ne doit pas dépasser 10 Mo.',
        'date_depot_rapport.required' => 'La date de dépôt du rapport est requise.',
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
            $this->effectif_handicape_homme = $demande->effectif_handicape_homme ?? '';
            $this->effectif_handicape_femme = $demande->effectif_handicape_femme ?? '';
            $this->observations_rapport = $demande->observations_rapport;
            $this->rapport_fichier = null;
            $this->handicapFacultatif = $this->estAncienRapportSansHandicap($demande);
            $this->date_depot_rapport = $demande->date_depot_rapport ? $demande->date_depot_rapport->format('Y-m-d') : now()->format('Y-m-d');
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
        $this->reset(['demandeId', 'structure', 'effectif_homme_forme', 'effectif_femme_forme', 'effectif_handicape_homme', 'effectif_handicape_femme', 'observations_rapport', 'rapport_fichier', 'date_depot_rapport', 'handicapFacultatif']);
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
                $cheminRapport = $this->rapport_fichier
                    ? Storage::disk('local')->putFile('rapports', $this->rapport_fichier)
                    : $demande->rapport_fichier;
                $ancienRapport = $demande->cheminRapportSur();

                $demande->update([
                    'rapport_depose' => true,
                    'effectif_homme_forme' => $this->effectif_homme_forme,
                    'effectif_femme_forme' => $this->effectif_femme_forme,
                    'effectif_handicape_homme' => $this->effectif_handicape_homme === '' ? null : $this->effectif_handicape_homme,
                    'effectif_handicape_femme' => $this->effectif_handicape_femme === '' ? null : $this->effectif_handicape_femme,
                    'observations_rapport' => $this->observations_rapport ?: null,
                    'rapport_fichier' => $cheminRapport,
                    'date_depot_rapport' => $this->date_depot_rapport,
                ]);

                $ancienPartage = Demande::where('rapport_fichier', $ancienRapport)->whereKeyNot($demande->id)->exists();
                if ($ancienRapport && $ancienRapport !== $cheminRapport && !$ancienPartage) {
                    Storage::disk('local')->delete($ancienRapport);
                }

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

    private function estAncienRapportSansHandicap(?Demande $demande = null): bool
    {
        $demande ??= Demande::find($this->demandeId);

        return $demande && $demande->rapport_depose && $demande->effectif_handicape_homme === null;
    }

    public function render()
    {
        // Récupérer les demandes approuvées (valide = 2 et buget_prevu != null)
        $demandes = Demande::where('valide', 2)
            ->where('buget_prevu', '!=', null)
            ->orderBy('date_depot_rapport', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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
