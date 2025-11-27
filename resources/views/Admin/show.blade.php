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
        /* height: 100%; Supprimé pour s'adapter au contenu */
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
        border-left: 4px solid #198754;
    }

    .budget-box {
        background: linear-gradient(135deg, #198754 0%, #146c43 100%);
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

    .navbar-brand {
        font-family: 'Poppins', sans-serif;
    }

    .btn-action {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .btn-view {
        color: #009879;
        border-color: #009879;
    }

    .btn-view:hover {
        background-color: #009879;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-check {
        color: #27ae60;
        border-color: #27ae60;
    }

    .btn-check:hover {
        background-color: #27ae60;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-pause {
        color: #f39c12;
        border-color: #f39c12;
    }

    .btn-pause:hover {
        background-color: #f39c12;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-delete {
        color: #c0392b;
        border-color: #c0392b;
    }

    .btn-delete:hover {
        background-color: #c0392b;
        color: #fff;
        transform: translateY(-2px);
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
                <a class="navbar-brand" style="font-weight: bold; font-size: 1.2rem;">
                    Détail de la demande
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

    <div style="height: 17vh; background-color: #198754;"></div>

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
                            <div class="mt-4">
                                <div class="file-download-card">
                                    <div>
                                        <strong><i class='bx bxs-file-pdf'></i> Pièce Jointe</strong>
                                        <p class="small mb-0">Document justificatif du projet</p>
                                    </div>
                                    <a href="{{route('demande.piece',$demande->id)}}" class="btn btn-warning btn-sm rounded-pill text-white">
                                        <i class='bx bx-download'></i> Télécharger
                                    </a>
                                </div>
                            </div>

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
                    <div class="d-flex justify-content-start gap-4">
                        @if($demande->statuts !== 'Approuvé')
                        @can('process-demandes')
                        <a href="{{route('demande.budget',$demande->id)}}" class="btn-action btn-view" title="Valider">
                            <i class="now-ui-icons ui-1_check"></i>
                        </a>
                        @endcan

                        @can('view-liste-demandes')
                        <a href="{{route('demande.edit',$demande->id)}}" class="btn-action btn-edit" title="Modifier">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                            </svg>
                        </a>
                        @endcan

                        @can('transmit-demandes')
                        <button onclick="confirmerTransmission({{$demande->id}})" class="btn-action btn-send" title="Transmettre">
                            <i class="now-ui-icons ui-1_send"></i>
                        </button>
                        @endcan
                        @can('process-demandes')
                        <button onclick="confirmerRejet({{$demande->id}})" class="btn-action btn-pause" title="Rejeter">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                            </svg>
                        </button>
                        @endcan
                        @can('manage-demandes')
                        <button onclick="confirmerSuppression({{$demande->id}})" class="btn-action btn-delete" title="Supprimer">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                            </svg>
                        </button>
                        @endcan
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmerTransmission(demandeId) {
            Swal.fire({
                title: 'Confirmation',
                text: 'Êtes-vous sûr de vouloir transmettre cette demande ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#009879',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, transmettre',
                cancelButtonText: 'Annuler',
                customClass: {
                    popup: 'swal-poppins'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.find('{{ $id }}').call('Transmetre', demandeId);
                }
            });
        }

        function confirmerSuppression(demandeId) {
            Swal.fire({
                title: 'Confirmation de suppression',
                text: 'Êtes-vous sûr de vouloir supprimer cette demande ? Cette action est irréversible.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                customClass: {
                    popup: 'swal-poppins'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteUrl = "{{ url('/delete') }}/" + demandeId;
                    window.location.href = deleteUrl;
                }
            });
        }

        function confirmerRejet(demandeId) {
            Swal.fire({
                title: 'Confirmation de rejet',
                text: 'Êtes-vous sûr de vouloir rejeter cette demande ? Vous devrez fournir un message de rejet.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f39c12',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, rejeter',
                cancelButtonText: 'Annuler',
                customClass: {
                    popup: 'swal-poppins'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const rejectUrl = "{{ url('/suspendre_demande') }}/" + demandeId;
                    window.location.href = rejectUrl;
                }
            });
        }

        function confirmerRejet(demandeId) {
            Swal.fire({
                title: 'Confirmation de rejet',
                text: 'Êtes-vous sûr de vouloir rejeter cette demande ? Vous devrez fournir un message de rejet.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f39c12',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, rejeter',
                cancelButtonText: 'Annuler',
                customClass: {
                    popup: 'swal-poppins'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const rejectUrl = "{{ url('/suspendre_demande') }}/" + demandeId;
                    window.location.href = rejectUrl;
                }
            });
        }
    </script>

    @include('Admin.footer')
</div>
@endsection