<div>
  <!-- Import de la police Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  @include('livewire.modal')

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
          <a class="navbar-brand" href="#pablo">Liste des Demandes Suspendues</a>
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
              <h2 style="font-weight: bold; margin:0;">SPEA</h2>
              @elseif (Auth::user()->email == 'sese@gmail.com')
              <h2 style="font-weight: bold; margin:0;">SESE</h2>
              @elseif (Auth::user()->email == 'dg@gmail.com')
              <h2 style="font-weight: bold; margin:0;">DG</h2>
              @elseif (Auth::user()->email == 'daf@gmail.com')
              <h2 style="font-weight: bold; margin:0;">DAF</h2>
              @elseif (Auth::user()->email == 'do@gmail.com')
              <h2 style="font-weight: bold; margin:0;">DO</h2>
              @elseif (Auth::user()->email == 'secretaire@gmail.com')
              <h2 style="font-weight: bold; margin:0;">SECRETAIRE</h2>
              @endif
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="now-ui-icons users_single-02"></i>
                <p><span class="d-lg-none d-md-block">Actions</span></p>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('profile.show') }}">Profil</a>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-weight: bold">
                  <i class="now-ui-icons media-1_button-power"></i> Déconnexion
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

    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card modern-card">
            <div class="card-header">
              <h4 class="card-title">Gestion des Suspensions</h4>
              <p class="card-category">Liste des demandes actuellement suspendues</p>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="styled-table">
                  <thead>
                    <tr>
                      <th>Structure</th>
                      <th>Nom et Prénom</th>
                      <th>Budget</th>
                      <th>Statut</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($demandes as $demande)
                    <tr>
                      <td style="font-weight: 500; color: #333;">{{$demande->structure}}</td>

                      <td>{{$demande->nom}} {{$demande->prenom}}</td>
                      <td style="font-weight: bold;">{{ number_format($demande->budget, 0, ',', ' ') }} </td>
                      <td>
                        <span class="status-badge status-warning">
                          {{$demande->statut}}
                        </span>
                      </td>
                      <td class="text-center">
                        <div class="action-buttons">
                          <a href="{{route('demande.show',$demande->id)}}" class="btn-action btn-view" title="Visualiser">
                            <i class="now-ui-icons gestures_tap-01"></i>
                          </a>
                          <a href="{{route('demande.edit',$demande->id)}}" class="btn-action btn-edit" title="Modifier">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                            </svg>
                          </a>
                          <button onclick="confirmerTransmission({{$demande->id}})" class="btn-action btn-send" title="Transmettre">
                            <i class="now-ui-icons ui-1_send"></i>
                          </button>

                          <button onclick="confirmerSuppression({{$demande->id}})" class="btn-action btn-delete" title="Supprimer">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                            </svg>
                          </button>
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="7" class="text-center py-5">
                        <div style="display: flex; flex-direction: column; align-items: center; color: #888;">
                          <i class="now-ui-icons files_box" style="font-size: 32px; margin-bottom: 10px;"></i>
                          <p style="font-size: 16px;">Aucune demande suspendue</p>
                        </div>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- Pagination -->
              <div class="mt-4 d-flex justify-content-end">
                {{$demandes->links()}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('Admin.footer')
  </div>

  <style>
    /* Application de la police Poppins Globalement */
    body,
    .main-panel,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    span,
    a,
    div,
    table,
    button {
      font-family: 'Poppins', sans-serif !important;
    }

    /* Card Moderne */
    .modern-card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
      background: #fff;
    }

    .card-title {
      font-weight: 600;
      color: #2c3e50;
      font-size: 20px;
    }

    .card-category {
      color: #888;
      font-size: 14px;
    }

    /* Table Moderne */
    .styled-table {
      width: 100%;
      border-collapse: collapse;
      margin: 25px 0;
      font-size: 0.9em;
      min-width: 400px;
      border-radius: 8px 8px 0 0;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.03);
    }

    .styled-table thead tr {
      background-color: #009879;
      color: #ffffff;
      text-align: left;
      font-weight: bold;
    }

    .styled-table th,
    .styled-table td {
      padding: 15px 20px;
    }

    .styled-table tbody tr {
      border-bottom: 1px solid #dddddd;
      transition: all 0.2s ease;
    }

    .styled-table tbody tr:nth-of-type(even) {
      background-color: #f8f9fa;
    }

    .styled-table tbody tr:last-of-type {
      border-bottom: 2px solid #009879;
    }

    .styled-table tbody tr:hover {
      background-color: #eafaf6;
      cursor: default;
    }

    /* Badges de Statut */
    .status-badge {
      padding: 6px 12px;
      border-radius: 30px;
      font-size: 12px;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      display: inline-block;
    }

    .status-warning {
      background-color: #fff3cd;
      color: #856404;
      border: 1px solid #ffeeba;
    }

    /* Boutons d'action */
    .action-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
    }

    .btn-action {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      text-decoration: none !important;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      border: 1px solid transparent;
      cursor: pointer;
    }

    .btn-view {
      color: #009879;
      border-color: #009879;
    }

    .btn-view:hover {
      background-color: #009879;
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-send {
      color: #3498db;
      border-color: #3498db;
    }

    .btn-send:hover {
      background-color: #3498db;
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-delete {
      color: #e74c3c;
      border-color: #e74c3c;
    }

    .btn-edit {
      color: #6c757d;
      border-color: #6c757d;
    }

    .btn-edit:hover {
      background-color: #6c757d;
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-delete {
      color: #dc3545;
      border-color: #dc3545;
    }

    .btn-delete:hover {
      background-color: #dc3545;
      color: #fff;
      transform: translateY(-2px);
    }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function confirmerTransmission(demandeId) {
      Swal.fire({
        title: 'Confirmation',
        text: 'Êtes-vous sûr de vouloir transmettre cette demande ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#009879',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, transmettre',
        cancelButtonText: 'Annuler',
        customClass: {
          popup: 'swal-poppins'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          Livewire.find('{{ $_instance->id }}').call('Transmetre', demandeId);
        }
      });
    }

    function confirmerSuppression(demandeId) {
      Swal.fire({
        title: 'Confirmation de suppression',
        text: 'Êtes-vous sûr de vouloir supprimer cette demande ? Cette action est irréversible.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
        customClass: {
          popup: 'swal-poppins'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          const deleteUrl = "{{ url('/delete') }}/" + demandeId;
          window.location.href = deleteUrl;
        }
      });
    }
  </script>

  <style>
    .swal-poppins {
      font-family: 'Poppins', sans-serif !important;
    }
  </style>
</div>