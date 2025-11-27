@extends('Commun.Admin')
<base href="{{asset('Admin')}}">
@section('contenu')

<!-- Ajout Boxicons & Fonts -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
  body {
    font-family: 'Poppins', sans-serif;
  }

  .budget-card {
    background: #fff;
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: transform 0.3s ease;
  }

  .budget-card:hover {
    transform: translateY(-5px);
  }

  .card-header-custom {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%);
    padding: 25px;
    color: white;
    text-align: center;
  }

  .card-header-custom i {
    font-size: 40px;
    margin-bottom: 10px;
    opacity: 0.9;
  }

  .card-header-custom h5 {
    margin: 0;
    font-weight: 600;
    font-size: 18px;
    letter-spacing: 0.5px;
  }

  .card-body-custom {
    padding: 40px 30px;
  }

  .info-box-budget {
    background: #f0f9ff;
    border: 1px dashed #0dcaf0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 30px;
    text-align: center;
  }

  .budget-label {
    font-size: 13px;
    text-transform: uppercase;
    color: #6c757d;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 5px;
    display: block;
  }

  .budget-amount {
    font-size: 28px;
    font-weight: 700;
    color: #0d6efd;
  }

  .form-label-custom {
    font-size: 14px;
    font-weight: 500;
    color: #344767;
    margin-bottom: 10px;
    display: block;
  }

  .input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
  }

  .form-control-lg {
    border-color: #dee2e6;
    font-size: 16px;
    padding: 12px 15px;
  }

  .form-control-lg:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.15);
  }

  .btn-submit {
    background: #198754;
    border: none;
    padding: 12px 20px;
    font-weight: 500;
    letter-spacing: 0.5px;
    transition: all 0.3s;
  }

  .btn-submit:hover {
    background: #146c43;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(20, 108, 67, 0.3);
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
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-light rounded-circle me-2" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Retour">
          <i class='bx bx-arrow-back' style="font-size: 18px;"></i>
        </a>
        <a class="navbar-brand" style="font-weight: bold; font-size: 1.2rem;">
          Attribution du Budget
        </a>
      </div>

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
            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="now-ui-icons users_single-02"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
              <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="now-ui-icons media-1_button-power"></i> Deconnecter
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->

  <div style="height: 17vh; background-color: #198754;"></div>

  <div class="content">
    <div class="row d-flex justify-content-center align-items-center" style="min-height: 60vh;">
      <div class="col-md-5">

        <div class="budget-card">
          <div class="card-header-custom">
            <i class='bx bx-wallet'></i>
            <h5>Définir le montant accordé</h5>
            <p class="mb-0 small opacity-75">Veuillez saisir le montant validé pour cette demande</p>
          </div>

          <div class="card-body-custom">

            <!-- Rappel du budget demandé -->
            <div class="info-box-budget">
              <span class="budget-label">Budget Sollicité</span>
              <span class="budget-amount">{{ number_format((float)$demande->budget, 0, ',', ' ') }} <small style="font-size: 14px; color: #6c757d;">CFA</small></span>
            </div>

            <form action="{{route('demande.prixbudget',$demande->id)}}" method="post">
              @csrf

              <div class="form-group mb-4">
                <label class="form-label-custom">Date d'approbation</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                  <input type="date" name="date_approbation" value="{{ date('Y-m-d') }}" class="form-control form-control-lg" required>
                </div>
              </div>

              <div class="form-group mb-4">
                <label class="form-label-custom">Montant Accordé</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text"><i class='bx bx-coin-stack'></i></span>
                  <input type="number" name="buget_prevu" class="form-control form-control-lg" placeholder="Ex: 500000" required min="0" max="{{ $demande->budget }}">
                  <span class="input-group-text">CFA</span>
                </div>
                <div class="d-flex justify-content-between mt-2">
                  <small class="text-muted"><i class='bx bx-info-circle'></i> Max: {{ number_format((float)$demande->budget, 0, ',', ' ') }}</small>
                </div>
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg btn-submit shadow">
                  <i class='bx bx-check-circle me-2'></i> Valider le Budget
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-light btn-lg text-muted">
                  Annuler
                </a>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  @include('Admin.footer')
</div>
@endsection