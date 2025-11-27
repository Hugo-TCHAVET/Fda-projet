@extends('Commun.Client')

@section('contenu')
<!-- Import Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif !important;
        background-color: #f0f2f5;
    }

    /* Container du formulaire style 'Card' */
    .form-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        padding: 40px;
        margin-top: 30px;
        margin-bottom: 50px;
        position: relative;
    }

    .form-title h2 {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    /* Stepper (Barre de progression) */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        position: relative;
    }

    .stepper-wrapper::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #e9ecef;
        z-index: 0;
    }

    .stepper-item {
        position: relative;
        z-index: 1;
        text-align: center;
        width: 20%;
    }

    .stepper-item .step-counter {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .stepper-item.active .step-counter {
        border-color: #22a6b3;
        background: #22a6b3;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(34, 166, 179, 0.2);
    }

    .stepper-item.completed .step-counter {
        background: #22a6b3;
        border-color: #22a6b3;
        color: #fff;
    }

    .stepper-item .step-name {
        font-size: 12px;
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
    }

    .stepper-item.active .step-name {
        color: #22a6b3;
        font-weight: 700;
    }

    /* Champs de formulaire */
    .form-group label {
        font-weight: 500;
        color: #34495e;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        padding: 12px 15px;
        font-size: 14px;
        transition: border-color 0.3s, box-shadow 0.3s;
        background-color: #fcfcfc;
    }

    .form-control:focus {
        border-color: #22a6b3;
        box-shadow: 0 0 0 4px rgba(34, 166, 179, 0.1);
        background-color: #fff;
    }

    /* Boutons */
    .btn-nav {
        padding: 10px 30px;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        border: none;
    }

    .btn-prev {
        background: #e9ecef;
        color: #495057;
    }

    .btn-prev:hover {
        background: #dee2e6;
    }

    .btn-next {
        background: #22a6b3;
        color: white;
        box-shadow: 0 4px 10px rgba(34, 166, 179, 0.3);
    }

    .btn-next:hover {
        background: #1b8a94;
        color: white;
        transform: translateY(-1px);
    }

    .localisation-block {
        background: #f8f9fa;
        border: 1px dashed #ced4da !important;
        border-radius: 12px !important;
        transition: all 0.3s;
        position: relative;
    }

    .localisation-block:hover {
        background: #fff;
        border-color: #22a6b3 !important;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .btn-remove-localisation {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #dc3545;
        color: #dc3545;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 10;
    }

    .btn-remove-localisation:hover {
        background: #dc3545;
        color: #fff;
        transform: scale(1.1);
    }

    .btn-remove-localisation i {
        font-size: 18px;
    }

    /* Masquer les étapes sauf la première */
    .form-step {
        display: none;
        animation: fadeIn 0.5s;
    }

    .form-step.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<main id="main">
    <section id="contact" class="section py-5">
        <div class="container">

            <div class="text-center mb-4 form-title" data-aos="fade-up">
                <h2>Formulaire de Demande</h2>
                <p class="text-muted">Veuillez remplir les informations ci-dessous avec précision.</p>
            </div>

            <!-- Affichage des alertes -->
            </script>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="bx bx-error-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <!-- Card Formulaire -->
                    <div class="form-card" data-aos="fade-up" data-aos-delay="100">

                        <!-- Stepper -->
                        <div class="stepper-wrapper">
                            <div class="stepper-item active" id="stepper1">
                                <div class="step-counter">1</div>
                                <div class="step-name">Structure</div>
                            </div>
                            <div class="stepper-item" id="stepper2">
                                <div class="step-counter">2</div>
                                <div class="step-name">Personnel</div>
                            </div>
                            <div class="stepper-item" id="stepper3">
                                <div class="step-counter">3</div>
                                <div class="step-name">Projet</div>
                            </div>
                            <div class="stepper-item" id="stepper4">
                                <div class="step-counter">4</div>
                                <div class="step-name">Lieux</div>
                            </div>
                            <div class="stepper-item" id="stepper5">
                                <div class="step-counter">5</div>
                                <div class="step-name">Fichier</div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('demande.store') }}" class="mt-4" enctype="multipart/form-data" id="demandeForm">
                            @csrf

                            <!-- Étape 1: Informations de base -->
                            <div id="step1" class="form-step active">
                                <h4 class="text-center mb-4" style="font-weight: 600; color: #2c3e50;">Informations sur la structure</h4>

                                <div class="row g-4">
                                    <div class="col-md-6 form-group">
                                        <label for="structure">Structure Demandeur <span class="text-danger">*</span></label>
                                        <input type="text" name="structure" class="form-control" id="structure" value="{{ old('structure') }}" placeholder="Nom de la structure" required>
                                        @error('structure') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="service">Service <span class="text-danger">*</span></label>
                                        <select name="service" id="service" class="form-control" required>
                                            <option value="">Choisissez un service</option>
                                            <option value="Assistance" {{ old('service') == 'Assistance' ? 'selected' : '' }}>Activités de Promotion</option>
                                            <option value="Formation" {{ old('service') == 'Formation' ? 'selected' : '' }}>Formation / Renforcement de capacités</option>
                                        </select>
                                        @error('service') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="type_demande">Type Demandeur <span class="text-danger">*</span></label>
                                        <select name="type_demande" id="type_demande" class="form-control" required>
                                            <option value="">Choisissez le Type</option>
                                            <option value="professionnel" {{ old('type_demande') == 'professionnel' ? 'selected' : '' }}>Association / Organisations professionnelles</option>
                                            <option value="structure" {{ old('type_demande') == 'structure' ? 'selected' : '' }}>Structures formelles</option>
                                            <option value="ONG" {{ old('type_demande') == 'ONG' ? 'selected' : '' }}>Organisations Non Gouvernementales (ONG)</option>
                                        </select>
                                        @error('type_demande') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="branche">Branche</label>
                                        <select name="branche" id="branche" class="form-control">
                                            <option value="">Choisissez une branche</option>
                                            @forelse ($branches as $branche)
                                            <option value="{{ $branche->id }}" {{ old('branche') == $branche->id ? 'selected' : '' }}>{{ $branche->nom }}</option>
                                            @empty
                                            <option value="">Pas de branche</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="corps">Corps Métier</label>
                                        <select name="corps" id="corps" class="form-control">
                                            <option value="">Choisissez d'abord une branche</option>
                                        </select>
                                        <input type="hidden" name="corps_nom" id="corps_nom">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="metier">Métier</label>
                                        <select name="metier" id="metier" class="form-control">
                                            <option value="">Choisissez d'abord un corps de métier</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-end mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-next btn-nav" onclick="nextStep(2)">Suivant <i class="bx bx-right-arrow-alt"></i></button>
                                </div>
                            </div>

                            <!-- Étape 2: Informations personnelles -->
                            <div id="step2" class="form-step">
                                <h4 class="text-center mb-4" style="font-weight: 600; color: #2c3e50;">Informations personnelles</h4>

                                <div class="row g-4">
                                    <div class="col-md-6 form-group">
                                        <label for="nom">Nom <span class="text-danger">*</span></label>
                                        <input type="text" name="nom" class="form-control" id="nom" value="{{ old('nom') }}" placeholder="Votre nom" required>
                                        @error('nom') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="prenom">Prénom <span class="text-danger">*</span></label>
                                        <input type="text" name="prenom" class="form-control" id="prenom" value="{{ old('prenom') }}" placeholder="Votre prénom" required>
                                        @error('prenom') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sexe">Sexe <span class="text-danger">*</span></label>
                                        <select name="sexe" id="sexe" class="form-control" required>
                                            <option value="">Choisissez le sexe</option>
                                            <option value="Masculin" {{ old('sexe') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                            <option value="Féminin" {{ old('sexe') == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                                        </select>
                                        @error('sexe') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="ifu">IFU (13 chiffres) <span class="text-danger">*</span></label>
                                        <input type="text" pattern="[0-9]*" name="ifu" class="form-control" id="ifu" value="{{ old('ifu') }}" maxlength="13" minlength="13" placeholder="Ex: 1234567890123" required>
                                        @error('ifu') <span class="text-danger small mt-1" id="ifu-laravel-error">{{ $message }}</span> @enderror
                                        <span class="text-danger small mt-1" id="ifu-custom-error" style="display:none;"></span>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="contact">Contact </label>
                                        <input type="text" name="contact" class="form-control" id="contact" value="{{ old('contact') }}" placeholder="Ex: 0167854592">

                                        @error('contact') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-prev btn-nav" onclick="prevStep(1)"><i class="bx bx-left-arrow-alt"></i> Précédent</button>
                                    <button type="button" class="btn btn-next btn-nav" onclick="nextStep(3)">Suivant <i class="bx bx-right-arrow-alt"></i></button>
                                </div>
                            </div>

                            <!-- Étape 3: Informations sur l'activité -->
                            <div id="step3" class="form-step">
                                <h4 class="text-center mb-4" style="font-weight: 600; color: #2c3e50;">Détails du Projet</h4>

                                <div class="row g-4">
                                    <div class="col-md-6 form-group">
                                        <label for="titre_activite">Titre de l'activité <span class="text-danger">*</span></label>
                                        <input type="text" name="titre_activite" class="form-control" id="titre_activite" value="{{ old('titre_activite') }}" placeholder="Intitulé du projet" required>
                                        @error('titre_activite') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="obejectif_activite">Objectif de l'activité <span class="text-danger">*</span></label>
                                        <textarea name="obejectif_activite" class="form-control" id="obejectif_activite" rows="1" placeholder="Objectifs..." required>{{ old('obejectif_activite') }}</textarea>
                                        @error('obejectif_activite') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="debut_activite">Date Début</label>
                                        <input type="date" name="debut_activite" class="form-control" id="debut_activite" value="{{ old('debut_activite') }}">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="fin_activite">Date Fin</label>
                                        <input type="date" name="fin_activite" class="form-control" id="fin_activite" value="{{ old('fin_activite') }}">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="dure_activite">Durée (jours)</label>
                                        <input type="number" name="dure_activite" class="form-control bg-light" id="dure_activite" value="{{ old('dure_activite') }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="budget">Budget estimé (FCFA) <span class="text-danger">*</span></label>
                                        <input type="number" name="budget" class="form-control" id="budget" value="{{ old('budget') }}" placeholder="Montant" required>
                                        @error('budget') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-prev btn-nav" onclick="prevStep(2)"><i class="bx bx-left-arrow-alt"></i> Précédent</button>
                                    <button type="button" class="btn btn-next btn-nav" onclick="nextStep(4)">Suivant <i class="bx bx-right-arrow-alt"></i></button>
                                </div>
                            </div>

                            <!-- Étape 4: Localisations -->
                            <div id="step4" class="form-step">
                                <h4 class="text-center mb-4" style="font-weight: 600; color: #2c3e50;">Localisations du projet</h4>
                                <p class="text-muted text-center mb-4 small">Ajoutez les zones d'intervention de votre projet</p>

                                <div id="localisations-container">
                                    <div class="localisation-block mb-3 p-3">
                                        <div class="row g-3">
                                            <div class="col-md-3 form-group">
                                                <label>Département <small class="text-muted">(Optionnel)</small></label>
                                                <select name="localisations[0][departement_id]" class="form-control departement-select">
                                                    <option value="">Choisir...</option>
                                                    @foreach($departements as $departement)
                                                    <option value="{{ $departement->id }}">{{ $departement->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Commune <small class="text-muted">(Optionnel)</small></label>
                                                <select name="localisations[0][commune_id]" class="form-control commune-select">
                                                    <option value="">Choisir...</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Lieu d'exécution <small class="text-muted">(Optionnel)</small></label>
                                                <input type="text" name="localisations[0][lieux]" class="form-control" placeholder="Lieu précis">
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Effectif Prévu <small class="text-muted">(Optionnel)</small></label>
                                                <input type="number" name="localisations[0][homme_touche]" class="form-control" placeholder="Nombre">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 text-end">
                                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3" onclick="addLocalisation()">
                                        <i class="bx bx-plus"></i> Ajouter une localisation
                                    </button>
                                </div>

                                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-prev btn-nav" onclick="prevStep(3)"><i class="bx bx-left-arrow-alt"></i> Précédent</button>
                                    <button type="button" class="btn btn-next btn-nav" onclick="nextStep(5)">Suivant <i class="bx bx-right-arrow-alt"></i></button>
                                </div>
                            </div>

                            <!-- Étape 5: Fichier -->
                            <div id="step5" class="form-step">
                                <h4 class="text-center mb-4" style="font-weight: 600; color: #2c3e50;">Pièces Justificatives <small class="text-muted">(Optionnel)</small></h4>

                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="p-5 border-2 border-dashed rounded-3 text-center bg-light mb-3 position-relative">
                                            <i class="bx bx-cloud-upload display-4 text-muted mb-3"></i>
                                            <label for="piece" class="form-label d-block h5 text-dark">Joindre le fichier du projet <small class="text-muted">(Optionnel)</small></label>
                                            <p class="text-muted small">Format PDF accepté uniquement (Max 20Mo)</p>
                                            <input type="file" class="form-control mt-3" name="piece" id="piece" accept=".pdf">
                                            @error('piece') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-prev btn-nav" onclick="prevStep(4)"><i class="bx bx-left-arrow-alt"></i> Précédent</button>
                                    <button type="submit" class="btn btn-next btn-nav bg-success border-success" id="sendButton">
                                        Envoyer ma demande <i class="bx bx-send"></i>
                                    </button>
                                </div>

                                <!-- Overlay de chargement -->
                                <div id="loadingOverlay" class="loading-overlay">
                                    <div class="loading-spinner"></div>
                                    <div class="loading-text">Traitement en cours...</div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    .loading-overlay {
        position: fixed;
        inset: 0;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        z-index: 2000;
        backdrop-filter: blur(5px);
    }

    .loading-overlay .loading-spinner {
        width: 60px;
        height: 60px;
        border: 5px solid rgba(34, 166, 179, 0.1);
        border-top-color: #22a6b3;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }

    .loading-overlay .loading-text {
        font-weight: 600;
        color: #2c3e50;
        font-size: 16px;
        letter-spacing: 0.5px;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

<script>
    let localisationIndex = 1;

    function updateStepper(step) {
        // Reset all steps
        for (let i = 1; i <= 5; i++) {
            const stepperItem = document.getElementById(`stepper${i}`);
            if (stepperItem) {
                stepperItem.classList.remove('active', 'completed');
                if (i < step) stepperItem.classList.add('completed');
                if (i === step) stepperItem.classList.add('active');
            }
        }
    }

    function nextStep(step) {
        // Valider l'étape actuelle
        const currentStep = step - 1;
        const currentStepElement = document.getElementById(`step${currentStep}`);
        const inputs = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');

        let isValid = true;
        inputs.forEach(input => {
            // Récupérer ou créer le conteneur de message d'erreur
            let errorDiv = input.parentNode.querySelector('.invalid-feedback');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = 'Ce champ est obligatoire';
                input.parentNode.appendChild(errorDiv);
            }

            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                errorDiv.style.display = 'block';
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
                errorDiv.style.display = 'none';
            }
        });

        if (!isValid) {
            return;
        }

        // Masquer l'étape actuelle
        document.getElementById(`step${currentStep}`).classList.remove('active');
        setTimeout(() => {
            document.getElementById(`step${currentStep}`).style.display = 'none';
            // Afficher la nouvelle étape
            const nextStepEl = document.getElementById(`step${step}`);
            nextStepEl.style.display = 'block';
            setTimeout(() => nextStepEl.classList.add('active'), 50);
        }, 0); // Changement immédiat pour éviter le flash, animation via CSS

        updateStepper(step);
        window.scrollTo({
            top: 100,
            behavior: 'smooth'
        });
    }

    function prevStep(step) {
        const currentStep = step + 1;
        document.getElementById(`step${currentStep}`).classList.remove('active');
        document.getElementById(`step${currentStep}`).style.display = 'none';

        const prevStepEl = document.getElementById(`step${step}`);
        prevStepEl.style.display = 'block';
        setTimeout(() => prevStepEl.classList.add('active'), 50);

        updateStepper(step);
        window.scrollTo({
            top: 100,
            behavior: 'smooth'
        });
    }

    function addLocalisation() {
        const container = document.getElementById('localisations-container');
        const newBlock = document.createElement('div');
        newBlock.className = 'localisation-block mb-3 p-3';

        newBlock.innerHTML = `
        <button type="button" class="btn-remove-localisation" onclick="removeLocalisation(this)" title="Supprimer cette localisation">
            <i class="bx bx-trash"></i>
        </button>
        <div class="row g-3">
            <div class="col-md-3 form-group">
                <label>Département <small class="text-muted">(Optionnel)</small></label>
                <select name="localisations[${localisationIndex}][departement_id]" class="form-control departement-select">
                    <option value="">Choisir...</option>
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}">{{ $departement->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label>Commune <small class="text-muted">(Optionnel)</small></label>
                <select name="localisations[${localisationIndex}][commune_id]" class="form-control commune-select">
                    <option value="">Choisir...</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label>Lieu d'exécution <small class="text-muted">(Optionnel)</small></label>
                <input type="text" name="localisations[${localisationIndex}][lieux]" class="form-control" placeholder="Lieu précis">
            </div>
            <div class="col-md-3 form-group">
                <label>Effectif Prévu <small class="text-muted">(Optionnel)</small></label>
                <input type="number" name="localisations[${localisationIndex}][homme_touche]" class="form-control" placeholder="Nombre">
            </div>
        </div>
    `;

        container.appendChild(newBlock);
        localisationIndex++;
        addEventListeners(newBlock);
    }

    function removeLocalisation(button) {
        button.closest('.localisation-block').remove();
    }

    function loadCommunes(departementSelect, communeSelect) {
        const departementId = departementSelect.value;
        if (!departementId) {
            communeSelect.innerHTML = '<option value="">Choisir...</option>';
            return;
        }

        fetch(`/api/communes/${departementId}`)
            .then(response => response.json())
            .then(communes => {
                communeSelect.innerHTML = '<option value="">Choisir...</option>';
                communes.forEach(commune => {
                    const option = document.createElement('option');
                    option.value = commune.id;
                    option.textContent = commune.nom;
                    communeSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erreur lors du chargement des communes:', error);
            });
    }

    function addEventListeners(container) {
        const departementSelect = container.querySelector('.departement-select');
        const communeSelect = container.querySelector('.commune-select');

        if (departementSelect && communeSelect) {
            departementSelect.addEventListener('change', function() {
                loadCommunes(this, communeSelect);
            });
        }
    }

    function loadCorps() {
        const brancheId = document.getElementById('branche').value;
        const corpsSelect = document.getElementById('corps');
        const metierSelect = document.getElementById('metier');

        corpsSelect.innerHTML = '<option value="">Choisissez d\'abord une branche</option>';
        metierSelect.innerHTML = '<option value="">Choisissez d\'abord un corps de métier</option>';

        if (!brancheId) return;

        fetch(`/api/corps/${brancheId}`)
            .then(response => response.json())
            .then(corps => {
                corpsSelect.innerHTML = '<option value="">Choisissez un corps de métier</option>';
                corps.forEach(corps => {
                    const option = document.createElement('option');
                    option.value = corps.id;
                    option.textContent = corps.nom;
                    corpsSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Erreur corps:', error));
    }

    function loadMetiers() {
        const corpsId = document.getElementById('corps').value;
        const metierSelect = document.getElementById('metier');

        metierSelect.innerHTML = '<option value="">Choisissez un métier</option>';

        if (!corpsId) return;

        fetch(`/api/metiers/${corpsId}`)
            .then(response => response.json())
            .then(metiers => {
                metiers.forEach(metier => {
                    const option = document.createElement('option');
                    option.value = metier.id;
                    option.textContent = metier.nom;
                    metierSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Erreur métiers:', error));
    }

    document.getElementById('debut_activite').addEventListener('change', calculateDuration);
    document.getElementById('fin_activite').addEventListener('change', calculateDuration);

    function calculateDuration() {
        const debut = document.getElementById('debut_activite').value;
        const fin = document.getElementById('fin_activite').value;

        if (debut && fin) {
            const debutDate = new Date(debut);
            const finDate = new Date(fin);
            const diffTime = Math.abs(finDate - debutDate + 1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            document.getElementById('dure_activite').value = diffDays;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        addEventListeners(document.getElementById('localisations-container'));

        // Initialisation du stepper
        updateStepper(1);

        document.getElementById('branche').addEventListener('change', loadCorps);
        document.getElementById('corps').addEventListener('change', function() {
            loadMetiers();
            const corpsSelect = document.getElementById('corps');
            const selectedOption = corpsSelect.options[corpsSelect.selectedIndex];
            if (selectedOption) {
                document.getElementById('corps_nom').value = selectedOption.textContent;
            }
        });

        // Restaurer anciennes valeurs si validation échouée
        if ('{{ old("branche") }}') {
            loadCorps();
            setTimeout(() => {
                if ('{{ old("corps") }}') {
                    document.getElementById('corps').value = '{{ old("corps") }}';
                    loadMetiers();
                    setTimeout(() => {
                        if ('{{ old("metier") }}') {
                            document.getElementById('metier').value = '{{ old("metier") }}';
                        }
                    }, 100);
                }
            }, 100);
        }
    });

    const demandeForm = document.getElementById('demandeForm');
    const sendButton = document.getElementById('sendButton');

    demandeForm.addEventListener('submit', function(e) {
        calculateDuration();

        if (!demandeForm.checkValidity()) {
            e.preventDefault();
            const firstInvalid = demandeForm.querySelector(':invalid');
            if (firstInvalid) {
                const stepEl = firstInvalid.closest('.form-step');
                if (stepEl && stepEl.id) {
                    const stepNum = parseInt(stepEl.id.replace('step', ''), 10);
                    // Aller à l'étape de l'erreur
                    for (let i = 1; i <= 5; i++) {
                        const el = document.getElementById(`step${i}`);
                        if (el) {
                            el.style.display = (i === stepNum) ? 'block' : 'none';
                            if (i === stepNum) el.classList.add('active');
                            else el.classList.remove('active');
                        }
                    }
                    updateStepper(stepNum);
                }
                firstInvalid.classList.add('is-invalid');
                firstInvalid.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
            return;
        }

        const overlay = document.getElementById('loadingOverlay');
        if (overlay) overlay.style.display = 'flex';
        sendButton.disabled = true;
    });

    document.getElementById('ifu').addEventListener('input', function() {
        const input = this;
        const errorSpan = document.getElementById('ifu-custom-error');
        const value = input.value.length;

        errorSpan.style.display = 'none';
        errorSpan.textContent = '';
        input.classList.remove('is-invalid');

        if (value > 0 && value !== 13) {
            errorSpan.textContent = `L'IFU doit contenir 13 chiffres. Actuel: ${value}`;
            errorSpan.style.display = 'block';
            input.setCustomValidity('Invalide');
        } else {
            input.setCustomValidity('');
        }
    });
</script>
@endsection