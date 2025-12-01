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

    .detail-card:hover {
        transform: translateY(-3px);
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
        color: #dc3545;
        background: #ffeaea;
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

    .info-group {
        margin-bottom: 20px;
    }

    .info-label {
        font-size: 12px;
        text-transform: uppercase;
        color: #8898aa;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        display: block;
    }

    .info-value {
        font-size: 15px;
        color: #32325d;
        font-weight: 500;
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 8px;
        border-left: 4px solid #dc3545;
    }

    .budget-box {
        background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
        color: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
    }

    .budget-value {
        font-size: 24px;
        font-weight: 700;
        margin: 5px 0;
    }

    .file-download-card {
        background: #fff3cd;
        border: 1px dashed #ffc107;
        border-radius: 12px;
        padding: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #856404;
    }

    .cloture-badge {
        background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .navbar-brand {
        font-family: 'Poppins', sans-serif;
    }
</style>

<div class="main-panel" id="main-panel">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent bg-danger navbar-absolute">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
                <a href="{{ route('exercices.clotures') }}" class="btn btn-sm btn-outline-light rounded-circle me-2" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Retour">
                    <i class='bx bx-arrow-back' style="font-size: 18px;"></i>
                </a>
                <a class="navbar-brand" style="font-weight: bold; font-size: 1.2rem;">
                    Détail de la demande clôturée
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar navbar-kebab"></span>
                <span class="navbar-toggler-bar navbar-kebab"></span>
                <span class="navbar-toggler-bar navbar-kebab"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <ul class="navbar-nav">
                    <li class="mr-3">
                        <span class="cloture-badge">
                            <i class='bx bx-archive'></i> Exercice {{ $demande->annee_exercice_cloture }} Clôturé
                        </span>
                    </li>
                    <li class="mr-3">
                        @if (Auth::user()->email == 'spea@apps.fda.bj')
                        <h2 style="font-weight: bold">SPEA</h2>
                        @elseif (Auth::user()->email == 'sese@apps.fda.bj')
                        <h2 style="font-weight: bold">SESE</h2>
                        @elseif (Auth::user()->email == 'dg@apps.fda.bj')
                        <h2 style="font-weight: bold">DG</h2>
                        @elseif (Auth::user()->email == 'daf@apps.fda.bj')
                        <h2 style="font-weight: bold">DAF</h2>
                        @elseif (Auth::user()->email == 'do@apps.fda.bj')
                        <h2 style="font-weight: bold">DO</h2>
                        @endif
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="now-ui-icons users_single-02"></i>
                            <p>
                                <span class="d-lg-none d-md-block">Some Actions</span>
                            </p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();" style="font-weight: bold">
                                <i class="now-ui-icons media-1_button-power"></i>Deconnecter
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <div style="height: 17vh; background-color: #dc3545;"></div>

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <!-- Colonne Gauche : Infos Structure & Personnel -->
                <div class="col-lg-5">
                    <!-- Infos Structure -->
                    <div class="detail-card">
                        <div class="card-header-custom">
                            <i class='bx bx-building-house'></i>
                            <h5>Informations Structure</h5>
                        </div>
                        <div class="card-body-custom">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="info-group">
                                        <span class="info-label">Structure Demandeur</span>
                                        <div class="info-value">{{$demande->structure}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <span class="info-label">Service</span>
                                        <div class="info-value">{{$demande->service ==='Assistance' ? 'Activités de Promotion' : 'Formation / Renforcement de capacités'}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <span class="info-label">Type Demandeur</span>
                                        <div class="info-value">
                                            @if($demande->type_demande === 'professionnel')
                                            Association / Organisations professionnelles
                                            @elseif($demande->type_demande === 'structure')
                                            Structure formelle
                                            @elseif($demande->type_demande === 'ONG')
                                            Organisations Non Gouvernementales (ONG)
                                            @else
                                            {{ $demande->type_demande }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="info-group">
                                        <span class="info-label">Branche / Corps métier / Métier</span>
                                        <div class="info-value">
                                            {{ $branche ? $branche->nom : 'N/A' }} >
                                            {{ $corps ? $corps->nom : 'N/A' }} >
                                            <strong>{{ $metier ? $metier->nom : 'N/A' }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="info-group">
                                        <span class="info-label">Date de clôture</span>
                                        <div class="info-value">
                                            {{ $demande->date_cloture ? \Carbon\Carbon::parse($demande->date_cloture)->format('d/m/Y H:i') : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Infos Personnel -->
                    <div class="detail-card">
                        <div class="card-header-custom">
                            <i class='bx bx-user-pin'></i>
                            <h5>Informations Représentant</h5>
                        </div>
                        <div class="card-body-custom">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="info-group">
                                        <span class="info-label">Nom & Prénom</span>
                                        <div class="info-value">{{$demande->nom}} {{$demande->prenom}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <span class="info-label">IFU</span>
                                        <div class="info-value">{{$demande->ifu}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <span class="info-label">Contact</span>
                                        <div class="info-value">{{$demande->contact}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne Droite : Infos Projet & Localisation -->
                <div class="col-lg-7">
                    <!-- Infos Projet -->
                    <div class="detail-card">
                        <div class="card-header-custom">
                            <i class='bx bx-briefcase-alt-2'></i>
                            <h5>Détails du Projet</h5>
                        </div>
                        <div class="card-body-custom">
                            <div class="info-group">
                                <span class="info-label">Titre de l'activité</span>
                                <div class="info-value" style="font-size: 18px;">{{$demande->titre_activite}}</div>
                            </div>

                            <div class="info-group">
                                <span class="info-label">Objectifs</span>
                                <div class="info-value" style="background: #fff; border: 1px solid #e9ecef; min-height: 80px;">
                                    {{$demande->obejectif_activite}}
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="info-group text-center">
                                        <span class="info-label">Début</span>
                                        <div class="font-weight-bold text-dark">{{$demande->debut_activite}}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-group text-center">
                                        <span class="info-label">Fin</span>
                                        <div class="font-weight-bold text-dark">{{$demande->fin_activite}}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-group text-center">
                                        <span class="info-label">Durée</span>
                                        <div class="badge bg-info p-2">{{$demande->dure_activite}} Jours</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Budget Section -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="budget-box">
                                        <div class="info-label text-white opacity-75">Budget Demandé</div>
                                        <div class="budget-value">{{ number_format((float)$demande->budget, 0, ',', ' ') }} CFA</div>
                                    </div>
                                </div>
                                @if ($demande->buget_prevu != 0)
                                <div class="col-md-6">
                                    <div class="budget-box" style="background: linear-gradient(135deg, #2c3e50 0%, #4a627a 100%);">
                                        <div class="info-label text-white opacity-75">Budget Prévu</div>
                                        <div class="budget-value">{{ number_format((float)$demande->buget_prevu, 0, ',', ' ') }} CFA</div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Fichier Joint -->
                            @if($demande->piece)
                            <div class="mt-4">
                                <div class="file-download-card">
                                    <div>
                                        <strong><i class='bx bxs-file-pdf'></i> Pièce Jointe</strong>
                                        <p class="small mb-0">Document justificatif du projet</p>
                                    </div>
                                    <a href="{{route('demande.cloture.piece', $demande->id)}}" class="btn btn-warning btn-sm rounded-pill text-white">
                                        <i class='bx bx-download'></i> Télécharger
                                    </a>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>

                    <!-- Localisations -->
                    <div class="detail-card">
                        <div class="card-header-custom">
                            <i class='bx bx-map-pin'></i>
                            <h5>Localisations</h5>
                        </div>
                        <div class="card-body-custom">
                            @if(isset($localisations) && count($localisations))
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Département</th>
                                            <th>Commune</th>
                                            <th>Lieu</th>
                                            <th>Personnes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($localisations as $loc)
                                        <tr>
                                            <td class="font-weight-bold">{{ $loc->departement ? $loc->departement->nom : '-' }}</td>
                                            <td>{{ $loc->commune ? $loc->commune->nom : '-' }}</td>
                                            <td>{{ $loc->lieux }}</td>
                                            <td><span class="badge text-center bg-secondary">{{ $loc->homme_touche }}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-3 text-muted">
                                <i class='bx bx-map-alt display-4'></i>
                                <p>Aucune localisation spécifiée.</p>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    @include('Admin.footer')
</div>
@endsection