@extends('Commun.Admin')

@section('contenu')
<style>
    .card-body canvas {
        max-height: 280px !important;
        height: 280px !important;
    }

    .card-body {
        min-height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .col-md-12 .card-body canvas {
        max-height: 250px !important;
        height: 250px !important;
    }

    .col-md-12 .card-body {
        min-height: 320px;
    }

    /* Styles pour l'impression */
    @media print {
        body * {
            visibility: hidden;
        }

        #stats-container,
        #stats-container * {
            visibility: visible;
        }

        #stats-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .navbar,
        .btn,
        #stats-content>.container-fluid>.row:last-child,
        #buttons-row {
            display: none !important;
        }

        .card {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .row {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        h3 {
            page-break-after: avoid;
        }
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
                <a class="navbar-brand" style="font-weight: bold; font-size: 1.2rem;">Statistiques</a>
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

    <div style="height: 17vh; background-color: #198754;"></div>

    <div class="content" id="stats-content">
        <div class="container-fluid" id="stats-container">

            <!-- SECTION 1: DOSSIERS REÇUS -->
            <h3 class="text-primary mt-5">1. Dossiers Reçus</h3>
            <div class="row" id="pdf-row-1">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Répartition par service des dossiers reçus</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g1Chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Répartition par type demandeur des dossiers reçus</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g2Chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="pdf-row-2">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Répartition par branche des dossiers reçus vs approuvés</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g3Chart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="pdf-row-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Effectif des artisans prévus par commune des dossiers reçus</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g12Chart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <!-- SECTION 2: DOSSIERS APPUYÉS -->
            <h3 class="text-success">2. Dossiers Appuyés / Acceptés</h3>

            <div class="row" id="pdf-row-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Répartition par service des dossiers approuvés</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g4Chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Répartition par type demandeur des dossiers approuvés</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g5Chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Ratio des structures ayant déposé leur rapport / structures appuyées</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g15Chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="pdf-row-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"> Effectifs par branche des dossiers approuvés</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g6g9Chart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="pdf-row-6">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Effectif des artisans par service des dossiers approuvés</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g7Chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Effectif des artisans par type demandeur des dossiers approuvés</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g8Chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="pdf-row-7">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Effectif des artisans prévus par commune des dossiers approuvés</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g10Chart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="pdf-row-8">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Montant total des appuis accordés par service des dossiers approuvés</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g14Chart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <!-- SECTION 3: EFFECTIFS PAR DÉPARTEMENT -->
            <!-- <h3 class="text-info">3. Effectifs par Département</h3> -->
            <div class="row" id="pdf-row-9">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Comparatif nombre d'artisans prévus vs artisans touchés par département</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g16Chart" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Répartition des artisans formés par genre et par département</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g17Chart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 mb-5 justify-content-center" id="buttons-row">
                {{-- <div class="col-md-3 text-center">
                    <button class="btn btn-info btn-lg btn-block" onclick="downloadPDF()">
                        <i class="now-ui-icons files_single-copy-04"></i> Télécharger PDF
                    </button>
                </div> --}}
                <div class="col-md-3 text-center">
                    <button class="btn btn-success btn-lg btn-block" onclick="printStats('portrait')">
                        <i class="now-ui-icons files_paper"></i> Imprimer (Portrait)
                    </button>
                </div>
                <div class="col-md-3 text-center">
                    <button class="btn btn-warning btn-lg btn-block" onclick="printStats('landscape')">
                        <i class="now-ui-icons files_paper"></i> Imprimer (Paysage)
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    // Enregistrer le plugin ChartDataLabels
    Chart.register(ChartDataLabels);

    // Fonction Helper pour extraire labels et data
    function getData(collection, labelKey, dataKey) {
        return {
            labels: collection.map(i => i[labelKey]),
            data: collection.map(i => i[dataKey])
        };
    }

    // ============================================
    // SYSTÈME CENTRALISÉ DE PERSONNALISATION DES LABELS
    // ============================================
    // Définissez tous vos mappings personnalisés ici, une seule fois
    const LABEL_MAPPINGS = {
        // Mappings pour les services
        service: {

            'Assistance': 'Activités de Promotion',
            'Formation': 'Formation / Renforcement de capacités',
            // 'SPEA': 'Service de Promotion et d\'Encadrement des Artisans',
            // 'SESE': 'Service d\'Encadrement et de Suivi des Entreprises',
            // 'DG': 'Direction Générale',
        },
        // Mappings pour les types de demandeurs
        type_demande: {
            'professionnel': 'Association / O P Artisans',
            'structure': 'Structures formelles',
            // 'Type1': 'Label Personnalisé Type 1',
            // 'Type2': 'Label Personnalisé Type 2',
        },
        // Mappings pour les branches (nom)
        nom: {
            'Métaux et constructions métalliques/ Mécanique/ Electromécanique/ Electronique/ Electricité et petites activités de transport': 'Métaux et contructions métalliques / M / E / E / E'
            // 'Branche1': 'Label Personnalisé Branche 1',
            // 'Branche2': 'Label Personnalisé Branche 2',
        },
        // Mappings pour les départements 
        departement: {
            // 'ATLANTIQUE': 'Atlantique',
            // 'MONO': 'Mono',
        }
    };

    // Fonction pour obtenir les labels personnalisés automatiquement
    function getDataWithCustomLabels(collection, labelKey, dataKey) {
        const labels = collection.map(i => i[labelKey]);
        const mapping = LABEL_MAPPINGS[labelKey] || {};
        const customLabels = labels.map(label => mapping[label] || label);
        return {
            labels: customLabels,
            originalLabels: labels, // Garder les labels originaux si besoin
            data: collection.map(i => i[dataKey])
        };
    }

    // Couleurs génériques
    const colors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
        '#e74c3c', '#3498db', '#2ecc71', '#9b59b6', '#f1c40f', '#1abc9c'
    ];

    // Configuration centralisée des légendes (taille augmentée et gras)
    const legendConfig = {
        position: 'bottom',
        labels: {
            font: {
                size: 16,
                weight: 'bold',
                family: 'Arial, sans-serif'
            },
            padding: 15,
            usePointStyle: true,
            pointStyle: 'circle'
        }
    };

    // Configuration centralisée des axes (abscisses et ordonnées) - police en gras et taille augmentée
    const axisTicksConfig = {
        font: {
            size: 14,
            weight: 'bold',
            family: 'Arial, sans-serif'
        }
    };

    // G1: Service Reçus (Pie)
    const d1 = getDataWithCustomLabels(@json($g1_service_recus), 'service', 'count');
    new Chart(document.getElementById('g1Chart'), {
        type: 'pie',
        data: {
            labels: d1.labels, // Utilise les labels personnalisés
            datasets: [{
                data: d1.data,
                backgroundColor: colors
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                datalabels: {
                    display: true,
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: (value, ctx) => {
                        return value;
                    },
                    anchor: 'center',
                    align: 'center'
                },
                legend: legendConfig
            }
        }
    });

    // G2: Demandeur Reçus (Doughnut)
    const d2 = getDataWithCustomLabels(@json($g2_demandeur_recus), 'type_demande', 'count');
    new Chart(document.getElementById('g2Chart'), {
        type: 'doughnut',
        data: {
            labels: d2.labels,
            datasets: [{
                data: d2.data,
                backgroundColor: colors
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                datalabels: {
                    display: true,
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: (value, ctx) => {
                        return value;
                    },
                    anchor: 'center',
                    align: 'center'
                },
                legend: legendConfig
            }
        }
    });

    // G3: Branche Reçus vs Approuvés (Bar Grouped)
    const g3Data = @json($g3_branche_recus);
    // Helper pour appliquer les labels personnalisés sans perdre la structure
    const g3Labels = g3Data.map(i => {
        const mapping = LABEL_MAPPINGS['nom'] || {};
        return mapping[i.nom] || i.nom;
    });
    const g3Recus = g3Data.map(i => i.recus);
    const g3Approuves = g3Data.map(i => i.approuves);

    new Chart(document.getElementById('g3Chart'), {
        type: 'bar',
        data: {
            labels: g3Labels,
            datasets: [{
                    label: 'Dossiers Reçus',
                    data: g3Recus,
                    backgroundColor: '#36A2EB'
                },
                {
                    label: 'Dossiers Approuvés',
                    data: g3Approuves,
                    backgroundColor: '#FF9F40'
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            indexAxis: 'x',
            plugins: {
                legend: legendConfig, // Utiliser la config de légende existante
                datalabels: {
                    display: true,
                    color: '#000',
                    font: {
                        weight: 'bold',
                        size: 10
                    },
                    anchor: 'end',
                    align: 'top',
                    formatter: (value) => {
                        return value > 0 ? value : '';
                    }
                }
            },
            scales: {
                x: {
                    ticks: Object.assign({}, axisTicksConfig, {
                        stepSize: 1
                    })
                },
                y: {
                    ticks: {
                        stepSize: 1,
                        font: axisTicksConfig.font
                    },
                    beginAtZero: true
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // G12: Commune Reçus (Bar)
    const d12 = getDataWithCustomLabels(@json($g12_effectif_commune_recus), 'nom', 'effectif');
    new Chart(document.getElementById('g12Chart'), {
        type: 'bar',
        data: {
            labels: d12.labels,
            datasets: [{
                label: 'Effectif Prévu',
                data: d12.data,
                backgroundColor: '#FFCE56'
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    ticks: axisTicksConfig
                },
                y: {
                    ticks: axisTicksConfig
                }
            }
        }
    });

    // G4: Service Approuvés (Pie)
    const d4 = getDataWithCustomLabels(@json($g4_service_approuves), 'service', 'count');
    new Chart(document.getElementById('g4Chart'), {
        type: 'pie',
        data: {
            labels: d4.labels,
            datasets: [{
                data: d4.data,
                backgroundColor: colors
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                datalabels: {
                    display: true,
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: (value, ctx) => {
                        return value;
                    },
                    anchor: 'center',
                    align: 'center'
                },
                legend: legendConfig
            }
        }
    });

    // G5: Demandeur Approuvés (Doughnut)
    const d5 = getDataWithCustomLabels(@json($g5_demandeur_approuves), 'type_demande', 'count');
    new Chart(document.getElementById('g5Chart'), {
        type: 'doughnut',
        data: {
            labels: d5.labels,
            datasets: [{
                data: d5.data,
                backgroundColor: colors
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                datalabels: {
                    display: true,
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: (value, ctx) => {
                        return value;
                    },
                    anchor: 'center',
                    align: 'center'
                },
                legend: legendConfig
            }
        }
    });

    // G6 & G9: Mixte (Dossiers & Effectifs par Branche)
    const d6 = getDataWithCustomLabels(@json($g6_branche_approuves), 'nom', 'count');
    const d9 = getDataWithCustomLabels(@json($g9_effectif_branche_approuves), 'nom', 'effectif');
    new Chart(document.getElementById('g6g9Chart'), {
        type: 'bar',
        data: {
            labels: d6.labels, // Suppose same order
            datasets: [{
                    label: 'Nombre Dossiers',
                    data: d6.data,
                    backgroundColor: '#36A2EB',
                    yAxisID: 'y'
                },
                {
                    label: 'Effectif Artisans',
                    type: 'line',
                    data: d9.data,
                    borderColor: '#FF6384',
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: legendConfig
            },
            scales: {
                x: {
                    ticks: axisTicksConfig
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    ticks: axisTicksConfig
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    ticks: axisTicksConfig,
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });

    // G7: Service Approuvés Effectif (PolarArea)
    const d7 = getDataWithCustomLabels(@json($g7_effectif_service_approuves), 'service', 'effectif');
    new Chart(document.getElementById('g7Chart'), {
        type: 'doughnut',
        data: {
            labels: d7.labels,
            datasets: [{
                data: d7.data,
                backgroundColor: colors
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true
        }
    });

    // G8: Demandeur Approuvés Effectif (Bar)
    const d8 = getDataWithCustomLabels(@json($g8_effectif_demandeur_approuves), 'type_demande', 'effectif');
    new Chart(document.getElementById('g8Chart'), {
        type: 'bar',
        data: {
            labels: d8.labels,
            datasets: [{
                label: 'Effectif',
                data: d8.data,
                backgroundColor: '#4BC0C0'
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    ticks: axisTicksConfig
                },
                y: {
                    ticks: axisTicksConfig
                }
            }
        }
    });

    // G10: Commune Approuvés Effectif (Bar)
    const d10 = getDataWithCustomLabels(@json($g10_effectif_commune_approuves), 'nom', 'effectif');

    new Chart(document.getElementById('g10Chart'), {
        type: 'bar',
        data: {
            labels: d10.labels,
            datasets: [{
                label: 'Effectif',
                data: d10.data,
                backgroundColor: '#9966FF'
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    ticks: axisTicksConfig
                },
                y: {
                    beginAtZero: true,
                    ticks: axisTicksConfig
                }
            }
        }
    });

    // G14: Montant (Bar)
    const d14 = getDataWithCustomLabels(@json($g14_montant_service_approuves), 'service', 'montant');
    new Chart(document.getElementById('g14Chart'), {
        type: 'bar',
        data: {
            labels: d14.labels,
            datasets: [{
                label: 'Budget (FCFA)',
                data: d14.data,
                backgroundColor: '#2ecc71',
                borderColor: '#2ecc71',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    display: true,
                    color: '#333',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: (value) => {
                        return new Intl.NumberFormat('fr-FR').format(value);
                    },
                    anchor: 'end',
                    align: 'top'
                }
            },
            scales: {
                x: {
                    ticks: axisTicksConfig
                },
                y: {
                    ticks: Object.assign({}, axisTicksConfig, {
                        stepSize: 1000000,
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR').format(value);
                        }
                    })
                }
            }
        }
    });

    // G15: Ratio (Doughnut)
    const d15 = @json($g15_ratio_data);
    new Chart(document.getElementById('g15Chart'), {
        type: 'doughnut',
        data: {
            labels: ['Rapports Déposés', 'En attente de dépôt '],
            datasets: [{
                data: [d15.rapports_deposes, d15.rapports_manquants],
                backgroundColor: ['#2ecc71', '#e74c3c']
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                datalabels: {
                    display: true,
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: (value, ctx) => {
                        return value;
                    },
                    anchor: 'center',
                    align: 'center'
                },
                legend: legendConfig,
                title: {
                    display: true,
                    text: 'Taux de retour rapports'
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // G16: Prévu vs Touché par Département (Bar Grouped)
    const g16Data = @json($g16_prevu_vs_touche);
    const g16Labels = g16Data.map(d => d.nom);
    const g16Prevu = g16Data.map(d => parseInt(d.prevu) || 0);
    const g16Touche = g16Data.map(d => parseInt(d.touche) || 0);
    const g16Max = Math.max(...g16Prevu, ...g16Touche) * 1.15; // Ajouter 15% d'espace en haut

    new Chart(document.getElementById('g16Chart'), {
        type: 'bar',
        data: {
            labels: g16Labels,
            datasets: [{
                label: 'Artisans Bénéficiaires prévus',
                data: g16Prevu,
                backgroundColor: '#36A2EB'
            }, {
                label: 'Artisans Bénéficiaires touchés',
                data: g16Touche,
                backgroundColor: '#FF9F40'
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            layout: {
                padding: {
                    top: 30,
                    right: 10,
                    bottom: 10,
                    left: 10
                }
            },
            plugins: {
                legend: legendConfig,
                datalabels: {
                    display: true,
                    color: '#000',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    anchor: 'end',
                    align: 'top',
                    formatter: (value) => {
                        return value !== 0 ? value : '';
                    },
                    padding: {
                        top: 5
                    }
                }
            },
            scales: {
                x: {
                    ticks: axisTicksConfig
                },
                y: {
                    beginAtZero: true,
                    suggestedMax: g16Max,
                    ticks: axisTicksConfig
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // G17: Homme/Femme par Département (Bar Grouped)
    const g17Data = @json($g17_homme_femme);
    const g17Labels = g17Data.map(d => d.nom);
    const g17Homme = g17Data.map(d => parseInt(d.homme) || 0);
    const g17Femme = g17Data.map(d => parseInt(d.femme) || 0);
    const g17Max = Math.max(...g17Homme, ...g17Femme) * 1.15; // Ajouter 15% d'espace en haut

    new Chart(document.getElementById('g17Chart'), {
        type: 'bar',
        data: {
            labels: g17Labels,
            datasets: [{
                label: 'Féminin',
                data: g17Femme,
                backgroundColor: '#2ecc71'
            }, {
                label: 'Masculin',
                data: g17Homme,
                backgroundColor: '#3498db'
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            layout: {
                padding: {
                    top: 30,
                    right: 10,
                    bottom: 10,
                    left: 10
                }
            },
            plugins: {
                legend: legendConfig,
                datalabels: {
                    display: true,
                    color: '#000',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    anchor: 'end',
                    align: 'top',
                    formatter: (value) => {
                        return value !== 0 ? value : '';
                    },
                    padding: {
                        top: 5
                    }
                }
            },
            scales: {
                x: {
                    ticks: axisTicksConfig
                },
                y: {
                    beginAtZero: true,
                    suggestedMax: g17Max,
                    ticks: axisTicksConfig
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Fonction Export PDF Optimisée
    async function downloadPDF() {
        const {
            jsPDF
        } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = pdf.internal.pageSize.getHeight();
        const margin = 10;
        const contentWidth = pdfWidth - (2 * margin);
        const maxContentHeight = pdfHeight - (2 * margin);

        console.log(`📄 Taille PDF: ${pdfWidth}mm × ${pdfHeight}mm`);
        console.log(`📐 Zone de contenu: ${contentWidth}mm × ${maxContentHeight}mm\n`);

        pdf.setFontSize(18);
        pdf.setTextColor(25, 135, 84);
        pdf.text('Tableau de Bord Statistique', pdfWidth / 2, 20, {
            align: 'center'
        });

        pdf.setFontSize(10);
        pdf.setTextColor(100);
        pdf.text(`Généré le ${new Date().toLocaleDateString('fr-FR')}`, pdfWidth / 2, 26, {
            align: 'center'
        });

        let yPosition = 40;

        const sections = [{
                title: '1. Dossiers Reçus',
                type: 'section_title'
            },
            {
                selector: '#pdf-row-1',
                title: 'Répartition par Service et Type (Dossiers Reçus)'
            },
            {
                selector: '#pdf-row-2',
                title: 'Répartition par Branche (Dossiers Reçus)'
            },
            {
                selector: '#pdf-row-3',
                title: 'Effectif par Commune (Dossiers Reçus)'
            },

            {
                title: '2. Dossiers Appuyés / Acceptés',
                type: 'section_title'
            },
            {
                selector: '#pdf-row-4',
                title: 'Répartition par Service, Type et Ratio (Dossiers Approuvés)'
            },
            {
                selector: '#pdf-row-5',
                title: 'Branche - Dossiers & Effectifs (Dossiers Approuvés)'
            },
            {
                selector: '#pdf-row-6',
                title: 'Effectif par Service et Type (Dossiers Approuvés)'
            },
            {
                selector: '#pdf-row-7',
                title: 'Effectif par Commune (Dossiers Approuvés)'
            },
            {
                selector: '#pdf-row-8',
                title: 'Montant Total par Service (Dossiers Approuvés)'
            },

            {
                title: '3. Effectifs par Département',
                type: 'section_title'
            },
            {
                selector: '#pdf-row-9',
                title: 'Effectifs par Département (Prévu vs Touché et Homme vs Femme)'
            }
        ];

        for (const section of sections) {
            if (section.type === 'section_title') {
                const titleHeight = 12;
                if (yPosition + titleHeight + 20 > pdfHeight - margin) {
                    pdf.addPage();
                    yPosition = margin;
                    console.log('📄 Nouvelle page pour titre');
                }
                pdf.setFontSize(14);
                pdf.setFont(undefined, 'bold');
                pdf.setTextColor(25, 135, 84);
                pdf.text(section.title, margin, yPosition);
                yPosition += titleHeight;
                console.log(`✅ TITRE: "${section.title}" | yPos: ${yPosition.toFixed(2)}mm\n`);
                continue;
            }

            const element = document.querySelector(section.selector);
            if (!element) {
                console.warn(`⚠️ Élément "${section.selector}" NON TROUVÉ`);
                continue;
            }

            try {
                console.log(`━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━`);
                console.log(`🎨 CAPTURE: ${section.selector}`);

                await new Promise(resolve => setTimeout(resolve, 150));

                const canvas = await html2canvas(element, {
                    scale: 2,
                    useCORS: true,
                    logging: false,
                    backgroundColor: '#ffffff',
                    windowWidth: 1400,
                    onclone: (clonedDoc) => {
                        const clonedElement = clonedDoc.querySelector(section.selector);
                        if (clonedElement) {
                            clonedElement.style.display = 'block';
                            clonedElement.style.visibility = 'visible';
                        }
                    }
                });

                const imgData = canvas.toDataURL('image/png');
                const imgProps = pdf.getImageProperties(imgData);

                console.log(`📐 Canvas: ${imgProps.width}px × ${imgProps.height}px`);

                let imgWidth = contentWidth;
                let imgHeight = (imgProps.height * imgWidth) / imgProps.width;

                const aspectRatio = imgProps.width / imgProps.height;
                console.log(`📊 Ratio: ${aspectRatio.toFixed(2)} (${aspectRatio > 3 ? 'TRÈS LARGE' : 'Normal'})`);

                if (aspectRatio > 3) {
                    imgWidth = contentWidth * 0.80;
                    imgHeight = (imgProps.height * imgWidth) / imgProps.width;
                    console.log(`⚠️ Réduction largeur à 80%`);
                }

                const maxAllowedHeight = maxContentHeight * 0.60;
                console.log(`📏 Hauteur calculée: ${imgHeight.toFixed(2)}mm | Max: ${maxAllowedHeight.toFixed(2)}mm`);

                if (imgHeight > maxAllowedHeight) {
                    const oldHeight = imgHeight;
                    imgHeight = maxAllowedHeight;
                    imgWidth = (imgProps.width * imgHeight) / imgProps.height;
                    console.log(`⚠️ Compression: ${oldHeight.toFixed(2)}mm → ${imgHeight.toFixed(2)}mm`);
                }

                console.log(`✅ FINALE: ${imgWidth.toFixed(2)}mm × ${imgHeight.toFixed(2)}mm`);

                const titleHeight = 8;
                const bottomMargin = 15;
                const requiredSpace = titleHeight + imgHeight + bottomMargin;
                const availableSpace = pdfHeight - margin - yPosition;

                console.log(`📊 yPosition actuel: ${yPosition.toFixed(2)}mm`);
                console.log(`📊 Espace besoin: ${requiredSpace.toFixed(2)}mm | Disponible: ${availableSpace.toFixed(2)}mm`);

                if (requiredSpace > availableSpace) {
                    pdf.addPage();
                    yPosition = margin;
                    console.log(`📄 ═══ NOUVELLE PAGE ═══ yPos reset à ${margin}mm`);
                }

                pdf.setFontSize(10);
                pdf.setFont(undefined, 'normal');
                pdf.setTextColor(50, 50, 50);

                const titleLines = pdf.splitTextToSize(section.title, contentWidth);
                pdf.text(titleLines, margin, yPosition);
                yPosition += titleHeight;
                console.log(`📝 Titre posé à y=${(yPosition - titleHeight).toFixed(2)}mm`);

                const xOffset = margin + (contentWidth - imgWidth) / 2;
                console.log(`🖼️ Image: x=${xOffset.toFixed(2)}mm, y=${yPosition.toFixed(2)}mm`);

                pdf.addImage(imgData, 'PNG', xOffset, yPosition, imgWidth, imgHeight);

                yPosition += imgHeight + bottomMargin;
                console.log(`✅ yPos APRÈS: ${yPosition.toFixed(2)}mm`);
                console.log(`   Reste: ${(pdfHeight - margin - yPosition).toFixed(2)}mm sur la page\n`);

            } catch (error) {
                console.error(`❌ ERREUR ${section.selector}:`, error);
            }
        }

        const totalPages = pdf.internal.pages.length - 1;
        for (let i = 1; i <= totalPages; i++) {
            pdf.setPage(i);
            pdf.setFontSize(8);
            pdf.setTextColor(150);
            pdf.text(`Page ${i}/${totalPages}`, pdfWidth - 25, pdfHeight - 5);
        }

        console.log(`\n✅ PDF généré: ${totalPages} page(s)`);
        pdf.save('statistiques_fda.pdf');
    }

    // Fonction pour imprimer le bloc de statistiques
    async function printStats(orientation = 'portrait') {
        const statsContainer = document.getElementById('stats-container');
        const printWindow = window.open('', '_blank');

        // Convertir tous les canvas en images
        const canvasElements = statsContainer.querySelectorAll('canvas');
        const canvasImages = [];

        for (let canvas of canvasElements) {
            try {
                const dataURL = canvas.toDataURL('image/png');
                canvasImages.push({
                    id: canvas.id,
                    src: dataURL
                });
            } catch (error) {
                console.error('Erreur lors de la conversion du canvas:', error);
            }
        }

        // Cloner le contenu et remplacer les canvas par des images
        const clonedContent = statsContainer.cloneNode(true);
        const clonedCanvases = clonedContent.querySelectorAll('canvas');

        clonedCanvases.forEach((canvas, index) => {
            if (canvasImages[index]) {
                const img = document.createElement('img');
                img.src = canvasImages[index].src;
                img.style.maxWidth = '100%';
                img.style.height = 'auto';
                img.style.display = 'block';
                img.style.margin = '0 auto';
                canvas.parentNode.replaceChild(img, canvas);
            }
        });

        // Déterminer la taille de page selon l'orientation
        const pageSize = orientation === 'landscape' ? 'A4 landscape' : 'A4';

        // Créer le HTML pour l'impression
        const printHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Statistiques - Impression</title>
                <meta charset="UTF-8">
                <style>
                    @page {
                        size: ${pageSize};
                        margin: 15mm;
                    }
                    body {
                        font-family: Arial, sans-serif;
                        font-size: 12px;
                        color: #000;
                        margin: 0;
                        padding: 20px;
                        background: white;
                    }
                    .card {
                        page-break-inside: avoid;
                        break-inside: avoid;
                        margin-bottom: 20px;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        padding: 15px;
                        background: white;
                    }
                    .card-header {
                        background-color: #f8f9fa;
                        padding: 10px;
                        margin: -15px -15px 15px -15px;
                        border-bottom: 1px solid #ddd;
                    }
                    .card-title {
                        font-size: 14px;
                        font-weight: bold;
                        margin: 0;
                    }
                    .card-body {
                        min-height: auto !important;
                        display: block !important;
                        text-align: center;
                    }
                    .card-body img {
                        max-width: 100% !important;
                        height: auto !important;
                        max-height: 400px !important;
                    }
                    h3 {
                        page-break-after: avoid;
                        margin-top: 30px;
                        margin-bottom: 20px;
                        font-size: 18px;
                        font-weight: bold;
                    }
                    .row {
                        page-break-inside: avoid;
                        break-inside: avoid;
                    }
                    hr {
                        page-break-after: always;
                        border: none;
                        border-top: 2px solid #ccc;
                        margin: 30px 0;
                    }
                    @media print {
                        body {
                            background: white;
                        }
                        .card {
                            page-break-inside: avoid;
                            break-inside: avoid;
                        }
                        h3 {
                            page-break-after: avoid;
                        }
                        .row {
                            page-break-inside: avoid;
                        }
                        .btn,
                        button {
                            display: none !important;
                        }
                    }
                </style>
            </head>
            <body>
                <h1 style="text-align: center; color: #198754; margin-bottom: 10px;">Tableau de Bord Statistique</h1>
                <p style="text-align: center; color: #666; margin-bottom: 30px;">Généré le ${new Date().toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</p>
                ${clonedContent.innerHTML}
            </body>
            </html>
        `;

        // Écrire le contenu dans la nouvelle fenêtre
        printWindow.document.write(printHTML);
        printWindow.document.close();

        // Attendre que les images soient chargées avant d'imprimer
        printWindow.onload = function() {
            setTimeout(function() {
                printWindow.print();
            }, 1000);
        };
    }
</script>
@endsection