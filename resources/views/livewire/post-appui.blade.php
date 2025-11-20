<div>
    <!-- Modal pour le formulaire post-appui -->
    @if ($showModal)
    <div class="modal fade show" style="display: block;" tabindex="-1" aria-labelledby="postAppuiModalLabel"
        aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postAppuiModalLabel">Rapport post-appui</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="card-header">
                            <h5 class="title">Effectifs formés - {{ $structure }}</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Nombre d'hommes formés <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('effectif_homme_forme') is-invalid @enderror"
                                        wire:model="effectif_homme_forme" min="0" placeholder="Entrez le nombre d'hommes formés">
                                    @error('effectif_homme_forme')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Nombre de femmes formées <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('effectif_femme_forme') is-invalid @enderror"
                                        wire:model="effectif_femme_forme" min="0" placeholder="Entrez le nombre de femmes formées">
                                    @error('effectif_femme_forme')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

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
                    <a class="navbar-brand" href="#pablo">Suivi Post-Appui</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                    aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navigation">
                    <form class="mr-4">
                        <div class="input-group no-border">
                            <input type="text" value="" class="form-control" placeholder="Rechercher...">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                <p></p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();" style="font-weight: bold">
                                    <i class="now-ui-icons media-1_button-power"></i>Déconnecter
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
        <div class="panel-header panel-header-sm">
        </div>
        <div class="content">
            <!-- Cartes de statistiques -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted text-uppercase mb-1" style="font-size: 12px;">Structures appuyées</p>
                            <h3 class="mb-0">{{ $totalStructures }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted text-uppercase mb-1" style="font-size: 12px;">Rapports déposés</p>
                            <h3 class="mb-0">{{ $structuresAvecRapport }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted text-uppercase mb-1" style="font-size: 12px;">Ratio dépôt de rapport</p>
                            <div class="d-flex align-items-end justify-content-between">
                                <div>
                                    <h3 class="mb-0">{{ $structuresAvecRapport }}/{{ $totalStructures }}</h3>
                                    <small class="text-muted">Structures ayant déposé / appuyées</small>
                                </div>
                                <span class="badge bg-primary" style="font-size: 14px;">{{ $ratio }}%</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-success" role="progressbar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tableau des demandes -->
                <div class=" row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-4 mb-4">
                                    <table class="table mt-4 mb-4">
                                        <thead class="text-primary text-center mb-4">
                                            <th style="font-weight: bold">Structure</th>
                                            <th style="font-weight: bold">Budget demandé</th>
                                            <th style="font-weight: bold">Budget Attribué</th>
                                            <th style="font-weight: bold">Statut Rapport</th>
                                            <th style="font-weight: bold">Action</th>
                                        </thead>
                                        <tbody class="mb-4">
                                            @forelse ($demandes as $demande)
                                            <tr>
                                                <td class="text-center">{{ $demande->structure }}</td>
                                                <td class="text-center">{{ number_format($demande->budget, 0, ',', ' ') }} FCFA</td>
                                                <td class="text-center">{{ number_format($demande->buget_prevu, 0, ',', ' ') }} FCFA</td>
                                                <td class="text-center">
                                                    @if ($demande->rapport_depose)
                                                    <span class="btn btn-success btn-sm">Rapport déposé</span>
                                                    @else
                                                    <span class="btn btn-warning btn-sm">En attente</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">

                                                    <button wire:click="edit({{ $demande->id }})" id="tooltip"
                                                        class="btn btn-success mb-2">
                                                        <span class="tooltiptext">Déposer/Éditer rapport</span>
                                                        <i class="now-ui-icons files_paper"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td class="text-center" colspan="7">
                                                    <p style="font-weight: bold">Aucune demande approuvée</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center pagination">
                                        {{ $demandes->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('Admin.footer')
        </div>
    </div>

    <style>
        a#tooltip,
        button#tooltip {
            position: relative;
            display: inline-block;
        }

        a#tooltip .tooltiptext,
        button#tooltip .tooltiptext {
            visibility: hidden;
            width: 150px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -75px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
        }

        a#tooltip:hover .tooltiptext,
        button#tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination .page-link {
            color: #2c2c54;
            border: 1px solid #ddd;
            padding: 8px 12px;
        }

        .pagination .page-item.active .page-link {
            background-color: #2c2c54;
            border-color: #2c2c54;
        }

        .pagination .page-link:hover {
            background-color: #f8f9fa;
            color: #2c2c54;
        }
    </style>