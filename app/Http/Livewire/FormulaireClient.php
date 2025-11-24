<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Corp;
use App\Models\Brache;
use App\Models\Metier;
use App\Models\Commune;
use App\Models\Demande;
use Livewire\Component;
use App\Models\Departement;
use Faker\Factory as Faker;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Notifications\EnvoieNotification;
use Illuminate\Support\Facades\Notification;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FormulaireClient extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $formStep = 1;

    public $code;
    public $structure;
    public $service;
    public $type_demande;
    public $branche;
    public $corps;
    public $metier;
    public $nom;
    public $prenom;
    public $sexe;
    public $email;
    public $ifu;
    public $contact;
    public $titre_activite;
    public $obejectif_activite;
    public $debut_activite;
    public $fin_activite;
    public $dure_activite;
    public $departement;
    public $commune;
    public $lieux;
    public $homme_touche = 0;
    public $femme_touche = 0;
    public $budget;
    public $piece;

    protected $messages = [
        'structure.required' => 'Le nom de la structure est obligatoire',
        'structure.min' => 'Le nom doit contenir au moins 3 caractères',
        'service.required' => 'Veuillez sélectionner un service',
        'type_demande.required' => 'Veuillez sélectionner le type de demandeur',

        'nom.required' => 'Le nom est obligatoire',
        'nom.min' => 'Le nom doit contenir au moins 2 caractères',
        'nom.regex' => 'Le nom ne doit contenir que des lettres',
        'prenom.required' => 'Le prénom est obligatoire',
        'prenom.min' => 'Le prénom doit contenir au moins 2 caractères',
        'prenom.regex' => 'Le prénom ne doit contenir que des lettres',
        'email.required' => 'L\'email est obligatoire',
        'email.email' => 'Format d\'email invalide',
        'sexe.required' => 'Veuillez sélectionner le sexe',
        'ifu.required' => 'Le numéro IFU est obligatoire',
        'ifu.digits' => 'L\'IFU doit contenir exactement 13 chiffres',
        'contact.required' => 'Le numéro de contact est obligatoire',
        'contact.regex' => 'Format invalide (8 chiffres: ex 97123456)',
        'contact.digits' => 'Le contact doit contenir exactement 8 chiffres',

        'titre_activite.required' => 'Le titre de l\'activité est obligatoire',
        'titre_activite.min' => 'Le titre doit contenir au moins 5 caractères',
        'obejectif_activite.required' => 'L\'objectif est obligatoire',
        'obejectif_activite.min' => 'L\'objectif doit contenir au moins 20 caractères',
        'debut_activite.required' => 'La date de début est obligatoire',
        'debut_activite.after_or_equal' => 'La date ne peut pas être dans le passé',
        'fin_activite.required' => 'La date de fin est obligatoire',
        'fin_activite.after' => 'La date de fin doit être après la date de début',
        'departement.required' => 'Veuillez sélectionner un département',
        'commune.required' => 'Veuillez sélectionner une commune',
        'lieux.required' => 'Le lieu d\'exécution est obligatoire',
        'homme_touche.integer' => 'Valeur invalide',
        'femme_touche.integer' => 'Valeur invalide',
        'budget.required' => 'Le budget est obligatoire',
        'budget.numeric' => 'Le budget doit être un nombre',
        'budget.min' => 'Le budget doit être supérieur à 0',

        'piece.required' => 'Le document est obligatoire',
        'piece.mimes' => 'Formats acceptés: PDF, JPG, PNG',
        'piece.max' => 'Taille maximale: 5 Mo',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'branche') {
            $this->corps = null;
            $this->metier = null;
        }

        if ($propertyName === 'corps') {
            $this->metier = null;
        }

        if ($propertyName === 'departement') {
            $this->commune = null;
        }

        if (in_array($propertyName, ['debut_activite', 'fin_activite'])) {
            $this->calculateDuration();
        }
    }

    protected function rules()
    {
        $rules = [
            'structure' => 'required|string|min:3|max:255',
            'service' => 'required|in:Assistance,Formation,Financier',
            'type_demande' => 'required|in:professionnel,structure,ONG',
            'branche' => 'nullable|exists:braches,id',
            'corps' => 'nullable|exists:corps,id',
            'metier' => 'nullable|exists:metiers,id',
            'nom' => 'required|string|min:2|max:100|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'prenom' => 'required|string|min:2|max:100|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'email' => 'required|email|max:255',
            'sexe' => 'required|in:Masculin,Feminin',
            'ifu' => 'required|digits:13',
            'contact' => 'required|digits:8|regex:/^(01|21|41|51|52|53|54|56|57|58|59|61|62|63|64|65|66|67|68|69|90|91|94|95|96|97|98|99)\d{6}$/',
            'titre_activite' => 'required|string|min:5|max:255',
            'obejectif_activite' => 'required|string|min:20|max:1000',
            'debut_activite' => 'required|date|after_or_equal:today',
            'fin_activite' => 'required|date|after:debut_activite',
            'departement' => 'required|exists:departements,id',
            'commune' => 'required|exists:communes,id',
            'lieux' => 'required|string|min:5|max:255',
            'homme_touche' => 'nullable|integer|min:0',
            'femme_touche' => 'nullable|integer|min:0',
            'budget' => 'required|numeric|min:1',
            'piece' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];

        return $rules;
    }

    public function nextStep1()
    {
        $this->validate([
            'structure' => 'required|string|min:3|max:255',
            'service' => 'required|in:Assistance,Formation,Financier',
            'type_demande' => 'required|in:professionnel,structure,ONG',
            'branche' => 'nullable|exists:braches,id',
            'corps' => 'nullable|exists:corps,id',
            'metier' => 'nullable|exists:metiers,id',
        ]);

        $this->formStep++;
    }

    public function nextStep2()
    {
        $this->validate([
            'nom' => 'required|string|min:2|max:100|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'prenom' => 'required|string|min:2|max:100|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'email' => 'required|email|max:255',
            'sexe' => 'required|in:Masculin,Feminin',
            'ifu' => 'required|digits:13',
            'contact' => 'required|digits:8|regex:/^(01|21|41|51|52|53|54|56|57|58|59|61|62|63|64|65|66|67|68|69|90|91|94|95|96|97|98|99)\d{6}$/',
        ]);

        $this->formStep++;
    }

    public function nextStep3()
    {
        $this->validate([
            'titre_activite' => 'required|string|min:5|max:255',
            'obejectif_activite' => 'required|string|min:20|max:1000',
            'debut_activite' => 'required|date|after_or_equal:today',
            'fin_activite' => 'required|date|after:debut_activite',
            'departement' => 'required|exists:departements,id',
            'commune' => 'required|exists:communes,id',
            'lieux' => 'required|string|min:5|max:255',
            'homme_touche' => 'nullable|integer|min:0',
            'femme_touche' => 'nullable|integer|min:0',
            'budget' => 'required|numeric|min:1',
        ]);

        $this->formStep++;
    }

    public function store()
    {
        $this->validate([
            'piece' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $faker = Faker::create();
        $this->code = $this->code ?: strtoupper($faker->bothify('?##-????-????-????'));

        $validated = $this->validateDemande();

        try {
            if (isset($validated['piece']) && $validated['piece']->isValid()) {
                $file = $validated['piece'];
                $filePath = Storage::disk('uploads')->putFile('piece', $file);
                $validated['piece'] = $filePath;
            }

            $validated['contact'] = '+229' . $validated['contact'];

            Demande::create($validated);

            $this->alert('success', 'Votre demande a été envoyée avec succès!', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);

            Notification::route('mail', $validated['email'])
                ->notify(new EnvoieNotification((object)$validated));

            $this->reset();
            $this->resetValidation();
        } catch (\Exception $e) {
            $this->alert('error', 'Erreur lors de l\'enregistrement', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    protected function validateDemande()
    {
        return $this->validate([
            'code' => 'required',
            'structure' => 'required|string|min:3|max:255',
            'service' => 'required|in:Assistance,Formation,Financier',
            'type_demande' => 'required|in:professionnel,structure,ONG',
            'branche' => 'nullable|exists:braches,id',
            'corps' => 'nullable|exists:corps,id',
            'metier' => 'nullable|exists:metiers,id',
            'nom' => 'required|string|min:2|max:100|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'prenom' => 'required|string|min:2|max:100|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'sexe' => 'required|in:Masculin,Feminin',
            'email' => 'required|email|max:255',
            'ifu' => 'required|digits:13',
            'contact' => 'required|digits:8|regex:/^(01|21|41|51|52|53|54|56|57|58|59|61|62|63|64|65|66|67|68|69|90|91|94|95|96|97|98|99)\d{6}$/',
            'titre_activite' => 'required|string|min:5|max:255',
            'obejectif_activite' => 'required|string|min:20|max:1000',
            'debut_activite' => 'required|date|after_or_equal:today',
            'fin_activite' => 'required|date|after:debut_activite',
            'dure_activite' => 'required|integer|min:1',
            'departement' => 'required|exists:departements,id',
            'commune' => 'required|exists:communes,id',
            'lieux' => 'required|string|min:5|max:255',
            'homme_touche' => 'nullable|integer|min:0',
            'femme_touche' => 'nullable|integer|min:0',
            'budget' => 'required|numeric|min:1',
            'piece' => 'required',
        ]);
    }

    public function prevStep()
    {
        $this->resetErrorBag();
        $this->formStep = max(1, $this->formStep - 1);
    }

    public function calculateDuration()
    {
        if ($this->debut_activite && $this->fin_activite) {
            $debut = Carbon::parse($this->debut_activite);
            $fin = Carbon::parse($this->fin_activite);

            if ($fin->greaterThan($debut)) {
                $this->dure_activite = $debut->diffInDays($fin);
            }
        } else {
            $this->dure_activite = null;
        }
    }

    public function updatedDebutActivite($value)
    {
        $this->reset('fin_activite', 'dure_activite');
        $this->calculateDuration();
    }

    public function updatedFinActivite($value)
    {
        $this->calculateDuration();
    }

    public function render()
    {
        $departements = Departement::all();
        $branches = Brache::all();

        $communes = isset($this->departement)
            ? Commune::where('departement_id', $this->departement)->get()
            : collect();

        $corp = isset($this->branche)
            ? Corp::where('branche_id', $this->branche)->get()
            : collect();

        $metiers = isset($this->corps)
            ? Metier::where('corp_id', $this->corps)
            ->where('branche_id', $this->branche)
            ->get()
            : collect();

        $date = Carbon::now()->format('Y-m-d');

        return view('livewire.formulaire-client', compact(
            'departements',
            'communes',
            'branches',
            'corp',
            'metiers',
            'date'
        ));
    }
}
