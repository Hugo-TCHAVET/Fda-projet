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
    public $homme_touche;
    public $femme_touche;
    public $budget;
    public $piece;

    public function nextStep1()
    {

        $this->validate([
            'structure'=> ['required'],
            'service'=> ['required'],
            'type_demande'=> ['required'],
            'branche'=> 'nullable',
            'corps'=> 'nullable',
            'metier'=> 'nullable',
           
           
        ]);
        
        $this->formStep++;
    }

    public function nextStep2()
    {

        $this->validate([
        'nom'=> ['required'],
        'prenom'=> ['required'],
        'sexe'=> ['required'],
        'email'=> ['required','email'],
        'ifu'=> ['required','integer'],
        'contact'=> ['required','integer'],
        ]);
        $this->formStep++;
    }


    public function nextStep3()
    {

        $this->validate([
       
            'titre_activite'=> ['required'],
            'obejectif_activite'=> ['required'],
            'debut_activite'=> ['required'],
            'fin_activite'=> ['required'],
            'dure_activite'=> ['required'],
            'departement'=> ['required'],
            'commune'=> ['required'],
            'lieux'=> ['required'],
            'homme_touche'=> ['required','integer'],
            'femme_touche'=> ['required','integer'],
            'budget'=> ['required'],
           
        ]);
        $this->formStep++;
    }

    

    public function store()
    {
        $this->validate([
            'piece' => 'required|file|mimes:pdf|max:204800',
        ]);
        
        // Initialisation de Faker
        $faker = \Faker\Factory::create();
    
        // Génération d'une valeur Faker pour le code uniquement si la variable $code est vide
        $this->code = $this->code ?: strtoupper($faker->bothify('?##-????-????-????'));
    
        // Validation des données
        $validated = $this->validateDemande();
      
    
        // Envoi de la notification par email

        if(isset($validated['piece']) && $validated['piece']->isValid())
        {
            $file = $validated['piece'];
           
            $filePath = Storage::disk('uploads')->putFile('piece', $file);

            $validated['piece'] = $filePath;
           

        }
        
       
       
       
        //dd($validated);
        // Création de la demande avec les données validées
        Demande::create($validated);
             
        $this->alert('success', 'Votre demande a été envoyé avec succes!', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'timerProgressBar' => true,
           ]);

           
        Notification::route('mail', $validated['email'])
            ->notify(new EnvoieNotification((object)$validated)); // Castez le tableau en objet
    

           
          
        // Réinitialisation des propriétés du formulaire
        $this->reset();
        $this->resetValidation();
    }
    

   /*  $filename = $request->piece->getClientOriginalExtension();
    $request->piece->move('pieces',$filename);
    $stage->piece = $filename;
 */
    protected function validateDemande()
    {
        return $this->validate([
            'code' => ['required'],
            'structure' => ['required'],
            'service' => ['required'],
            'type_demande' => ['required'],
            'branche'=> 'nullable',
            'corps'=> 'nullable',
            'metier'=> 'nullable',
            'nom' => ['required'],
            'prenom' => ['required'],
            'sexe' => ['required'],
            'email' => ['required', 'email'],
            'ifu' => ['required', 'integer'],
            'contact' => ['required', 'integer'],
            'titre_activite' => ['required'],
            'obejectif_activite' => ['required'],
            'debut_activite' => ['required'],
            'fin_activite' => ['required'],
            'dure_activite' => ['required'],
            'departement' => ['required'],
            'commune' => ['required'],
            'lieux' => ['required'],
            'homme_touche' => ['required', 'integer'],
            'femme_touche' => ['required', 'integer'],
            'budget' => ['required'],
            'piece' => ['required'],
        ]);
    }


  
    public function prevStep()
    {
        $this->formStep--;
    }


    protected $listeners = [
        'updatedDebutActivite' => 'calculateDuration',
        'updatedFinActivite' => 'calculateDuration'
    ];

    public function calculateDuration()
    {
        if ($this->debut_activite && $this->fin_activite) {
            $this->dure_activite = Carbon::parse($this->fin_activite)->diffInDays(Carbon::parse($this->debut_activite));
        } else {
            $this->dure_activite = null;
        }
    }

    public function updatedDebutActivite($value)
    {
        $this->reset('fin_activite', 'dure_activite'); // Reset fin_activite and dure_activite when debut_activite changes
        $this->emit('updatedDebutActivite');
    }

    public function updatedFinActivite($value)
    {
        $this->emit('updatedFinActivite');
    }

    
    public function render()
    {

        $departements = Departement::all();
        $branches = Brache::all();

         if(isset($this->departement))
        {
    
            $communes = Commune::where('departement_id', $this->departement)->get();
    
        }else{
            $communes =[];
        } 


        if(isset($this->branche))
        {
    
            $corp = Corp::where('branche_id',$this->branche)->get();
    
        }else{
            $corp =[];
        } 

        if(isset($this->corps))
        {
    
            $metiers = Metier::where('corp_id', $this->corps)
                            ->where('branche_id',$this->branche)  
                            ->get();
    
        }else{
            $metiers =[];
        } 

        $date = Carbon::now()->format('Y-m-d');
        return view('livewire.formulaire-client',compact('departements','communes','branches','corp','metiers','date'));
    }
}