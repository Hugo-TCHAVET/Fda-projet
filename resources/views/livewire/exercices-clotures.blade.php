<div>
    <!-- Import de la police Poppins et Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
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
                    <a class="navbar-brand" style="font-weight: bold; font-size: 1.2rem;">Exercices Clôturés</a>
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

        <div style="height: 17vh; background-image: linear-gradient(135deg, #198754 0%, #6c757d 100%);">
        </div>

        <div class="content mt-5 font-poppins">
            <!-- Cartes Statistiques -->
            <div class="row p-4">
                <!-- Card Montant Total Demandé -->
                <div class="col-lg-4 mb-4">
                    <div class="dashboard-card p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title-custom">Montant total demandé</h5>
                                <h2 class="card-value">{{ number_format($montantTotalDemande, 0, ',', ' ') }}</h2>
                                <small style="color: #6c757d; font-size: 14px;">FCFA</small>
                            </div>
                            <div class="card-icon-wrapper" style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); color: #f57c00;">
                                <i class='bx bx-money'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Montant Total Appuyé -->
                <div class="col-lg-4 mb-4">
                    <div class="dashboard-card p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title-custom">Montant total accordé</h5>
                                <h2 class="card-value">{{ number_format($montantTotalAppuye, 0, ',', ' ') }}</h2>
                                <small style="color: #6c757d; font-size: 14px;">FCFA</small>
                            </div>
                            <div class="card-icon-wrapper icon-green">
                                <i class='bx bx-check-circle'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Total Demandes -->
                <div class="col-lg-4 mb-4">
                    <div class="dashboard-card p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title-custom">Total Demandes</h5>
                                <h2 class="card-value">{{ $totalDemandes }}</h2>
                            </div>
                            <div class="card-icon-wrapper icon-blue">
                                <i class='bx bx-list-ul'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Formation -->
                <div class="col-lg-4 mb-4">
                    <div class="dashboard-card p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title-custom">Formation / Renforcement de capacités</h5>
                                <h2 class="card-value">{{ $nbreformation }}</h2>
                            </div>
                            <div class="card-icon-wrapper icon-blue">
                                <i class='bx bx-book-bookmark'></i>
                            </div>
                        </div>
                        <div class="stat-list">
                            <div class="stat-item">
                                <span class="stat-label"><i class='bx bx-briefcase-alt-2'></i> Association / Organisation Professionnelle</span>
                                <span class="stat-count">{{ $proformation }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label"><i class='bx bx-building-house'></i> Structure Formelle</span>
                                <span class="stat-count">{{ $strformation }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label"><i class='bx bx-world'></i> ONG</span>
                                <span class="stat-count">{{ $ongformation }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Assistance & Promotion -->
                <div class="col-lg-4 mb-4">
                    <div class="dashboard-card p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title-custom">Activités de Promotion</h5>
                                <h2 class="card-value">{{ $nbrepromotion }}</h2>
                            </div>
                            <div class="card-icon-wrapper icon-green">
                                <i class='bx bx-line-chart'></i>
                            </div>
                        </div>
                        <div class="stat-list">
                            <div class="stat-item">
                                <span class="stat-label"><i class='bx bx-briefcase-alt-2'></i> Association / Organisation Professionnelle</span>
                                <span class="stat-count">{{ $propromotion }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label"><i class='bx bx-building-house'></i> Structure Formelle</span>
                                <span class="stat-count">{{ $strpromotion }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label"><i class='bx bx-world'></i> ONG</span>
                                <span class="stat-count">{{ $ongpromotion }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des demandes clôturées -->
            <div class="row p-4">
                <div class="col-md-12">
                    <div class="card modern-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title">Demandes Clôturées @if($anneeFiltre) - Exercice {{ $anneeFiltre }} @endif</h4>
                                <p class="card-category">Consultation des demandes clôturées par année d'exercice</p>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <div class="form-group" style="width: 300px; margin: 0;">
                                    <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Rechercher une demande...">
                                </div>
                                <button wire:click="exportExcel" class="btn btn-success" style="border-radius: 8px; padding: 8px 20px; white-space: nowrap;">
                                    <i class="now-ui-icons files_single-copy-04" style="margin-right: 5px;"></i>
                                    Exporter en Excel
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filtre par année -->
                            @if(!empty($anneesDisponibles))
                            <div class="mb-4" style="display: flex; align-items: center; gap: 15px;">
                                <label style="font-weight: 500; color: #555;">Filtrer par année :</label>
                                <select wire:model="anneeFiltre" class="form-control"
                                    style="width: 200px; border-radius: 8px; padding: 8px;">
                                    @foreach($anneesDisponibles as $annee)
                                    <option value="{{ $annee }}">{{ $annee }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                            <div class="alert alert-info mb-4" style="border-radius: 8px;">
                                <i class="now-ui-icons ui-1_info"></i>
                                Aucun exercice clôturé pour le moment.
                            </div>
                            @endif

                            <div class="table-responsive">
                                <table class="styled-table">
                                    <thead>
                                        <tr>
                                            <th>Structure</th>
                                            <th>Nom et Prénom</th>
                                            <th>Budget de l'activité</th>
                                            <th>Appui financier accordé</th>
                                            <th>Date d'approbation</th>
                                            <th>Date de clôture</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($demandes as $demande)
                                        <tr>
                                            <td style="font-weight: 500; color: #333;">{{ $demande->structure }}</td>
                                            <td>{{ $demande->nom }} {{ $demande->prenom }}</td>
                                            <td>{{ number_format((float)($demande->budget ?? 0), 0, ',', ' ') }} FCFA</td>
                                            <td style="font-weight: bold; color: #dc3545;">
                                                {{ number_format((float)($demande->buget_prevu ?? 0), 0, ',', ' ') }} FCFA
                                            </td>
                                            <td>
                                                <span style="font-weight: 500; color: #666;">
                                                    {{ $demande->date_approbation ? \Carbon\Carbon::parse($demande->date_approbation)->format('d/m/Y H:i') : 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span style="font-weight: 500; color: #dc3545;">
                                                    {{ $demande->date_cloture ? \Carbon\Carbon::parse($demande->date_cloture)->format('d/m/Y H:i') : 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-buttons">
                                                    <a href="{{ route('demande.cloture.show', $demande->id) }}"
                                                        class="btn-action btn-view" title="Visualiser">
                                                        <i class="now-ui-icons gestures_tap-01"></i>
                                                    </a>
                                                    <a href="{{ route('demande.cloture.pdf', $demande->id) }}"
                                                        class="btn-action btn-pdf" title="Imprimer en PDF">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                            <polyline points="14 2 14 8 20 8"></polyline>
                                                            <line x1="12" y1="18" x2="12" y2="12"></line>
                                                            <polyline points="9 15 12 18 15 15"></polyline>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div style="display: flex; flex-direction: column; align-items: center; color: #888;">
                                                    <i class="now-ui-icons files_box" style="font-size: 32px; margin-bottom: 10px;"></i>
                                                    <p style="font-size: 16px;">Aucune demande clôturée pour cette année</p>
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

        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            border: none;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .card-icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .icon-blue {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            color: #1976d2;
        }

        .icon-green {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            color: #388e3c;
        }

        .card-title-custom {
            font-size: 16px;
            font-weight: 500;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .card-value {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .stat-list {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
        }

        .stat-label {
            font-size: 14px;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stat-label i {
            font-size: 16px;
        }

        .stat-count {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
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
            background-color: #dc3545;
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
            border-bottom: 2px solid #dc3545;
        }

        .styled-table tbody tr:hover {
            background-color: #ffeaea;
            cursor: default;
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