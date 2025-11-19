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