<div>

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
          <a class="navbar-brand" href="#pablo">Tableau de Bord</a>
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
    <div class="panel-header panel-header-sm"></div>
    <!-- <div class="content">
      <canvas id="bigDashboardChart"></canvas>
    </div> -->
    <div class="content mt-5">
      <div class="row p-4 ">
        <div class="col-lg-4">
          <div class="card card-chart ">
            <div class="card-header">
              <h1 class="card-category"></h1>
              <h4 class="card-title">Total demandes de formation</h4>
              <div class="dropdown">

                <i class="now-ui-icons education_agenda-bookmark text-primary" style="font-size: 390%"></i>


              </div>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <div class="chart-area ml-4">
                  <h1>{{$nbreformation}} </h1>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                <div class="stats">
                  <p style="font-weight: bold">Professionnel : {{$proformation}} </p>
                  <p style="font-weight: bold">Structure : {{$strformation}} </p>
                  <p style="font-weight: bold">ONG : {{$ongformation}} </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"></h5>
              <h4 class="card-title">Total demandes de promotion</h4>
              <div class="dropdown">

                <i class="now-ui-icons education_paper text-success" style="font-size: 390%"></i>


              </div>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <div class="chart-area ml-4">
                  <h1>{{$nbrepromotion}} </h1>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                <p style="font-weight: bold">Professionnel : {{$propromotion}} </p>
                <p style="font-weight: bold">Structure : {{$strpromotion}} </p>
                <p style="font-weight: bold">ONG : {{$ongpromotion}} </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 ">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"></h5>
              <h4 class="card-title">Total demandes de Financement</h4>
              <div class="dropdown">

                <i class="now-ui-icons business_money-coins text-warning" style="font-size: 390%"></i>


              </div>
            </div>
            <div class="card-body">
              <div class="chart-area ml-4">
                <h1>{{$nbrefinancier}} </h1>
              </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                <div class="stats">
                  <p style="font-weight: bold">Professionnel : {{$profinancier}} </p>
                  <p style="font-weight: bold">Structure : {{$strfinancier}} </p>
                  <p style="font-weight: bold">ONG : {{$ongfinancier}} </p>
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