<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    FDA
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
    name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="Admin/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="Admin/assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="Admin/assets/demo/demo.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  @livewireStyles

  <style>
    .step {
      display: none;
    }

    .step.active {
      display: block;
    }

    .sidebar[data-color="#198754"]:after,
    .off-canvas-sidebar[data-color="#198754"]:after {
      background: #198754;
    }

    .sidebar[data-color="#198754"] .nav li.active>a:not([data-toggle="collapse"]),
    .off-canvas-sidebar[data-color="#198754"] .nav li.active>a:not([data-toggle="collapse"]) {
      color: #198754;
    }

    .sidebar[data-color="#198754"] .nav li.active>a:not([data-toggle="collapse"]) i,
    .off-canvas-sidebar[data-color="#198754"] .nav li.active>a:not([data-toggle="collapse"]) i {
      color: #198754;
    }
  </style>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="#198754">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="{{ route('home') }}" class="simple-text logo-mini">

        </a>
        <a href="{{ route('home') }}" class="simple-text logo-normal">
          <p style="font-size: 40px;font-weight: bold">FDA</p>
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}">
              <i class="now-ui-icons design_app"></i>
              <p>Tableau de Bord</p>
            </a>
          </li>

          @can('view-liste-demandes')
          <li class="{{ request()->routeIs('liste.demande') ? 'active' : '' }}">
            <a href="{{ route('liste.demande') }}">
              <i class="now-ui-icons education_atom"></i>
              <p>Liste des demandes</p>
            </a>
          </li>
          @endcan

          @can('view-demandes-verifiees')
          <li class="{{ request()->routeIs('demande.verifier') ? 'active' : '' }}">
            <a href="{{ route('demande.verifier') }}">
              <i class="now-ui-icons location_map-big"></i>
              <p>Demande analysée</p>
            </a>
          </li>
          @endcan

          @can('view-demandes-approuvees')
          <li class="{{ request()->routeIs('demande.approve') ? 'active' : '' }}">
            <a href="{{ route('demande.approve') }}">
              <i class="now-ui-icons ui-1_bell-53"></i>
              <p>Demande approuvée</p>
            </a>
          </li>
          @endcan

          @can('view-demandes-suspendues')
          <li class="{{ request()->routeIs('demande.suspendu') ? 'active' : '' }}">
            <a href="{{ route('demande.suspendu') }}">
              <i class="now-ui-icons location_map-big"></i>
              <p>Demande rejetée</p>
            </a>
          </li>
          @endcan

          @can('view-suivi-demandes')
          <li class="{{ request()->routeIs('suivi.demandes') ? 'active' : '' }}">
            <a href="{{ route('suivi.demandes') }}">
              <i class="now-ui-icons ui-1_zoom-bold"></i>
              <p>Suivi des demandes</p>
            </a>
          </li>
          @endcan

          @can('view-statistiques')
          <li class="{{ request()->routeIs('statistiques.admin') ? 'active' : '' }}">
            <a href="{{ route('statistiques.admin') }}">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Statistiques</p>
            </a>
          </li>
          @endcan

          @can('view-post-appui')
          <li class="{{ request()->routeIs('post-appui') ? 'active' : '' }}">
            <a href="{{ route('post-appui') }}">
              <i class="now-ui-icons business_money-coins"></i>
              <p>Post appui</p>
            </a>
          </li>
          @endcan

          @can('view-dossiers-clotures')
          {{-- <li class="{{ request()->routeIs('demande.archivee') ? 'active' : '' }}">
          <a href="{{ route('demande.archivee') }}">
            <i class="now-ui-icons files_box"></i>
            <p>Dossiers d'appui archivés</p>
          </a>
          </li> --}}
          <li class="{{request()->routeIs('exercices.clotures') ? 'active' : '' }}">
            <a href="{{route('exercices.clotures')}}">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Dossiers d'appui cloturés</p>
            </a>
          </li>
          @endcan
          @can('view-formulaire')
          <li class="{{request()->routeIs('client.formulaire') ? 'active' : '' }}">
            <a href="{{route('client.formulaire')}}">
              <i class="now-ui-icons education_atom"></i>
              <p>Nouvelle demande</p>
            </a>
          </li>
          @endcan
        </ul>
      </div>

    </div>
    @include('sweetalert::alert')

    @yield('contenu')

  </div>
  <!-- Exemple avec CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!--   Core JS Files   -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
  <script src="Admin/assets/js/core/jquery.min.js"></script>
  <script src="Admin/assets/js/core/popper.min.js"></script>
  <script src="Admin/assets/js/core/bootstrap.min.js"></script>
  <script src="Admin/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="Admin/assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="Admin/assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="Admin/assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="Admin/assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

    });
  </script>

  <script>
    $(document).ready(function() {
      // Initialisation
      var currentStep = 1;

      // Fonction pour afficher la prochaine étape
      function showNextStep() {
        $('#step' + currentStep).removeClass('active');
        currentStep++;
        $('#step' + currentStep).addClass('active');
      }

      // Fonction pour afficher l'étape précédente
      function showPrevStep() {
        $('#step' + currentStep).removeClass('active');
        currentStep--;
        $('#step' + currentStep).addClass('active');
      }

      // Écouteurs d'événements pour les boutons "Suivant" et "Précédent"
      $('.next-step').click(function() {
        showNextStep();
      });

      $('.prev-step').click(function() {
        showPrevStep();
      });
    });
  </script>

  @livewireScripts
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <x-livewire-alert::scripts />

</body>

</html>