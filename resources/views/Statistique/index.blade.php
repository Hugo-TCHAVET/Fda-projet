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
                <a class="navbar-brand" href="#pablo">Tableau de Bord Statistique</a>
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
        <div class="container-fluid">

            <!-- SECTION 1: DOSSIERS REÇUS -->
            <h3 class="text-primary mt-5">1. Dossiers Reçus</h3>
            <div class="row">
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Répartition par branche des dossiers reçus</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g3Chart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
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

            <div class="row">
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Répartition et effectifs par branche des dossiers approuvés</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="g6g9Chart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
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

            <div class="row">
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

            <div class="row">
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

            <div class="row mt-4 mb-5 justify-content-center">
                <div class="col-md-4 text-center">
                    <button class="btn btn-info btn-lg btn-block" onclick="downloadPDF()">
                        <i class="now-ui-icons files_single-copy-04"></i> Télécharger
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

    // Couleurs génériques
    const colors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
        '#e74c3c', '#3498db', '#2ecc71', '#9b59b6', '#f1c40f', '#1abc9c'
    ];

    // G1: Service Reçus (Pie)
    const d1 = getData(@json($g1_service_recus), 'service', 'count');
    new Chart(document.getElementById('g1Chart'), {
        type: 'pie',
        data: {
            labels: d1.labels,
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
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // G2: Demandeur Reçus (Doughnut)
    const d2 = getData(@json($g2_demandeur_recus), 'type_demande', 'count');
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
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // G3: Branche Reçus (Bar Horizontal)
    const d3 = getData(@json($g3_branche_recus), 'nom', 'count');
    new Chart(document.getElementById('g3Chart'), {
        type: 'bar',
        data: {
            labels: d3.labels,
            datasets: [{
                label: 'Dossiers',
                data: d3.data,
                backgroundColor: '#36A2EB'
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            indexAxis: 'x',
            scales: {
                x: {
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // G12: Commune Reçus (Bar)
    const d12 = getData(@json($g12_effectif_commune_recus), 'nom', 'effectif');
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
            responsive: true
        }
    });

    // G4: Service Approuvés (Pie)
    const d4 = getData(@json($g4_service_approuves), 'service', 'count');
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
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // G5: Demandeur Approuvés (Doughnut)
    const d5 = getData(@json($g5_demandeur_approuves), 'type_demande', 'count');
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
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // G6 & G9: Mixte (Dossiers & Effectifs par Branche)
    const d6 = getData(@json($g6_branche_approuves), 'nom', 'count');
    const d9 = getData(@json($g9_effectif_branche_approuves), 'nom', 'effectif');
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
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left'
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });

    // G7: Service Approuvés Effectif (PolarArea)
    const d7 = getData(@json($g7_effectif_service_approuves), 'service', 'effectif');
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
    const d8 = getData(@json($g8_effectif_demandeur_approuves), 'type_demande', 'effectif');
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
            responsive: true
        }
    });

    // G10: Commune Approuvés Effectif (Bar)
    const d10 = getData(@json($g10_effectif_commune_approuves), 'nom', 'effectif');

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
            scales: {
                y: {
                    beginAtZero: true, // Assure que l'axe commence à 0
                    max: 500, // Force l'échelle à 100
                    ticks: {
                        stepSize: 10
                    }
                }
            }
        }
    });

    // G14: Montant (Bar)
    const d14 = getData(@json($g14_montant_service_approuves), 'service', 'montant');
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
            scales: {
                y: {
                    ticks: {
                        stepSize: 1000000
                    }
                }
            }
        }
    });

    // G15: Ratio (Doughnut)
    const d15 = @json($g15_ratio_data);
    new Chart(document.getElementById('g15Chart'), {
        type: 'doughnut',
        data: {
            labels: ['Rapports Déposés', 'En Attente'],
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
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Taux de retour rapports'
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Fonction Export PDF
    async function downloadPDF() {
        const {
            jsPDF
        } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = pdf.internal.pageSize.getHeight();
        const margin = 10;
        const contentWidth = pdfWidth - (2 * margin);

        pdf.setFontSize(18);
        pdf.setTextColor(25, 135, 84);
        pdf.text('Graphiques statistiques FDA', margin, 20);

        pdf.setFontSize(10);
        pdf.setTextColor(100);
        pdf.text(`Généré le ${new Date().toLocaleDateString('fr-FR')}`, margin, 28);

        let yPosition = 40;

        const sections = [{
                title: 'Total Artisans Reçus',
                selector: '.card-stats',
                isHTML: true
            },
            {
                title: 'Répartition par Service pour les dossiers reçus)',
                selector: '#g1Chart',
                isHTML: false
            },
            {
                title: 'Répartition par Type pour les dossiers reçus)',
                selector: '#g2Chart',
                isHTML: false
            },
            {
                title: 'Répartition par Branche pour les dossiers reçus)',
                selector: '#g3Chart',
                isHTML: false
            },
            {
                title: 'Effectif par Commune pour les dossiers reçus)',
                selector: '#g12Chart',
                isHTML: false
            },
            {
                title: 'Répartition par Service pour les dossiers approuvés)',
                selector: '#g4Chart',
                isHTML: false
            },
            {
                title: 'Répartition par Type pour les dossiers approuvés)',
                selector: '#g5Chart',
                isHTML: false
            },
            {
                title: 'Ratio Rapports Déposés pour les dossiers approuvés)',
                selector: '#g15Chart',
                isHTML: false
            },
            {
                title: 'Branche - Dossiers & Effectifs pour les dossiers approuvés)',
                selector: '#g6g9Chart',
                isHTML: false
            },
            {
                title: 'Effectif par Service pour les dossiers approuvés)',
                selector: '#g7Chart',
                isHTML: false
            },
            {
                title: 'Effectif par Type pour les dossiers approuvés)',
                selector: '#g8Chart',
                isHTML: false
            },
            {
                title: 'Effectif par Commune pour les dossiers approuvés)',
                selector: '#g10Chart',
                isHTML: false
            },
            {
                title: 'Montant Total par Service pour les dossiers approuvés)',
                selector: '#g14Chart',
                isHTML: false
            }
        ];

        for (const section of sections) {
            const element = document.querySelector(section.selector);
            if (!element) continue;

            let imgData;
            let imgWidth, imgHeight;

            if (section.isHTML) {
                const canvas = await html2canvas(element, {
                    scale: 1.2,
                    logging: false,
                    backgroundColor: '#ffffff'
                });
                imgData = canvas.toDataURL('image/jpeg', 0.85);
                imgWidth = contentWidth;
                imgHeight = (canvas.height * imgWidth) / canvas.width;
            } else {
                imgData = element.toDataURL('image/png', 1.0);
                imgWidth = contentWidth;
                const chartAspect = element.height / element.width;
                imgHeight = imgWidth * chartAspect;
            }

            if (yPosition + imgHeight + 15 > pdfHeight - margin) {
                pdf.addPage();
                yPosition = margin;
            }

            pdf.setFontSize(12);
            pdf.setTextColor(0, 0, 0);
            pdf.text(section.title, margin, yPosition);
            yPosition += 8;

            pdf.addImage(imgData, section.isHTML ? 'JPEG' : 'PNG', margin, yPosition, imgWidth, imgHeight);
            yPosition += imgHeight + 15;
        }

        const totalPages = pdf.internal.pages.length - 1;
        for (let i = 1; i <= totalPages; i++) {
            pdf.setPage(i);
            pdf.setFontSize(8);
            pdf.setTextColor(150);
            pdf.text(`Page ${i} / ${totalPages}`, pdfWidth - 30, pdfHeight - 5);
        }

        pdf.save('statistiques_fda.pdf');
    }
</script>
@endsection