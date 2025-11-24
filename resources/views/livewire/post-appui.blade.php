<div>
    <!-- Import de la police Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Modal pour le formulaire post-appui -->
    @if ($showModal)
    <div class="modal fade show" style="display: block;" tabindex="-1" aria-labelledby="postAppuiModalLabel"
        aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="border-bottom: 1px solid #eee; padding: 20px;">
                    <h5 class="modal-title" id="postAppuiModalLabel" style="font-weight: 600; color: #2c3e50;">Rapport post-appui</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <form wire:submit.prevent="store">
                        <div class="mb-3">
                            <h6 style="color: #009879; font-weight: 600;">{{ $structure }}</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label style="font-size: 0.9em; color: #555;">Nombre d'hommes formés <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('effectif_homme_forme') is-invalid @enderror"
                                        wire:model="effectif_homme_forme" min="0" placeholder="0" style="border-radius: 8px; padding: 10px;">
                                    @error('effectif_homme_forme')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label style="font-size: 0.9em; color: #555;">Nombre de femmes formées <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('effectif_femme_forme') is-invalid @enderror"
                                        wire:model="effectif_femme_forme" min="0" placeholder="0" style="border-radius: 8px; padding: 10px;">
                                    @error('effectif_femme_forme')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: none; padding: 0; margin-top: 20px;">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal" style="border-radius: 8px;">Annuler</button>
                            <button type="submit" class="btn btn-success" style="border-radius: 8px; background-color: #009879; border-color: #009879;">Enregistrer</button>
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
                    <ul class="navbar-nav">
                        <li class="mr-3">
                            @if (Auth::user()->email == 'spea@gmail.com')
                            <h2 style="font-weight: bold; margin:0;">SPEA</h2>
                            @elseif (Auth::user()->email == 'sese@gmail.com')
                            <h2 style="font-weight: bold; margin:0;">SESE</h2>
                            @elseif (Auth::user()->email == 'dg@gmail.com')
                            <h2 style="font-weight: bold; margin:0;">DG</h2>
                            @elseif (Auth::user()->email == 'daf@gmail.com')
                            <h2 style="font-weight: bold; margin:0;">DAF</h2>
                            @elseif (Auth::user()->email == 'do@gmail.com')
                            <h2 style="font-weight: bold; margin:0;">DO</h2>
                            @endif
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="now-ui-icons users_single-02"></i>
                                <p><span class="d-lg-none d-md-block">Actions</span></p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('profile.show') }}">Profil</a>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-weight: bold">
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

        <div style="height: 17vh; background-color: #198754;"></div>

        <div class="content">
            <!-- Cartes de statistiques -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card modern-card h-100">
                        <div class="card-body">
                            <p class="text-muted text-uppercase mb-1" style="font-size: 12px; font-weight: 600;">Structures appuyées</p>
                            <h3 class="mb-0" style="color: #2c3e50; font-weight: 700;">{{ $totalStructures }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card modern-card h-100">
                        <div class="card-body">
                            <p class="text-muted text-uppercase mb-1" style="font-size: 12px; font-weight: 600;">Rapports déposés</p>
                            <h3 class="mb-0" style="color: #009879; font-weight: 700;">{{ $structuresAvecRapport }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card modern-card h-100">
                        <div class="card-body">
                            <p class="text-muted text-uppercase mb-1" style="font-size: 12px; font-weight: 600;">Ratio dépôt de rapport</p>
                            <div class="d-flex align-items-end justify-content-between">
                                <div>
                                    <h3 class="mb-0" style="font-weight: 700;">{{ $structuresAvecRapport }}/{{ $totalStructures }}</h3>
                                    <small class="text-muted" style="font-size: 11px;">Structures ayant déposé / appuyées</small>
                                </div>
                                <span class="badge bg-primary" style="font-size: 14px;">{{ $ratio }}%</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px; border-radius: 3px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $ratio }}%; background-color: #009879 !important;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des demandes -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card modern-card">
                        <div class="card-header">
                            <h4 class="card-title">Suivi des Rapports</h4>
                            <p class="card-category">État des dépôts des rapports post-appui</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="styled-table">
                                    <thead>
                                        <tr>
                                            <th>Structure</th>
                                            <th>Budget demandé</th>
                                            <th>Budget Attribué</th>
                                            <th>Statut Rapport</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($demandes as $demande)
                                        <tr>
                                            <td style="font-weight: 500; color: #333;">{{ $demande->structure }}</td>
                                            <td>{{ number_format($demande->budget, 0, ',', ' ') }} FCFA</td>
                                            <td style="font-weight: bold; color: #009879;">{{ number_format($demande->buget_prevu, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                @if ($demande->rapport_depose)
                                                <span class="status-badge status-success">Rapport déposé</span>
                                                @else
                                                <span class="status-badge status-warning">En attente</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="action-buttons">
                                                    <button wire:click="edit({{ $demande->id }})" class="btn-action btn-edit" title="Déposer/Éditer rapport">
                                                        <i class="now-ui-icons files_paper"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div style="display: flex; flex-direction: column; align-items: center; color: #888;">
                                                    <i class="now-ui-icons files_box" style="font-size: 32px; margin-bottom: 10px;"></i>
                                                    <p style="font-size: 16px;">Aucune demande approuvée</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                {{ $demandes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('Admin.footer')
    </div>

    <style>
        /* Application de la police Poppins Globalement */
        body,
        .main-panel,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        a,
        div,
        table,
        button,
        input,
        label {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Card Moderne */
        .modern-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            background: #fff;
        }

        .card-title {
            font-weight: 600;
            color: #2c3e50;
            font-size: 20px;
        }

        .card-category {
            color: #888;
            font-size: 14px;
        }

        /* Table Moderne */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            min-width: 400px;
            border-radius: 8px 8px 0 0;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.03);
        }

        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }

        .styled-table th,
        .styled-table td {
            padding: 15px 20px;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
            transition: all 0.2s ease;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f8f9fa;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        .styled-table tbody tr:hover {
            background-color: #eafaf6;
            cursor: default;
        }

        /* Badges de Statut */
        .status-badge {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        .status-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .status-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        /* Boutons d'action */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
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

        .btn-edit {
            color: #f39c12;
            border-color: #f39c12;
        }

        .btn-edit:hover {
            background-color: #f39c12;
            color: #fff;
            transform: translateY(-2px);
        }
    </style>
</div>