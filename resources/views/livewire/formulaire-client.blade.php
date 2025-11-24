<div>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
        }

        .form-wrapper {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
            padding: 40px;
            margin-top: 30px;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
        }

        .stepper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #e9ecef;
            z-index: 0;
        }

        .step-item {
            position: relative;
            z-index: 1;
            text-align: center;
            width: 25%;
        }

        .step-circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .step-item.active .step-circle {
            background: #22a6b3;
            color: #fff;
            box-shadow: 0 0 0 5px rgba(34, 166, 179, 0.2);
        }

        .step-item.completed .step-circle {
            background: #22a6b3;
            color: #fff;
        }

        .step-text {
            font-size: 12px;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .step-item.active .step-text {
            color: #22a6b3;
            font-weight: 700;
        }

        .form-label-custom {
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
            transition: all 0.3s;
            background-color: #fcfcfc;
        }

        .form-control:focus {
            border-color: #22a6b3;
            box-shadow: 0 0 0 4px rgba(34, 166, 179, 0.1);
            background-color: #fff;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            background-color: #fff5f5;
        }

        .section-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .section-header h3 {
            font-weight: 700;
            color: #2c3e50;
            font-size: 24px;
        }

        .section-header p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .form-navigation {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f1f1f1;
            display: flex;
            justify-content: space-between;
        }

        .btn-nav {
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s;
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
            transform: translateY(-1px);
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 20px;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }

        .input-hint {
            font-size: 11px;
            color: #6c757d;
            margin-top: 3px;
            display: block;
        }

        .input-group-text {
            background-color: #22a6b3;
            color: white;
            border: 1px solid #22a6b3;
            border-radius: 10px 0 0 10px;
            font-weight: 600;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }
    </style>

    <main id="main">
        <section class="section py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <div class="text-center mb-4" data-aos="fade-up">
                            <h2 style="font-weight: 700; color: #2c3e50;">Formulaire de Demande</h2>
                            <p class="text-muted">Veuillez remplir les informations ci-dessous avec précision.</p>
                        </div>

                        <div class="form-wrapper" data-aos="fade-up" data-aos-delay="100">

                            <div class="stepper">
                                <div class="step-item {{ $formStep >= 1 ? 'active' : '' }} {{ $formStep > 1 ? 'completed' : '' }}">
                                    <div class="step-circle">1</div>
                                    <div class="step-text">Structure</div>
                                </div>
                                <div class="step-item {{ $formStep >= 2 ? 'active' : '' }} {{ $formStep > 2 ? 'completed' : '' }}">
                                    <div class="step-circle">2</div>
                                    <div class="step-text">Personnel</div>
                                </div>
                                <div class="step-item {{ $formStep >= 3 ? 'active' : '' }} {{ $formStep > 3 ? 'completed' : '' }}">
                                    <div class="step-circle">3</div>
                                    <div class="step-text">Projet</div>
                                </div>
                                <div class="step-item {{ $formStep >= 4 ? 'active' : '' }}">
                                    <div class="step-circle">4</div>
                                    <div class="step-text">Pièces</div>
                                </div>
                            </div>

                            <form wire:submit.prevent="store" enctype="multipart/form-data">
                                @csrf

                                <div wire:loading wire:target="store, nextStep1, nextStep2, nextStep3, prevStep" class="loading-overlay">
                                    <div class="spinner-border text-info" role="status">
                                        <span class="visually-hidden">Chargement...</span>
                                    </div>
                                </div>

                                @if ($formStep == 1)
                                <div class="section-header">
                                    <h3>Informations sur la structure</h3>
                                    <p>Identifiez votre entité et le type d'aide souhaité</p>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Structure Demandeur <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('structure') is-invalid @enderror"
                                            wire:model="structure"
                                            placeholder="Ex: Coopérative des Artisans">
                                        @error('structure') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Service <span class="text-danger">*</span></label>
                                        <select class="form-control @error('service') is-invalid @enderror" wire:model="service">
                                            <option value="">Sélectionnez un service</option>
                                            <option value="Assistance">Demande Assistance</option>
                                            <option value="Formation">Demande Formation</option>
                                            <option value="Financier">Appui Financier</option>
                                        </select>
                                        @error('service') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Type Demandeur <span class="text-danger">*</span></label>
                                        <select class="form-control @error('type_demande') is-invalid @enderror" wire:model="type_demande">
                                            <option value="">Sélectionnez le type</option>
                                            <option value="professionnel">Organisations professionnelles d'artisans</option>
                                            <option value="structure">Associations/Structures formelles</option>
                                            <option value="ONG">Organisations Non Gouvernementales (ONG)</option>
                                        </select>
                                        @error('type_demande') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Branche</label>
                                        <select class="form-control @error('branche') is-invalid @enderror" wire:model="branche">
                                            <option value="">Sélectionnez une branche</option>
                                            @forelse ($branches as $branche)
                                            <option value="{{$branche->id}}">{{$branche->nom}}</option>
                                            @empty
                                            <option value="" disabled>Aucune branche disponible</option>
                                            @endforelse
                                        </select>
                                        @error('branche') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Corps de Métier</label>
                                        <select class="form-control @error('corps') is-invalid @enderror" wire:model="corps">
                                            <option value="">Sélectionnez un corps de métier</option>
                                            @forelse ($corp as $corps)
                                            <option value="{{$corps->id}}">{{$corps->nom}}</option>
                                            @empty
                                            <option value="" disabled>Aucun corps disponible</option>
                                            @endforelse
                                        </select>
                                        @error('corps') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Métier</label>
                                        <select class="form-control @error('metier') is-invalid @enderror" wire:model="metier">
                                            <option value="">Sélectionnez un métier</option>
                                            @forelse ($metiers as $metier)
                                            <option value="{{$metier->id}}">{{$metier->nom}}</option>
                                            @empty
                                            <option value="" disabled>Aucun métier disponible</option>
                                            @endforelse
                                        </select>
                                        @error('metier') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @endif

                                @if ($formStep == 2)
                                <div class="section-header">
                                    <h3>Informations personnelles</h3>
                                    <p>Détails sur le représentant</p>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Nom <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('nom') is-invalid @enderror"
                                            wire:model="nom"
                                            placeholder="Ex: ADJOVI">
                                        @error('nom') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Prénom <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('prenom') is-invalid @enderror"
                                            wire:model="prenom"
                                            placeholder="Ex: Jean-Marie">
                                        @error('prenom') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Email <span class="text-danger">*</span></label>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            wire:model="email"
                                            placeholder="exemple@email.com">
                                        @error('email') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Sexe <span class="text-danger">*</span></label>
                                        <select class="form-control @error('sexe') is-invalid @enderror" wire:model="sexe">
                                            <option value="">Choisir...</option>
                                            <option value="Masculin">Masculin</option>
                                            <option value="Feminin">Féminin</option>
                                        </select>
                                        @error('sexe') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">IFU <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('ifu') is-invalid @enderror"
                                            wire:model="ifu"
                                            placeholder="Ex: 1234567890123"
                                            maxlength="13">
                                        <small class="input-hint">13 chiffres exactement</small>
                                        @error('ifu') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Contact</label>
                                        <div class="input-group">

                                            <input type="text"
                                                class="form-control @error('contact') is-invalid @enderror"
                                                wire:model="contact"
                                                placeholder="97123456"
                                                maxlength="8">
                                        </div>

                                        @error('contact') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @endif

                                @if ($formStep == 3)
                                <div class="section-header">
                                    <h3>Détails du Projet</h3>
                                    <p>Parlez-nous de votre activité</p>
                                </div>

                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label-custom">Titre de l'activité <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('titre_activite') is-invalid @enderror"
                                            wire:model="titre_activite"
                                            placeholder="Ex: Formation en menuiserie moderne">
                                        @error('titre_activite') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Objectif de l'activité <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('obejectif_activite') is-invalid @enderror"
                                            rows="3"
                                            wire:model="obejectif_activite"
                                            placeholder="Décrivez les objectifs (minimum 20 caractères)"></textarea>
                                        <small class="input-hint">Minimum 20 caractères</small>
                                        @error('obejectif_activite') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Date début</label>
                                        <input type="date"
                                            class="form-control @error('debut_activite') is-invalid @enderror"
                                            min="{{$date}}"
                                            wire:model="debut_activite">
                                        @error('debut_activite') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Date fin</label>
                                        <input type="date"
                                            class="form-control @error('fin_activite') is-invalid @enderror"
                                            min="{{$debut_activite}}"
                                            wire:model="fin_activite">
                                        @error('fin_activite') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label-custom">Durée (jours)</label>
                                        <input type="number"
                                            class="form-control"
                                            wire:model="dure_activite"
                                            readonly
                                            style="background-color: #e9ecef;">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label-custom">Département <small class="text-muted">(Optionnel)</small></label>
                                        <select class="form-control @error('departement') is-invalid @enderror" wire:model="departement">
                                            <option value="">Choisir...</option>
                                            @forelse ($departements as $departement)
                                            <option value="{{$departement->id}}">{{$departement->nom}}</option>
                                            @empty
                                            <option value="" disabled>Aucun</option>
                                            @endforelse
                                        </select>
                                        @error('departement') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label-custom">Commune <small class="text-muted">(Optionnel)</small></label>
                                        <select class="form-control @error('commune') is-invalid @enderror" wire:model="commune">
                                            <option value="">Choisir...</option>
                                            @forelse ($communes as $commune)
                                            <option value="{{$commune->id}}">{{$commune->nom}}</option>
                                            @empty
                                            <option value="" disabled>Aucune</option>
                                            @endforelse
                                        </select>
                                        @error('commune') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label-custom">Lieu d'exécution (Précis) <small class="text-muted">(Optionnel)</small></label>
                                        <input type="text"
                                            class="form-control @error('lieux') is-invalid @enderror"
                                            wire:model="lieux"
                                            placeholder="Ex: Quartier Akpakpa, Rue 123">
                                        @error('lieux') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label-custom">Hommes touchés</label>
                                        <input type="number"
                                            class="form-control @error('homme_touche') is-invalid @enderror"
                                            wire:model="homme_touche"
                                            placeholder="0"
                                            min="0">
                                        @error('homme_touche') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-custom">Femmes touchées</label>
                                        <input type="number"
                                            class="form-control @error('femme_touche') is-invalid @enderror"
                                            wire:model="femme_touche"
                                            placeholder="0"
                                            min="0">
                                        @error('femme_touche') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-custom">Budget Prévisionnel <span class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('budget') is-invalid @enderror"
                                            wire:model="budget"
                                            placeholder="500000"
                                            min="1">
                                        <small class="input-hint">En FCFA</small>
                                        @error('budget') <span class="error-message">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @endif

                                @if ($formStep == 4)
                                <div class="section-header">
                                    <h3>Documents</h3>
                                    <p>Joindre les pièces justificatives <small class="text-muted">(Optionnel)</small></p>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="p-4 border border-dashed rounded text-center @error('piece') border-danger @else bg-light @enderror">
                                            <i class="bx bx-cloud-upload display-4 text-muted mb-3"></i>
                                            <label class="form-label-custom d-block">Fichier du projet <small class="text-muted">(Optionnel)</small></label>
                                            <input type="file"
                                                class="form-control @error('piece') is-invalid @enderror"
                                                wire:model="piece"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <div class="small text-muted mt-2">Formats: PDF, JPG, PNG (Max: 5 Mo)</div>
                                            @error('piece') <span class="error-message">{{ $message }}</span> @enderror

                                            @if ($piece)
                                            <div class="mt-3">
                                                <span class="badge bg-success">✓ Fichier sélectionné</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="form-navigation">
                                    @if ($formStep == 1)
                                    <div></div>
                                    <button type="button" class="btn-nav btn-next" wire:click="nextStep1">
                                        Suivant <i class="bx bx-chevron-right ms-1"></i>
                                    </button>
                                    @elseif ($formStep > 1)
                                    <button type="button" class="btn-nav btn-prev" wire:click="prevStep">
                                        <i class="bx bx-chevron-left me-1"></i> Précédent
                                    </button>

                                    @if ($formStep < 4)
                                        <button type="button" class="btn-nav btn-next" wire:click="nextStep{{ $formStep }}">
                                        Suivant <i class="bx bx-chevron-right ms-1"></i>
                                        </button>
                                        @else
                                        <button type="submit" class="btn-nav btn-next" wire:loading.attr="disabled">
                                            <i class="bx bx-send me-1"></i> Envoyer la demande
                                        </button>
                                        @endif
                                        @endif
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
</div>