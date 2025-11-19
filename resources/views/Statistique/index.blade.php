@extends('Commun.Admin')

@section('contenu')
<div class="content" id="main-panel">
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
                <a class="navbar-brand" href="#pablo">Statistiques</a>
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
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">

        <div class="row p-4">
            @livewire('service', ['data' => $serviceData])
        </div>

        <div class="row p-4">
            @livewire('sexe', ['data' => $sexeData])
        </div>

        <div class="row p-4">
            <div class="row p-4">
                @livewire('departement', ['data' => $departementData])
            </div>
            <div class="row p-4">
                @livewire('demandeur', ['data' => $demandeurData])
            </div>
        </div>
        <div class="row p-4">
            <div class="row p-4">
                @livewire('effectifs-par-branche', ['data' => $effectifsParBranche])
            </div>
        </div>
    </div>
</div>
@endsection