<div>


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
          <a class="navbar-brand" href="#pablo" style="font-weight: bold">Liste des Demandes</a>
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
      <div class="row">
        <div class="col-md-12">

          <div class="card">

            <div class="card-body">


              <div class="table-responsive mt-4 mb-4">
                <table class="table mt-4 mb-4">
                  <thead class=" text-primary text-center mb-4">

                    <th style="font-weight: bold">
                      Structure
                    </th>

                    <th style="font-weight: bold">
                      Contact
                    </th>

                    <th style="font-weight: bold">
                      Budget
                    </th>
                    <th style="font-weight: bold">
                      DateDebut
                    </th>

                    <th style="font-weight: bold">
                      Statut
                    </th>
                    @if (Auth::user()->email == 'dg@gmail.com' || Auth::user()->email == 'daf@gmail.com' || Auth::user()->email == 'do@gmail.com')

                    @else
                    <th style="font-weight: bold">
                      Action
                    </th>
                    @endif


                  </thead>

                  <tbody class="mb-4">
                    @forelse ($demandes as $demande)


                    <tr>

                      <td class="text-center">
                        {{$demande->structure}}
                      </td>

                      <td class="text-center">
                        {{$demande->contact}}
                      </td>

                      <td class="text-center">
                        {{$demande->budget}}
                      </td>
                      <td class="text-center">
                        {{$demande->debut_activite}}
                      </td>

                      <td class="text-center">


                        <span class="btn btn-primary">
                          {{$demande->status}}
                        </span>

                      </td>
                      @if (Auth::user()->email == 'dg@gmail.com' || Auth::user()->email == 'daf@gmail.com' || Auth::user()->email == 'do@gmail.com')

                      @else
                      <td class="text-center">

                        <a href="{{route('demande.show',$demande->id)}}" id="tooltip" class="btn btn-primary mb-2">
                          <span class="tooltiptext">Visualiser</span>
                          <i class="now-ui-icons gestures_tap-01"></i>
                        </a>



                        <a class="btn btn-success mb-2" href="#" id="tooltip" wire:click="Transmetre(({{$demande->id}}))">
                          <span class="tooltiptext">Transmettre</span>
                          <i class="now-ui-icons ui-1_send"></i> </a>

                        @if ($demande->message != null)

                        @else

                        <a href="{{route('demande.message',$demande->id)}}" id="tooltip" class="btn btn-info mb-2">
                          <span class="tooltiptext">Suspendre</span>

                          <i class="now-ui-icons media-1_button-pause"></i>
                        </a>

                        @endif



                      </td>
                      @endif

                    </tr>
                    @empty

                    <td class="text-right" colspan="6">
                      <p style="font-weight: bold"> Aucune demande</p>
                    </td>


                    @endforelse
                  </tbody>

                </table>
                {{$demandes->links()}}
              </div>
              @include('livewire.modal')
            </div>
          </div>
        </div>

      </div>
    </div>
    @include('Admin.footer')
  </div>
</div>



<script src="{{asset('js/jquery-3.6.0.min.js')}}" type="text/javascript"> </script>

</div>


<style>
  a#tooltip {
    position: relative;
    display: inline-block;

  }

  a#tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    /* Position au-dessus du lien */
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
  }

  a#tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
  }
</style>