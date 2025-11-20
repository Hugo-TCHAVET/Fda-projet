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
                <a class="navbar-brand" href="#pablo" style="font-weight: bold">Détail de la demande </a>
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
                                <span class="d-lg-none d-md-block">Some Actions</span>
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
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <form>
                            <div id="step1" class="step active">
                                <div class="card-header">
                                    <h5 class="title">Information Générale</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Structure du Demandeur</label>
                                            <input type="text" class="form-control" disabled="" placeholder=""
                                                value="{{$demande->structure}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Service</label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{$demande->service}}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" style="font-weight: bold">Type de Demande
                                            </label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{$demande->type_demande}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Branche</label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{ $branche ? $branche->nom : 'pas de branche' }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Corps du Métier</label>
                                            <input type="text" class="form-control" disabled="" value="{{ $corps ? $corps->nom : 'pas de corps' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Métier</label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{ $metier ? $metier->nom : 'pas de métier' }}">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button type="button"
                                        class="d-flex btn btn-primary next-step justify-items-end">Suivant</button>
                                </div>

                            </div>

                            <div id="step2" class="step">
                                <div class="card-header">
                                    <h5 class="title">Information Personelle</h5>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Nom du demandeur</label>
                                            <input type="text" class="form-control" disabled="" placeholder=""
                                                value="{{$demande->nom}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Prenoms du demandeur</label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{$demande->prenom}}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Ifu</label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{$demande->ifu}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Contact</label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{$demande->contact}}">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                                    <button type="button" class="btn btn-primary next-step">Suivant</button>
                                </div>

                            </div>
                            <div id="step3" class="step">
                                <div class="card-header">
                                    <h5 class="title">Information sur le projet</h5>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Titre de l'activité</label>
                                            <input type="text" class="form-control" disabled="" placeholder=""
                                                value="{{$demande->titre_activite}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Objectif de l'activité</label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{$demande->obejectif_activite}}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Date du debut
                                            </label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{$demande->debut_activite}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Date du fin</label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{$demande->fin_activite}}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Durée d'exécution</label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{$demande->dure_activite}} Jours">
                                        </div>
                                    </div>


                                    @if ($demande->buget_prevu != 0)
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label style="font-weight: bold">Budget
                                                </label>
                                                <input type="text" class="form-control" disabled=""
                                                    value="{{$demande->budget}} cfa">
                                            </div>
                                        </div>

                                        <div class="col-md-6 px-1">
                                            <div class="form-group">
                                                <label style="font-weight: bold">Budget prevue
                                                </label>
                                                <input type="text" class="form-control" disabled=""
                                                    value="{{$demande->buget_prevu}} cfa">
                                            </div>
                                        </div>


                                    </div>

                                    @else



                                    <div class="col-md-12 pr-1">
                                        <div class="form-group">
                                            <label style="font-weight: bold">Budget
                                            </label>
                                            <input type="text" class="form-control" disabled=""
                                                value="{{$demande->budget}} cfa">
                                        </div>
                                    </div>

                                    @endif


                                    <div class="d-flex justify-content-center items-center">
                                        <a href="{{route('demande.piece',$demande->id)}} " class="btn btn-success">Télécharger le fichier</a>
                                    </div>

                                    <div class="card-header">
                                        <h5 class="title">Localisations du projet</h5>
                                    </div>
                                    @if(isset($localisations) && count($localisations))
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Département</th>
                                                    <th>Commune</th>
                                                    <th>Lieu d'exécution</th>
                                                    <th>Hommes touchés</th>
                                                    <th>Femmes touchées</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($localisations as $loc)
                                                <tr>
                                                    <td>{{ $loc->departement ? $loc->departement->nom : '' }}</td>
                                                    <td>{{ $loc->commune ? $loc->commune->nom : '' }}</td>
                                                    <td>{{ $loc->lieux }}</td>
                                                    <td>{{ $loc->homme_touche }}</td>
                                                    <td>{{ $loc->femme_touche }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <p>Aucune localisation enregistrée pour cette demande.</p>
                                    @endif

                                    <div>
                                        <button type="button"
                                            class="btn btn-secondary prev-step">Précédent</button>
                                    </div>

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