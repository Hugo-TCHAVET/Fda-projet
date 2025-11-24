@extends('Commun.Admin')
<base href="{{asset('Admin')}}">
@section('contenu')

<!-- Ajout Boxicons & Fonts -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .detail-card {
        background: #fff;
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        height: auto;
        transition: transform 0.3s ease;
    }

    .card-header-custom {
        padding: 20px 25px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header-custom i {
        font-size: 20px;
        color: #198754;
        background: #e9f7ef;
        padding: 8px;
        border-radius: 8px;
    }

    .card-header-custom h5 {
        margin: 0;
        font-weight: 600;
        color: #2c3e50;
        font-size: 16px;
    }

    .card-body-custom {
        padding: 25px;
    }

    .form-label-custom {
        font-size: 13px;
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 10px 15px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15);
    }
</style>

<div class="main-panel" id="main-panel">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent bg-primary navbar-absolute">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-light rounded-circle me-2" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Retour">
                    <i class='bx bx-arrow-back' style="font-size: 18px;"></i>
                </a>
                <a class="navbar-brand" href="#" style="font-weight: 600; font-size: 20px;">
                    Modifier la demande
                </a>
            </div>

            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <ul class="navbar-nav">
                    <li class="mr-3">
                        @if (Auth::user()->email == 'spea@gmail.com')
                        <h2 style="font-weight: bold">SPEA</h2>
                        @elseif (Auth::user()->email == 'sese@gmail.com')
                        <h2 style="font-weight: bold">SESE</h2>
                        @elseif (Auth::user()->email == 'dg@gmail.com')
                        <h2 style="font-weight: bold">DG</h2>
                        @elseif (Auth::user()->email == 'daf@gmail.com')
                        <h2 style="font-weight: bold">DAF</h2>
                        @elseif (Auth::user()->email == 'do@gmail.com')
                        <h2 style="font-weight: bold">DO</h2>
                        @endif
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="now-ui-icons users_single-02"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="now-ui-icons media-1_button-power"></i> Déconnecter
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <div style="height: 17vh; background-color: #198754;"></div>

    <div class="content">
        <div class="container-fluid">

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erreur!</strong> Veuillez vérifier les champs du formulaire.
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <form action="{{ route('update.demande', $demande->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Colonne Gauche -->
                    <div class="col-lg-5">
                        <!-- Structure -->
                        <div class="detail-card">
                            <div class="card-header-custom">
                                <i class='bx bx-building-house'></i>
                                <h5>Informations Structure</h5>
                            </div>
                            <div class="card-body-custom">
                                <div class="form-group mb-3">
                                    <label class="form-label-custom">Structure Demandeur</label>
                                    <input type="text" name="structure" class="form-control" value="{{ old('structure', $demande->structure) }}" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Service</label>
                                            <select name="service" class="form-control">
                                                <option value="Assistance" {{ $demande->service == 'Assistance' ? 'selected' : '' }}>Assistance</option>
                                                <option value="Formation" {{ $demande->service == 'Formation' ? 'selected' : '' }}>Formation</option>
                                                <option value="Financier" {{ $demande->service == 'Financier' ? 'selected' : '' }}>Financier</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Type</label>
                                            <select name="type_demande" class="form-control">
                                                <option value="professionnel" {{ $demande->type_demande == 'professionnel' ? 'selected' : '' }}>Professionnel</option>
                                                <option value="structure" {{ $demande->type_demande == 'structure' ? 'selected' : '' }}>Structure</option>
                                                <option value="ONG" {{ $demande->type_demande == 'ONG' ? 'selected' : '' }}>ONG</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Qualification -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Branche</label>
                                            <select name="branche" id="branche" class="form-control">
                                                <option value="">Selectionner</option>
                                                @foreach($branches as $branche)
                                                <option value="{{ $branche->id }}" {{ $demande->branche == $branche->id ? 'selected' : '' }}>{{ $branche->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Corps</label>
                                            <select name="corps" id="corps" class="form-control">
                                                <option value="">Selectionner</option>
                                                @foreach($corp as $c)
                                                <option value="{{ $c->id }}" {{ $demande->corps == $c->id ? 'selected' : '' }}>{{ $c->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Métier</label>
                                            <select name="metier" id="metier" class="form-control">
                                                <option value="">Selectionner</option>
                                                @foreach($metiers as $m)
                                                <option value="{{ $m->id }}" {{ $demande->metier == $m->id ? 'selected' : '' }}>{{ $m->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Représentant -->
                        <div class="detail-card">
                            <div class="card-header-custom">
                                <i class='bx bx-user-pin'></i>
                                <h5>Informations Représentant</h5>
                            </div>
                            <div class="card-body-custom">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Nom</label>
                                            <input type="text" name="nom" class="form-control" value="{{ old('nom', $demande->nom) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Prénom</label>
                                            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $demande->prenom) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Sexe</label>
                                            <select name="sexe" class="form-control" required>
                                                <option value="Masculin" {{ $demande->sexe == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                                <option value="Féminin" {{ $demande->sexe == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">IFU</label>
                                            <input type="text" name="ifu" class="form-control" value="{{ old('ifu', $demande->ifu) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Contact</label>
                                            <input type="text" name="contact" class="form-control" value="{{ old('contact', $demande->contact) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Colonne Droite -->
                    <div class="col-lg-7">
                        <!-- Projet -->
                        <div class="detail-card">
                            <div class="card-header-custom">
                                <i class='bx bx-briefcase-alt-2'></i>
                                <h5>Détails du Projet</h5>
                            </div>
                            <div class="card-body-custom">
                                <div class="form-group mb-3">
                                    <label class="form-label-custom">Titre de l'activité</label>
                                    <input type="text" name="titre_activite" class="form-control" value="{{ old('titre_activite', $demande->titre_activite) }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label-custom">Objectifs</label>
                                    <textarea name="obejectif_activite" class="form-control" rows="3" required>{{ old('obejectif_activite', $demande->obejectif_activite) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Début</label>
                                            <input type="date" name="debut_activite" class="form-control" value="{{ old('debut_activite', $demande->debut_activite) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Fin</label>
                                            <input type="date" name="fin_activite" class="form-control" value="{{ old('fin_activite', $demande->fin_activite) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Durée (jours)</label>
                                            <input type="number" name="dure_activite" class="form-control" value="{{ old('dure_activite', $demande->dure_activite) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label-custom">Budget Demandé</label>
                                            <input type="number" name="budget" class="form-control" value="{{ old('budget', $demande->budget) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Localisations -->
                        <div class="detail-card">
                            <div class="card-header-custom">
                                <i class='bx bx-map-pin'></i>
                                <h5>Localisations (facultatif)</h5>
                            </div>
                            <div class="card-body-custom">
                                <div id="localisations-wrapper">
                                    @php
                                    // Si aucune localisation, on crée une collection avec un objet vide pour afficher le formulaire
                                    $locs = ($localisations && count($localisations) > 0) ? $localisations : [new \App\Models\DemandeLocalisation];
                                    @endphp

                                    @foreach($locs as $index => $loc)
                                    <div class="localisation-item border rounded p-3 mb-3 bg-light position-relative">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="small text-muted">Département</label>
                                                <select name="localisations[{{$index}}][departement_id]" class="form-control form-control-sm">
                                                    <option value="">Choisir...</option>
                                                    @foreach($departements as $dept)
                                                    <option value="{{ $dept->id }}" {{ $loc->departement_id == $dept->id ? 'selected' : '' }}>{{ $dept->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="small text-muted">Commune</label>
                                                <select name="localisations[{{$index}}][commune_id]" class="form-control form-control-sm">
                                                    <option value="">Choisir...</option>
                                                    @foreach($communes as $com)
                                                    <option value="{{ $com->id }}" {{ $loc->commune_id == $com->id ? 'selected' : '' }}>{{ $com->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label class="small text-muted">Lieu</label>
                                                <input type="text" name="localisations[{{$index}}][lieux]" class="form-control form-control-sm" value="{{ $loc->lieux }}">
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label class="small text-muted">Personnes touchés</label>
                                                <input type="number" name="localisations[{{$index}}][homme_touche]" class="form-control form-control-sm" value="{{ $loc->homme_touche }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                                <i class='bx bx-save'></i> Enregistrer les modifications
                            </button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>

    @include('Admin.footer')
</div>
@endsection