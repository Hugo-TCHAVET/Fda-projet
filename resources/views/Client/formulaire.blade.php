@extends('Commun.Client')

@section('contenu')
<main id="main">
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-title mb-4">
                <h2>Formulaire de Demande</h2>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row mt-1">
                <div class="col-lg-12 mt-5 mt-lg-0">
                    <form method="POST" action="{{ route('demande.store') }}" class="mt-4" enctype="multipart/form-data" id="demandeForm">
                        @csrf

                        <!-- Étape 1: Informations de base -->
                        <div id="step1" class="form-step">
                            <div class="row mb-2">
                                <div class="text-center mb-4">
                                    <h2 style="font-weight: bold">Information sur la structure</h2>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="structure" style="font-weight: bold">Structure Demandeur</label>
                                    <input type="text" name="structure" class="form-control" id="structure" value="{{ old('structure') }}" required>
                                    @error('structure') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="service" style="font-weight: bold">Service</label>
                                    <select name="service" id="service" class="form-control" required>
                                        <option value="">Choisissez un service</option>
                                        <option value="Assistance" {{ old('service') == 'Assistance' ? 'selected' : '' }}>Activités de Promotion</option>
                                        <option value="Formation" {{ old('service') == 'Formation' ? 'selected' : '' }}>Formation / Renforcement de capacités</option>
                                    </select>
                                    @error('service') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="type_demande" style="font-weight: bold">Type Demandeur</label>
                                    <select name="type_demande" id="type_demande" class="form-control" required>
                                        <option value="">Choisissez le Type</option>
                                        <option value="professionnel" {{ old('type_demande') == 'professionnel' ? 'selected' : '' }}>Association / Organisations professionnelles d’artisans</option>
                                        <option value="structure" {{ old('type_demande') == 'structure' ? 'selected' : '' }}>Structures formelles</option>
                                        <option value="ONG" {{ old('type_demande') == 'ONG' ? 'selected' : '' }}>Organisations Non Gouvernementales (ONG)</option>
                                    </select>
                                    @error('type_demande') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="branche" style="font-weight: bold">Branche</label>
                                    <select name="branche" id="branche" class="form-control" nullable>
                                        <option value="">Choisissez une branche</option>
                                        @forelse ($branches as $branche)
                                        <option value="{{ $branche->id }}" {{ old('branche') == $branche->id ? 'selected' : '' }}>{{ $branche->nom }}</option>
                                        @empty
                                        <option value="">Pas de branche</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="corps" style="font-weight: bold">Corps Métier</label>
                                    <select name="corps" id="corps" class="form-control" nullable>
                                        <option value="">Choisissez d'abord une branche</option>
                                    </select>
                                    <input type="hidden" name="corps_nom" id="corps_nom">
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="metier" style="font-weight: bold">Métier</label>
                                    <select name="metier" id="metier" class="form-control" nullable>
                                        <option value="">Choisissez d'abord un corps de métier</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-success" onclick="nextStep(2)">Suivant</button>
                            </div>
                        </div>

                        <!-- Étape 2: Informations personnelles -->
                        <div id="step2" class="form-step" style="display: none;">
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="nom" style="font-weight: bold">Nom</label>
                                    <input type="text" name="nom" class="form-control" id="nom" value="{{ old('nom') }}" required>
                                    @error('nom') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="prenom" style="font-weight: bold">Prénom</label>
                                    <input type="text" name="prenom" class="form-control" id="prenom" value="{{ old('prenom') }}" required>
                                    @error('prenom') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="sexe" style="font-weight: bold">Sexe</label>
                                    <select name="sexe" id="sexe" class="form-control" required>
                                        <option value="">Choisissez le sexe</option>
                                        <option value="Masculin" {{ old('sexe') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                        <option value="Féminin" {{ old('sexe') == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                    @error('sexe') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="ifu" style="font-weight: bold">IFU</label>
                                    <input type="text"
                                        pattern="[0-9]*"
                                        name="ifu"
                                        class="form-control"
                                        id="ifu"
                                        value="{{ old('ifu') }}"
                                        required
                                        maxlength="13"
                                        minlength="13">
                                    @error('ifu') <span class="error text-danger" id="ifu-laravel-error">{{ $message }}</span> @enderror
                                    <span class="error text-danger" id="ifu-custom-error" style="display:none;"></span>
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="contact" style="font-weight: bold">Contact</label>
                                    <input type="number" name="contact" class="form-control" id="contact" value="{{ old('contact') }}" required>
                                    @error('contact') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" onclick="prevStep(1)">Précédent</button>
                                <button type="button" class="btn btn-success" onclick="nextStep(3)">Suivant</button>
                            </div>
                        </div>

                        <!-- Étape 3: Informations sur l'activité -->
                        <div id="step3" class="form-step" style="display: none;">
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="titre_activite" style="font-weight: bold">Titre de l'activité</label>
                                    <input type="text" name="titre_activite" class="form-control" id="titre_activite" value="{{ old('titre_activite') }}" required>
                                    @error('titre_activite') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="obejectif_activite" style="font-weight: bold">Objectif de l'activité</label>
                                    <textarea name="obejectif_activite" class="form-control" id="obejectif_activite" rows="3" required>{{ old('obejectif_activite') }}</textarea>
                                    @error('obejectif_activite') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 form-group">
                                    <label for="debut_activite" style="font-weight: bold">Début de l'activité</label>
                                    <input type="date" name="debut_activite" class="form-control" id="debut_activite" value="{{ old('debut_activite') }}" required>
                                    @error('debut_activite') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="fin_activite" style="font-weight: bold">Fin de l'activité</label>
                                    <input type="date" name="fin_activite" class="form-control" id="fin_activite" value="{{ old('fin_activite') }}" required>
                                    @error('fin_activite') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="dure_activite" style="font-weight: bold">Durée (jours)</label>
                                    <input type="number" name="dure_activite" class="form-control" id="dure_activite" value="{{ old('dure_activite') }}" readonly>
                                    @error('dure_activite') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="budget" style="font-weight: bold">Budget estimé</label>
                                    <input type="number" name="budget" class="form-control" id="budget" value="{{ old('budget') }}" required>
                                    @error('budget') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" onclick="prevStep(2)">Précédent</button>
                                <button type="button" class="btn btn-success" onclick="nextStep(4)">Suivant</button>
                            </div>
                        </div>

                        <!-- Étape 4: Localisations -->
                        <div id="step4" class="form-step" style="display: none;">
                            <hr>
                            <h5 class="mb-3">Localisations du projet</h5>
                            <div id="localisations-container">
                                <div class="localisation-block mb-3 p-3" style="background:#f8f9fa; border:2px solid #e0e0e0; border-radius:8px; position:relative;">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>Département</label>
                                            <select name="localisations[0][departement_id]" class="form-control departement-select" required>
                                                <option value="">Choisir un département</option>
                                                @foreach($departements as $departement)
                                                <option value="{{ $departement->id }}">{{ $departement->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Commune</label>
                                            <select name="localisations[0][commune_id]" class="form-control commune-select" required>
                                                <option value="">Choisir une commune</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Lieu d'exécution</label>
                                            <input type="text" name="localisations[0][lieux]" class="form-control" required>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Effectif Prévu </label>
                                            <input type="number" name="localisations[0][homme_touche]" class="form-control" required>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="mb-2 text-end">
                                <button type="button" class="btn btn-success" onclick="addLocalisation()">
                                    <i class="bi bi-plus-circle"></i> Ajouter une localisation
                                </button>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" onclick="prevStep(3)">Précédent</button>
                                <button type="button" class="btn btn-success" onclick="nextStep(5)">Suivant</button>
                            </div>
                        </div>

                        <!-- Étape 5: Fichier -->
                        <div id="step5" class="form-step" style="display: none;">
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="piece" style="font-weight: bold">Fichier</label>
                                    <input type="file" class="form-control" name="piece" id="piece" accept=".pdf" required>
                                    @error('piece') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" onclick="prevStep(4)">Précédent</button>
                                <button type="submit" class="btn btn-success" id="sendButton">Envoyer</button>
                            </div>
                            <!-- Overlay de chargement lors de la soumission -->
                            <div id="loadingOverlay" class="loading-overlay">
                                <div class="loading-spinner"></div>
                                <div class="loading-text">Envoi en cours...</div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }

    .loading-animation {
        position: fixed;
        top: 50%;
        left: 50%;
        width: 50px;
        height: 50px;
        border: 5px solid rgba(0, 0, 0, 0.1);
        border-left-color: #22a6b3;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        transform: translate(-50%, -50%);
    }

    .loading-overlay {
        position: fixed;
        inset: 0;
        background: rgba(255, 255, 255, 0.8);
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        z-index: 2000;
    }

    .loading-overlay .loading-spinner {
        width: 60px;
        height: 60px;
        border: 6px solid rgba(0, 0, 0, 0.1);
        border-top-color: #0d6efd;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 12px;
    }

    .loading-overlay .loading-text {
        font-weight: 600;
        color: #0d6efd;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

<script>
    let localisationIndex = 1;

    function nextStep(step) {
        // Valider l'étape actuelle
        const currentStep = step - 1;
        const currentStepElement = document.getElementById(`step${currentStep}`);
        const inputs = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');

        let isValid = true;
        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            alert('Veuillez remplir tous les champs obligatoires');
            return;
        }

        // Masquer l'étape actuelle
        document.getElementById(`step${currentStep}`).style.display = 'none';
        // Afficher la nouvelle étape
        document.getElementById(`step${step}`).style.display = 'block';
    }

    function prevStep(step) {
        // Masquer l'étape actuelle
        const currentStep = step + 1;
        document.getElementById(`step${currentStep}`).style.display = 'none';
        // Afficher l'étape précédente
        document.getElementById(`step${step}`).style.display = 'block';
    }

    function addLocalisation() {
        const container = document.getElementById('localisations-container');
        const newBlock = document.createElement('div');
        newBlock.className = 'localisation-block mb-3 p-3';
        newBlock.style.cssText = 'background:#f8f9fa; border:2px solid #e0e0e0; border-radius:8px; position:relative;';

        newBlock.innerHTML = `
        <div class="row">
            <div class="col-md-3 form-group">
                <label>Département</label>
                <select name="localisations[${localisationIndex}][departement_id]" class="form-control departement-select" required>
                    <option value="">Choisir un département</option>
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}">{{ $departement->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label>Commune</label>
                <select name="localisations[${localisationIndex}][commune_id]" class="form-control commune-select" required>
                    <option value="">Choisir une commune</option>
                </select>
            </div>
            <div class="col-md-2 form-group">
                <label>Lieu d'exécution</label>
                <input type="text" name="localisations[${localisationIndex}][lieux]" class="form-control" required>
            </div>
            <div class="col-md-2 form-group">
                <label>Hommes touchés</label>
                <input type="number" name="localisations[${localisationIndex}][homme_touche]" class="form-control" required>
            </div>
            <button type="button" class="btn btn-outline-danger position-absolute remove-localisation" style="top:10px; right:10px;" onclick="removeLocalisation(this)" title="Supprimer cette localisation">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;

        container.appendChild(newBlock);
        localisationIndex++;

        // Ajouter l'écouteur d'événement pour le nouveau bloc
        addEventListeners(newBlock);
    }

    function removeLocalisation(button) {
        button.closest('.localisation-block').remove();
    }

    function loadCommunes(departementSelect, communeSelect) {
        const departementId = departementSelect.value;
        if (!departementId) {
            communeSelect.innerHTML = '<option value="">Choisir une commune</option>';
            return;
        }

        fetch(`/api/communes/${departementId}`)
            .then(response => response.json())
            .then(communes => {
                communeSelect.innerHTML = '<option value="">Choisir une commune</option>';
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

        // Réinitialiser les champs dépendants
        corpsSelect.innerHTML = '<option value="">Choisissez un corps de métier</option>';
        metierSelect.innerHTML = '<option value="">Choisissez d\'abord un corps de métier</option>';

        if (!brancheId) {
            return;
        }

        fetch(`/api/corps/${brancheId}`)
            .then(response => response.json())
            .then(corps => {
                corps.forEach(corps => {
                    const option = document.createElement('option');
                    option.value = corps.id;
                    option.textContent = corps.nom;
                    corpsSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erreur lors du chargement des corps de métier:', error);
            });
    }

    function loadMetiers() {
        const corpsId = document.getElementById('corps').value;
        const metierSelect = document.getElementById('metier');

        // Réinitialiser le champ métier
        metierSelect.innerHTML = '<option value="">Choisissez un métier</option>';

        if (!corpsId) {
            return;
        }

        // Charger les métiers liés au corps de métier sélectionné
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
            .catch(error => {
                console.error('Erreur lors du chargement des métiers:', error);
            });
    }

    // Calculer la durée automatiquement
    document.getElementById('debut_activite').addEventListener('change', calculateDuration);
    document.getElementById('fin_activite').addEventListener('change', calculateDuration);

    function calculateDuration() {
        const debut = document.getElementById('debut_activite').value;
        const fin = document.getElementById('fin_activite').value;

        if (debut && fin) {
            const debutDate = new Date(debut);
            const finDate = new Date(fin);
            const diffTime = Math.abs(finDate - debutDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            document.getElementById('dure_activite').value = diffDays;
        }
    }

    // Ajouter les écouteurs d'événements pour le premier bloc
    document.addEventListener('DOMContentLoaded', function() {
        addEventListeners(document.getElementById('localisations-container'));

        // Afficher la première étape
        document.getElementById('step1').style.display = 'block';

        // Ajouter les écouteurs pour les dépendances
        document.getElementById('branche').addEventListener('change', loadCorps);
        document.getElementById('corps').addEventListener('change', function() {
            loadMetiers();
            // Mettre à jour le champ caché avec le nom du corps de métier
            const corpsSelect = document.getElementById('corps');
            const selectedOption = corpsSelect.options[corpsSelect.selectedIndex];
            if (selectedOption) {
                document.getElementById('corps_nom').value = selectedOption.textContent;
            }
        });

        // Charger les anciennes valeurs si elles existent
        if ('{{ old("branche") }}') {
            loadCorps();
            // Attendre que les corps soient chargés avant de charger les métiers
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

    // Gestion de l'envoi du formulaire (ne désactive le bouton que si le formulaire est valide)
    const demandeForm = document.getElementById('demandeForm');
    const sendButton = document.getElementById('sendButton');
    demandeForm.addEventListener('submit', function(e) {
        // Calculer la durée avant soumission
        calculateDuration();

        // Si le formulaire est invalide, aller automatiquement à l'étape concernée
        if (!demandeForm.checkValidity()) {
            e.preventDefault();
            const firstInvalid = demandeForm.querySelector(':invalid');
            if (firstInvalid) {
                const stepEl = firstInvalid.closest('.form-step');
                if (stepEl && stepEl.id) {
                    const stepNum = parseInt(stepEl.id.replace('step', ''), 10);
                    // Afficher uniquement l'étape contenant l'erreur
                    for (let i = 1; i <= 5; i++) {
                        const el = document.getElementById(`step${i}`);
                        if (el) el.style.display = (i === stepNum) ? 'block' : 'none';
                    }
                }
                firstInvalid.classList.add('is-invalid');
                try {
                    firstInvalid.reportValidity();
                } catch (_) {}
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
</script>
<script>
    document.getElementById('ifu').addEventListener('input', function() {
        const input = this;
        const errorSpan = document.getElementById('ifu-custom-error');
        const value = input.value.length;

        // Réinitialiser le message d'erreur
        errorSpan.style.display = 'none';
        errorSpan.textContent = '';

        if (value > 0 && value < 13) {
            // Moins de 13 chiffres
            errorSpan.textContent = 'L\'IFU doit contenir exactement 13 chiffres. Vous en avez saisi ' + value + '.';
            errorSpan.style.display = 'block';
            input.setCustomValidity('Veuillez saisir exactement 13 chiffres.');
        } else if (value > 13) {
            // Plus de 13 chiffres (Bien que maxlength="13" le bloque)
            errorSpan.textContent = 'L\'IFU ne peut pas contenir plus de 13 chiffres.';
            errorSpan.style.display = 'block';
            input.setCustomValidity('Veuillez saisir exactement 13 chiffres.');
        } else {
            // Si la longueur est 13 ou vide, la validation est bonne pour le moment
            input.setCustomValidity('');
        }
    });

    // Gérer la soumission du formulaire pour forcer la validation
    document.querySelector('form').addEventListener('submit', function(event) {
        const input = document.getElementById('ifu');
        if (input.value.length !== 13) {
            input.reportValidity(); // Affiche le message de validation
            event.preventDefault(); // Empêche la soumission du formulaire
        }
    });
</script>
@endsection