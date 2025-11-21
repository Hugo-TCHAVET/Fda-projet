<div>
    <!-- Import Poppins localement si non présent dans le layout -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
        }

        /* Container du formulaire */
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

        /* Barre de progression (Stepper) */
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

        /* Styles des Inputs */
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

        /* Titres */
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

        /* Boutons de navigation */
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

        /* Animation de chargement custom */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 20px;
        }
    </style>

    <main id="main">
        <section class="section py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <!-- Titre principal page -->
                        <div class="text-center mb-4" data-aos="fade-up">
                            <h2 style="font-weight: 700; color: #2c3e50;">Formulaire de Demande</h2>
                            <p class="text-muted">Veuillez remplir les informations ci-dessous avec précision.</p>
                        </div>

                        <div class="form-wrapper" data-aos="fade-up" data-aos-delay="100">

                            <!-- Stepper Navigation -->
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

                            <!-- Formulaire -->
                            <form wire:submit.prevent="store" enctype="multipart/form-data">
                                @csrf

                                <!-- Loader -->
                                <div wire:loading wire:target="store, nextStep1, nextStep2, nextStep3, prevStep" class="loading-overlay">
                                    <div class="spinner-border text-info" role="status">
                                        <span class="visually-hidden">Chargement...</span>
                                    </div>
                                </div>

                                <!-- ÉTAPE 1 : STRUCTURE -->
                                @if ($formStep == 1)
                                <div class="section-header">
                                    <h3>Informations sur la structure</h3>
                                    <p>Identifiez votre entité et le type d'aide souhaité</p>
                                </div>

                                <div class="row g-4"> <!-- g-4 pour espacement Bootstrap 5 -->
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Structure Demandeur</label>
                                        <input type="text" class="form-control" wire:model.lazy="structure" placeholder="Nom de la structure">
                                        @error('structure') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Service</label>
                                        <select class="form-control" wire:model.lazy="service">
                                            <option value="" selected>Sélectionnez un service</option>
                                            <option value="Assistance">Demande Assistance</option>
                                            <option value="Formation">Demande Formation</option>
                                            <option value="Financier">Appui Financier</option>
                                        </select>
                                        @error('service') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Type Demandeur</label>
                                        <select class="form-control" wire:model.lazy="type_demande">
                                            <option value="" selected>Sélectionnez le type</option>
                                            <option value="professionnel">Organisations professionnelles d’artisans</option>
                                            <option value="structure">Associations/Structures formelles</option>
                                            <option value="ONG">Organisations Non Gouvernementales (ONG)</option>
                                        </select>
                                        @error('type_demande') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Branche</label>
                                        <select class="form-control" wire:model.lazy="branche">
                                            <option value="" selected>Sélectionnez une branche</option>
                                            @forelse ($branches as $branche)
                                            <option value="{{$branche->id}}">{{$branche->nom}}</option>
                                            @empty
                                            <option value="" disabled>Aucune branche disponible</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Corps de Métier</label>
                                        <select class="form-control" wire:model.lazy="corps">
                                            <option value="" selected>Sélectionnez un corps de métier</option>
                                            @forelse ($corp as $corps)
                                            <option value="{{$corps->id}}">{{$corps->nom}}</option>
                                            @empty
                                            <option value="" disabled>Aucun corps disponible</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Métier</label>
                                        <select class="form-control" wire:model.lazy="metier">
                                            <option value="" selected>Sélectionnez un métier</option>
                                            @forelse ($metiers as $metier)
                                            <option value="{{$metier->id}}">{{$metier->nom}}</option>
                                            @empty
                                            <option value="" disabled>Aucun métier disponible</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                @endif

                                <!-- ÉTAPE 2 : PERSONNEL -->
                                @if ($formStep == 2)
                                <div class="section-header">
                                    <h3>Informations personnelles</h3>
                                    <p>Détails sur le représentant</p>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Nom</label>
                                        <input type="text" class="form-control" wire:model.lazy="nom" placeholder="Votre nom">
                                        @error('nom') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Prénom</label>
                                        <input type="text" class="form-control" wire:model.lazy="prenom" placeholder="Votre prénom">
                                        @error('prenom') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Email</label>
                                        <input type="email" class="form-control" wire:model.lazy="email" placeholder="exemple@email.com">
                                        @error('email') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Sexe</label>
                                        <select class="form-control" wire:model.lazy="sexe">
                                            <option value="" selected>Choisir...</option>
                                            <option value="Masculin">Masculin</option>
                                            <option value="Feminin">Féminin</option>
                                        </select>
                                        @error('sexe') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">IFU</label>
                                        <input type="text" class="form-control" wire:model.lazy="ifu" placeholder="Numéro IFU">
                                        @error('ifu') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Contact</label>
                                        <input type="number" class="form-control" wire:model.lazy="contact" placeholder="Téléphone">
                                        @error('contact') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @endif

                                <!-- ÉTAPE 3 : PROJET -->
                                @if ($formStep == 3)
                                <div class="section-header">
                                    <h3>Détails du Projet</h3>
                                    <p>Parlez-nous de votre activité</p>
                                </div>

                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label-custom">Titre de l'activité</label>
                                        <input type="text" class="form-control" wire:model.lazy="titre_activite" placeholder="Intitulé du projet">
                                        @error('titre_activite') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Objectif de l'activité</label>
                                        <textarea class="form-control" rows="3" wire:model.lazy="obejectif_activite" placeholder="Décrivez brièvement les objectifs..."></textarea>
                                        @error('obejectif_activite') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Date début</label>
                                        <input type="date" class="form-control" min="{{$date}}" wire:model.lazy="debut_activite">
                                        @error('debut_activite') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Date fin</label>
                                        <input type="date" class="form-control" min="{{$debut_activite}}" wire:model.lazy="fin_activite">
                                        @error('fin_activite') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label-custom">Durée (jours)</label>
                                        <input type="number" class="form-control" wire:model.lazy="dure_activite" readonly style="background-color: #e9ecef;">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label-custom">Département</label>
                                        <select class="form-control" wire:model.lazy="departement">
                                            <option value="" selected>Choisir...</option>
                                            @forelse ($departements as $departement)
                                            <option value="{{$departement->id}}">{{$departement->nom}}</option>
                                            @empty
                                            <option value="" disabled>Aucun</option>
                                            @endforelse
                                        </select>
                                        @error('departement') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label-custom">Commune</label>
                                        <select class="form-control" wire:model.lazy="commune">
                                            <option value="" selected>Choisir...</option>
                                            @forelse ($communes as $commune)
                                            <option value="{{$commune->id}}">{{$commune->nom}}</option>
                                            @empty
                                            <option value="" disabled>Aucune</option>
                                            @endforelse
                                        </select>
                                        @error('commune') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label-custom">Lieu d'exécution (Précis)</label>
                                        <input type="text" class="form-control" wire:model.lazy="lieux">
                                        @error('lieux') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label-custom">Hommes touchés</label>
                                        <input type="number" class="form-control" wire:model.lazy="homme_touche">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-custom">Femmes touchées</label>
                                        <input type="number" class="form-control" wire:model.lazy="femme_touche">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-custom">Budget Prévisionnel</label>
                                        <input type="number" class="form-control" wire:model.lazy="budget">
                                        @error('budget') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @endif

                                <!-- ÉTAPE 4 : PIÈCES -->
                                @if ($formStep == 4)
                                <div class="section-header">
                                    <h3>Documents</h3>
                                    <p>Joindre les pièces justificatives</p>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="p-4 border border-dashed rounded text-center bg-light">
                                            <i class="bx bx-cloud-upload display-4 text-muted mb-3"></i>
                                            <label class="form-label-custom d-block">Fichier du projet</label>
                                            <input type="file" class="form-control" wire:model.lazy="piece">
                                            <div class="small text-muted mt-2">Formats acceptés: PDF, JPG, PNG</div>
                                            @error('piece') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Navigation Buttons -->
                                <div class="form-navigation">
                                    @if ($formStep == 1)
                                    <div></div> <!-- Spacer pour pousser le bouton à droite -->
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