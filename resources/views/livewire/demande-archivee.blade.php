<div>
    <!-- Import de la police Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">



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
                    <a class="navbar-brand" href="#pablo">Archives des Demandes</a>
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
                            @if (Auth::user()->email == 'spea@apps.fda.bj')
                            <h2 style="font-weight: bold; margin:0;">SPEA</h2>
                            @elseif (Auth::user()->email == 'sese@apps.fda.bj')
                            <h2 style="font-weight: bold; margin:0;">SESE</h2>
                            @elseif (Auth::user()->email == 'dg@apps.fda.bj')
                            <h2 style="font-weight: bold; margin:0;">DG</h2>
                            @elseif (Auth::user()->email == 'daf@apps.fda.bj')
                            <h2 style="font-weight: bold; margin:0;">DAF</h2>
                            @elseif (Auth::user()->email == 'do@apps.fda.bj')
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

        <div style="height: 17vh; background-color: #6c757d;">
        </div>

        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card modern-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title">Archives des Demandes Approuvées</h4>
                                <p class="card-category">Consultation des demandes archivées par année d'exercice</p>
                            </div>
                            <div class="form-group" style="width: 300px;">
                                <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Rechercher une demande...">
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filtre par année -->
                            <div class="mb-4" style="display: flex; align-items: center; gap: 15px;">
                                <label style="font-weight: 500; color: #555;">Filtrer par année :</label>
                                <select wire:model="anneeFiltre" class="form-control"
                                    style="width: 200px; border-radius: 8px; padding: 8px;">
                                    @foreach($anneesDisponibles as $annee)
                                    <option value="{{ $annee }}">{{ $annee }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="table-responsive">
                                <table class="styled-table">
                                    <thead>
                                        <tr>
                                            <th>Structure</th>
                                            <th>Contact</th>
                                            <th>Budget de l'activité</th>
                                            <th>Appui financier accordé</th>
                                            <th>Date d'approbation</th>
                                            <th>Année d'exercice</th>
                                            <th>Date d'archivage</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($demandes as $demande)
                                        <tr>
                                            <td style="font-weight: 500; color: #333;">{{ $demande->structure }}</td>
                                            <td>{{ $demande->contact }}</td>
                                            <td>{{ $demande->budget }} FCFA</td>
                                            <td style="font-weight: bold; color: #009879;">{{ $demande->buget_prevu }} FCFA</td>
                                            <td>
                                                <span style="font-weight: 500; color: #666;">
                                                    {{ $demande->date_approbation ? \Carbon\Carbon::parse($demande->date_approbation)->format('d/m/Y H:i') : 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-info" style="background-color: #6c757d; color: white; padding: 5px 10px; border-radius: 15px;">
                                                    {{ $demande->annee_exercice }}
                                                </span>
                                            </td>
                                            <td>
                                                <span style="font-weight: 500; color: #666;">
                                                    {{ $demande->date_archivage ? \Carbon\Carbon::parse($demande->date_archivage)->format('d/m/Y H:i') : 'N/A' }}
                                                </span>
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
                                                    <p style="font-size: 16px;">Aucune demande archivée pour cette année</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
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
            background-color: #6c757d;
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
            border-bottom: 2px solid #6c757d;
        }

        .styled-table tbody tr:hover {
            background-color: #e9ecef;
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

        /* Suppression des styles Bootstrap/NowUI gênants */
        .table>thead>tr>th {
            font-size: 13px;
            font-weight: 600;
            border-bottom-width: 1px;
        }
    </style>
</div>