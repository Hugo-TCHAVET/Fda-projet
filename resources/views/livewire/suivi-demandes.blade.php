<div>
    <!-- Import de la police Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @include('livewire.modal')

    <div class="main-panel" id="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
                    <a class="navbar-brand" style="font-weight: bold; font-size: 1.2rem;">Suivi global des demandes d'appui</a>
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
                                <p></p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('profile.show') }}">Profil</a>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    style="font-weight: bold">
                                    <i class="now-ui-icons media-1_button-power"></i> Déconnexion
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

        <div style="height: 17vh; background-color: #198754;">
        </div>

        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card modern-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title">Suivi des demandes d'appui</h4>
                                <p class="card-category">Vérifiées, approuvées et avec rapports</p>
                            </div>
                            <div class="form-group" style="width: 300px;">
                                <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Rechercher une demande...">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="styled-table">
                                    <thead>
                                        <tr>
                                            <th>Structure</th>
                                            <th>Budget de l'activité</th>
                                            <th>Budget alloué</th>
                                            <th>Date d'approbation</th>
                                            <th>Date dépôt rapport</th>
                                            <th>État</th>
                                            <th>Rapport</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($demandes as $demande)
                                        <tr>
                                            <td style="font-weight: 500; color: #333;">
                                                {{ $demande->structure }}<br>
                                                <small style="color: #888;">{{ $demande->nom }} {{ $demande->prenom }}</small>
                                            </td>

                                            <td>
                                                {{ number_format((float)$demande->budget, 0, ',', ' ') }} FCFA
                                            </td>
                                            <td style="font-weight: bold; color: #009879;">
                                                @if($demande->buget_prevu)
                                                {{ number_format((float)$demande->buget_prevu, 0, ',', ' ') }} FCFA
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span style="font-weight: 500; color: #666;">
                                                    @if($demande->date_approbation)
                                                    {{ \Carbon\Carbon::parse($demande->date_approbation)->format('d/m/Y') }}
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <span style="font-weight: 500; color: #666;">
                                                    @if($demande->date_depot_rapport)
                                                    {{ \Carbon\Carbon::parse($demande->date_depot_rapport)->format('d/m/Y') }}
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                @if($demande->valide == 2 || $demande->statuts == 'Approuvé')
                                                <span class="status-badge status-approved">Approuvé</span>
                                                @elseif($demande->suspendre == 1)
                                                <span class="status-badge badge-danger">Rejété</span>
                                                @elseif($demande->valide == 1 && $demande->suspendre == 0)
                                                <span class="status-badge badge-info">En cours</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($demande->rapport_depose)
                                                <span class="badge bg-success"><i class="now-ui-icons ui-1_check"></i> Reçu</span>
                                                @else
                                                <span class="badge bg-light text-dark">Non reçu</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="action-buttons">
                                                    <a href="{{ route('demande.show', $demande->id) }}"
                                                        class="btn-action btn-view" title="Visualiser">
                                                        <i class="now-ui-icons gestures_tap-01"></i>
                                                    </a>

                                                    <a href="{{ route('demande.pdf', $demande->id) }}"
                                                        class="btn-action btn-pdf" title="Imprimer en PDF">
                                                        <i class="now-ui-icons files_paper"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div style="display: flex; flex-direction: column; align-items: center; color: #888;">
                                                    <i class="now-ui-icons files_box" style="font-size: 32px; margin-bottom: 10px;"></i>
                                                    <p style="font-size: 16px;">Aucune demande trouvée</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination moderne -->
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
        table {
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

        /* Table Moderne Style Datatable */
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

        .status-approved {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        /* .status-verified {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        } */

        .status-other {
            background-color: #cfe2ff;
            color: #084298;
            border: 1px solid #b6d4fe;
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
        }

        .btn-view {
            background-color: #fff;
            color: #009879;
            border: 1px solid #009879;
        }

        .btn-view:hover {
            background-color: #009879;
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-pdf {
            background-color: #fff;
            color: #e74c3c;
            border: 1px solid #e74c3c;
        }

        .btn-pdf:hover {
            background-color: #e74c3c;
            color: #fff;
            transform: translateY(-2px);
        }
    </style>
</div>