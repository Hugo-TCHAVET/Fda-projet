<div>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    .font-poppins {
      font-family: 'Poppins', sans-serif;
    }

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
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 5px;
    }

    .card-value {
      font-size: 36px;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 20px;
    }

    .stat-list {
      padding-top: 20px;
      border-top: 1px solid #f0f0f0;
    }

    .stat-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
      font-size: 14px;
    }

    .stat-item:last-child {
      margin-bottom: 0;
    }

    .stat-label {
      color: #6c757d;
      display: flex;
      align-items: center;
    }

    .stat-label i {
      margin-right: 8px;
      font-size: 16px;
    }

    .stat-count {
      font-weight: 600;
      color: #2c3e50;
      background: #f8f9fa;
      padding: 2px 10px;
      border-radius: 20px;
    }
  </style>

  <div class="main-panel" id="main-panel">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute" style="background-color: #198754 !important;">

      <div class="container-fluid">
        <div class="navbar-wrapper">
          <div class="navbar-toggle">
            <button type="button" class="navbar-toggler">
              <span class="navbar-toggler-bar bar1"></span>
              <span class="navbar-toggler-bar bar2"></span>
              <span class="navbar-toggler-bar bar3"></span>
            </button>
          </div>
          <a class="navbar-brand text-white font-poppins" style="font-weight: bold; font-size: 1.2rem;">Tableau de Bord</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
          aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar navbar-kebab"></span>
          <span class="navbar-toggler-bar navbar-kebab"></span>
          <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">

          <ul class="navbar-nav">
            <li class="mr-3 text-white">
              @if (Auth::user()->email == 'spea@apps.fda.bj')
              <h2 class="mb-0" style="font-weight: bold; color: white;">SPEA</h2>
              @elseif (Auth::user()->email == 'secretaire@apps.fda.bj')
              <h2 class="mb-0" style="font-weight: bold; color: white;">SECRETAIRE</h2>
              @elseif (Auth::user()->email == 'sese@apps.fda.bj')
              <h2 class="mb-0" style="font-weight: bold; color: white;">SESE</h2>
              @elseif (Auth::user()->email == 'dg@apps.fda.bj')
              <h2 class="mb-0" style="font-weight: bold; color: white;">DG</h2>
              @elseif (Auth::user()->email == 'daf@apps.fda.bj')
              <h2 class="mb-0" style="font-weight: bold; color: white;">DAF</h2>
              @elseif (Auth::user()->email == 'do@apps.fda.bj')
              <h2 class="mb-0" style="font-weight: bold; color: white;">DO</h2>
              @endif
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" id="navbarDropdownMenuLink" data-toggle="dropdown"
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
    <div style="background-color: #198754 !important; height: 17vh;"></div>

    <div class="content mt-5 font-poppins">
      <div class="row p-4">

        <!-- Cards Montants et Statistiques -->
        <div class="col-lg-4 mb-4">
          <div class="dashboard-card p-4">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h5 class="card-title-custom">Montant total demandé</h5>
                <h2 class="card-value">{{ number_format($montantTotalDemande, 0, ',', ' ') }} </h2>
                <small style="color: #6c757d; font-size: 14px;">FCFA</small>
              </div>
              <div class="card-icon-wrapper" style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); color: #f57c00;">
                <i class='bx bx-money'></i>
              </div>
            </div>
            <div class="stat-list">
              <div class="stat-item">

              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 mb-4">
          <div class="dashboard-card p-4">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h5 class="card-title-custom">Montant total accordé</h5>
                <h2 class="card-value">{{ number_format($montantTotalAppuye, 0, ',', ' ') }} </h2>
                <small style="color: #6c757d; font-size: 14px;">FCFA</small>
              </div>
              <div class="card-icon-wrapper icon-green">
                <i class='bx bx-check-circle'></i>
              </div>
            </div>
            <div class="stat-list">
              <div class="stat-item">

              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 mb-4">
          <div class="dashboard-card p-4">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h5 class="card-title-custom">Total Demandes</h5>
                <h2 class="card-value">{{ $totaldemandes }}</h2>
              </div>
              <div class="card-icon-wrapper icon-blue">
                <i class='bx bx-list-ul'></i>
              </div>
            </div>
            <div class="stat-list">
              <div class="stat-item">
                <span class="stat-label"><i class='bx bx-time-five'></i> En attente</span>
                <span class="stat-count">{{ $totaldemandes - $demandesapprouvees }}</span>
              </div>
              <div class="stat-item">
                <span class="stat-label"><i class='bx bx-check'></i> Approuvées</span>
                <span class="stat-count">{{ $demandesapprouvees }}</span>
              </div>
              <div class="stat-item">
                <span class="stat-label"><i class='bx bx-check'></i> Rejetées</span>
                <span class="stat-count">{{ $demandesrejetees }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Carte Formation -->
        <div class="col-lg-4 mb-4">
          <div class="dashboard-card p-4">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h5 class="card-title-custom">Formation / Renforcement de capacités</h5>
                <h2 class="card-value">{{$nbreformation}}</h2>
              </div>
              <div class="card-icon-wrapper icon-blue">
                <i class='bx bx-book-bookmark'></i>
              </div>
            </div>

            <div class="stat-list">
              <div class="stat-item">
                <span class="stat-label"><i class='bx bx-briefcase-alt-2'></i> Association / Organisation Professionnelle</span>
                <span class="stat-count">{{$proformation}}</span>
              </div>
              <div class="stat-item">
                <span class="stat-label"><i class='bx bx-building-house'></i> Structure Formelle</span>
                <span class="stat-count">{{$strformation}}</span>
              </div>
              <div class="stat-item">
                <span class="stat-label"><i class='bx bx-world'></i> ONG</span>
                <span class="stat-count">{{$ongformation}}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Carte Assistance/Promotion -->
        <div class="col-lg-4 mb-4">
          <div class="dashboard-card p-4">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h5 class="card-title-custom">Activités de Promotion</h5>
                <h2 class="card-value">{{$nbrepromotion}}</h2>
              </div>
              <div class="card-icon-wrapper icon-green">
                <i class='bx bx-line-chart'></i>
              </div>
            </div>

            <div class="stat-list">
              <div class="stat-item">
                <span class="stat-label"><i class='bx bx-briefcase-alt-2'></i> Association / Organisation Professionnelle</span>
                <span class="stat-count">{{$propromotion}}</span>
              </div>
              <div class="stat-item">
                <span class="stat-label"><i class='bx bx-building-house'></i> Structure Formelle</span>
                <span class="stat-count">{{$strpromotion}}</span>
              </div>
              <div class="stat-item">
                <span class="stat-label"><i class='bx bx-world'></i> ONG</span>
                <span class="stat-count">{{$ongpromotion}}</span>
              </div>
            </div>
          </div>
        </div>

        {{-- <!-- Carte Financement (Masquée comme dans l'original mais stylisée si décommentée) -->
        <!-- 
        <div class="col-lg-4 mb-4">
          <div class="dashboard-card p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="card-title-custom">Financement</h5>
                    <h2 class="card-value">{{$nbrefinancier}}</h2>
      </div>
      <div class="card-icon-wrapper" style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); color: #f57c00;">
        <i class='bx bx-coin-stack'></i>
      </div>
    </div>
    <div class="stat-list">
      <div class="stat-item">
        <span class="stat-label"><i class='bx bx-briefcase-alt-2'></i> Professionnel</span>
        <span class="stat-count">{{$profinancier}}</span>
      </div>
      <div class="stat-item">
        <span class="stat-label"><i class='bx bx-building-house'></i> Structure</span>
        <span class="stat-count">{{$strfinancier}}</span>
      </div>
      <div class="stat-item">
        <span class="stat-label"><i class='bx bx-world'></i> ONG</span>
        <span class="stat-count">{{$ongfinancier}}</span>
      </div>
    </div>
  </div>
</div>
-->--}}

</div>

</div>
@include('Admin.footer')
</div>


</div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('bigDashboardChart').getContext("2d");

    var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, '#FFFFFF');

    var gradientFill = ctx.createLinearGradient(0, 200, 0, 50);
    gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
    gradientFill.addColorStop(1, "rgba(255, 255, 255, 0.24)");

    var monthlyData = @json($monthlyData);

    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
        datasets: [{
          label: "Formation",
          borderColor: '#80b6f4',
          pointBorderColor: '#FFF',
          pointBackgroundColor: '#80b6f4',
          pointHoverBackgroundColor: '#80b6f4',
          pointHoverBorderColor: '#80b6f4',
          pointBorderWidth: 2,
          pointHoverRadius: 4,
          pointHoverBorderWidth: 1,
          pointRadius: 4,
          fill: true,
          backgroundColor: gradientFill,
          borderWidth: 2,
          data: monthlyData.formation
        }, {
          label: "Assistance",
          borderColor: '#18ce0f',
          pointBorderColor: '#FFF',
          pointBackgroundColor: '#18ce0f',
          pointHoverBackgroundColor: '#18ce0f',
          pointHoverBorderColor: '#18ce0f',
          pointBorderWidth: 2,
          pointHoverRadius: 4,
          pointHoverBorderWidth: 1,
          pointRadius: 4,
          fill: true,
          backgroundColor: gradientFill,
          borderWidth: 2,
          data: monthlyData.promotion
        }, {
          label: "Financier",
          borderColor: '#f96332',
          pointBorderColor: '#FFF',
          pointBackgroundColor: '#f96332',
          pointHoverBackgroundColor: '#f96332',
          pointHoverBorderColor: '#f96332',
          pointBorderWidth: 2,
          pointHoverRadius: 4,
          pointHoverBorderWidth: 1,
          pointRadius: 4,
          fill: true,
          backgroundColor: gradientFill,
          borderWidth: 2,
          data: monthlyData.financier
        }]
      },
      options: {
        layout: {
          padding: {
            left: 20,
            right: 20,
            top: 0,
            bottom: 0
          }
        },
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: '#fff',
          titleFontColor: '#333',
          bodyFontColor: '#666',
          bodySpacing: 4,
          xPadding: 12,
          mode: "nearest",
          intersect: 0,
          position: "nearest"
        },
        legend: {
          position: "bottom",
          fillStyle: "#FFF",
          display: true
        },
        scales: {
          yAxes: [{
            ticks: {
              fontColor: "rgba(255,255,255,0.4)",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 10
            },
            gridLines: {
              drawTicks: true,
              drawBorder: false,
              display: true,
              color: "rgba(255,255,255,0.1)",
              zeroLineColor: "transparent"
            }

          }],
          xAxes: [{
            gridLines: {
              zeroLineColor: "transparent",
              display: false,

            },
            ticks: {
              padding: 10,
              fontColor: "rgba(255,255,255,0.4)",
              fontStyle: "bold"
            }
          }]
        }
      }
    });
  });
</script>