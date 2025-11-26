@extends('Commun.Admin')
<base href="{{asset('Admin')}}">
@section('contenu')

<div class="main-panel" id="main-panel">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <a class="navbar-brand" href="#pablo" style="font-weight: bold">Rejet de la demande </a>
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
              <p>

              </p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
              <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();" style="font-weight: bold">
                <i class="now-ui-icons media-1_button-power"></i>Deconnecter



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
    <div class="row d-flex justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">

          </div>
          <div class="card-body">
            <form action="{{route('demande.suspendre',$demande->id)}}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12 pr-1">
                  <div class="form-group">
                    <label style="font-weight: bold">Motif de rejet (facultatif)</label>
                    <textarea name="message" class="form-control" id="" cols="30" rows="10"></textarea>

                  </div>
                </div>

              </div>
              <div>
                <button type="submit"
                  class="d-flex btn btn-primary justify-items-end">Rejeter la demande</button>
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
  @include('Admin.footer')
</div>
</div>


@endsection