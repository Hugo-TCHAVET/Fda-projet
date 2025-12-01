<div>
  <!-- Import de la police Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  @include('livewire.modal')

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
          <a class="navbar-brand" style="font-weight: bold; font-size: 1.2rem;">Liste des demandes approuvées</a>
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
              @endif
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="now-ui-icons users_single-02"></i>
                <p></p>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('profile.show') }}">Profil</a>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                  style="font-weight: bold">
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

    <div style="height: 17vh; background-color: #198754;">
    </div>

    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card modern-card">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h4 class="card-title">Gestion des demandes</h4>
                  <p class="card-category">Liste de toutes les demandes validées et approuvées</p>
                </div>
                <div class="d-flex gap-2">
                  <button wire:click="exportExcel" class="btn btn-success" style="border-radius: 8px; padding: 8px 20px;">
                    <i class="now-ui-icons files_single-copy-04" style="margin-right: 5px;"></i>
                    Exporter en Excel
                  </button>
                  @if(Auth::user()->email == 'sese@gmail.com')
                  <button wire:click="openClotureModal" class="btn btn-danger" style="border-radius: 8px; padding: 8px 20px;">
                    <i class="now-ui-icons files_box" style="margin-right: 5px;"></i>
                    Clôturer exercice
                  </button>
                  @endif
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="styled-table">
                  <thead>
                    <tr>
                      <th>Structure</th>
                      <th>Nom et Prénom</th>
                      <th>Budget de l'activité</th>
                      <th>Appui financier accordé</th>
                      <th>Date d'approbation</th>
                      <th>Statut</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($demandes as $demande)
                    <tr>
                      <td style="font-weight: 500; color: #333;">
                        {{ $demande->structure }}
                      </td>
                      <td>
                        {{ $demande->nom }} {{ $demande->prenom }}
                      </td>
                      <td>
                        {{ number_format($demande->budget, 0, ',', ' ') }} FCFA
                      </td>
                      <td style="font-weight: bold; color: #009879;">
                        {{ number_format($demande->buget_prevu, 0, ',', ' ') }} FCFA
                      </td>
                      <td>
                        <span style="font-weight: 500; color: #666;">
                          {{ $demande->date_approbation ? \Carbon\Carbon::parse($demande->date_approbation)->format('d/m/Y') : 'N/A' }}
                        </span>
                      </td>
                      <td>
                        <span class="status-badge status-approved">
                          {{ $demande->statuts }}
                        </span>
                      </td>
                      <td class="text-center">
                        <div class="action-buttons">
                          <a href="{{ route('demande.show', $demande->id) }}"
                            class="btn-action btn-view" title="Visualiser">
                            <i class="now-ui-icons gestures_tap-01"></i>
                          </a>

                          <a href="{{ route('demande.pdf', $demande->id) }}" class="btn-action btn-pdf" title="Imprimer en PDF">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                              <polyline points="14 2 14 8 20 8"></polyline>
                              <line x1="12" y1="18" x2="12" y2="12"></line>
                              <polyline points="9 15 12 18 15 15"></polyline>
                            </svg>
                          </a>

                          {{--<button wire:click="openArchiveModal({{ $demande->id }})" class="btn-action btn-archive" title="Archiver">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="21 8 21 21 3 21 3 8"></polyline>
                            <rect x="1" y="3" width="22" height="5"></rect>
                            <line x1="10" y1="12" x2="14" y2="12"></line>
                          </svg>
                          </button>--}}
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="7" class="text-center py-5">
                        <div style="display: flex; flex-direction: column; align-items: center; color: #888;">
                          <i class="now-ui-icons files_box" style="font-size: 32px; margin-bottom: 10px;"></i>
                          <p style="font-size: 16px;">Aucune demande trouvée</p>
                        </div>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <!-- Pagination moderne -->
              <div class="mt-4 d-flex justify-content-end">
                {{ $demandes->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('Admin.footer')
  </div>

  <!-- Modal d'archivage -->
  @if ($showModalArchive)
  <div class="modal fade show" style="display: block;" tabindex="-1" aria-labelledby="archiveModalLabel"
    aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div class="modal-header" style="border-bottom: 1px solid #eee; padding: 20px;">
          <h5 class="modal-title" id="archiveModalLabel" style="font-weight: 600; color: #2c3e50;">
            <i class="now-ui-icons files_box" style="margin-right: 8px;"></i>
            Archiver la demande
          </h5>
          <button type="button" class="btn-close" wire:click="closeArchiveModal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 20px;">
          <form wire:submit.prevent="archiver">
            <div class="mb-3">
              <h6 style="color: #009879; font-weight: 600;">{{ $structureArchive }}</h6>
              <p style="color: #666; font-size: 0.9em; margin-top: 5px;">
                Veuillez renseigner l'année d'exercice pour archiver cette demande.
              </p>
            </div>
            <div class="form-group mb-3">
              <label style="font-size: 0.9em; color: #555; font-weight: 500;">
                Année d'exercice <span class="text-danger">*</span>
              </label>
              <input type="number"
                class="form-control @error('annee_exercice') is-invalid @enderror"
                wire:model.defer="annee_exercice"
                min="2000"
                max="{{ date('Y') + 1 }}"
                placeholder="{{ date('Y') }}"
                style="border-radius: 8px; padding: 10px; border: 1px solid #ddd;">
              @error('annee_exercice')
              <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
              @enderror
            </div>
            <div class="modal-footer" style="border-top: 1px solid #eee; padding-top: 15px; margin-top: 20px;">
              <button type="button" class="btn btn-secondary" wire:click="closeArchiveModal"
                style="border-radius: 8px; padding: 8px 20px;">
                Annuler
              </button>
              <button type="submit" class="btn btn-primary"
                style="background-color: #009879; border: none; border-radius: 8px; padding: 8px 20px;">
                <i class="now-ui-icons files_box" style="margin-right: 5px;"></i>
                Archiver
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-backdrop fade show"></div>
  @endif

  <!-- Modal de clôture d'exercice -->
  @if ($showModalCloture)
  <div class="modal fade show" style="display: block;" tabindex="-1" aria-labelledby="clotureModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div class="modal-header" style="border-bottom: 1px solid #eee; padding: 20px;">
          <h5 class="modal-title" id="clotureModalLabel" style="font-weight: 600; color: #2c3e50;">
            <i class="now-ui-icons files_box" style="margin-right: 8px;"></i>
            Clôturer un exercice
          </h5>
          <button type="button" class="btn-close" wire:click="closeClotureModal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 20px;">
          <form id="formClotureExercice" onsubmit="return false;">
            <div class="alert alert-danger" style="border-radius: 8px; margin-bottom: 20px;">
              <strong><i class="now-ui-icons ui-1_bell-53"></i> Information importante</strong>
              <p style="margin: 10px 0 0 0;">
                La clôture d'exercice permet d'archiver définitivement toutes les demandes de l'année sélectionnée dans les archives historiques.
                Les données seront conservées pour consultation et statistiques, mais ne seront plus accessibles dans le système de gestion actif.
                Assurez-vous que toutes les opérations et validations de l'année sont complètes avant de procéder à cette action.
              </p>
            </div>

            <div class="form-group mb-3">
              <label style="font-size: 0.9em; color: #555; font-weight: 500;">
                Année à clôturer <span class="text-danger">*</span>
              </label>
              <input type="number"
                class="form-control @error('annee_cloture') is-invalid @enderror"
                wire:model.defer="annee_cloture"
                wire:change="calculerStatistiquesCloture"
                min="2000"
                max="{{ date('Y') }}"
                placeholder="{{ date('Y') - 1 }}"
                style="border-radius: 8px; padding: 10px; border: 1px solid #ddd;">
              @error('annee_cloture')
              <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
              @enderror
            </div>

            @if($annee_cloture && $nbDemandesACloturer > 0)
            <div class="card" style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
              <h6 style="color: #009879; font-weight: 600; margin-bottom: 15px;">
                <i class="now-ui-icons business_chart-bar-32"></i> Résumé de la clôture
              </h6>
              <div class="row">
                <div class="col-md-6">
                  <p style="margin: 5px 0;"><strong>Nombre de demandes :</strong>
                    <span style="color: #009879; font-weight: bold;">{{ $nbDemandesACloturer }}</span>
                  </p>
                </div>
                <div class="col-md-6">
                  <p style="margin: 5px 0;"><strong>Budget total attribué :</strong>
                    <span style="color: #009879; font-weight: bold;">
                      {{ number_format($budgetTotalACloturer, 0, ',', ' ') }} FCFA
                    </span>
                  </p>
                </div>
              </div>
            </div>
            @elseif($annee_cloture && $nbDemandesACloturer == 0)
            <div class="alert alert-info" style="border-radius: 8px;">
              <i class="now-ui-icons ui-1_info"></i>
              Aucune demande trouvée pour l'année {{ $annee_cloture }}.
            </div>
            @endif

            <div class="modal-footer" style="border-top: 1px solid #eee; padding-top: 15px; margin-top: 20px;">
              <button type="button" class="btn btn-secondary" wire:click="closeClotureModal"
                style="border-radius: 8px; padding: 8px 20px;">
                Annuler
              </button>
              <!-- Bouton caché pour déclencher la clôture via Livewire -->
              <button type="button" id="btnCloturerConfirm" wire:click="cloturerExercice" style="display: none;"></button>
              <button type="button" class="btn btn-danger btn-cloturer-exercice"
                style="border: none; border-radius: 8px; padding: 8px 20px;"
                @if($nbDemandesACloturer==0) disabled @else data-annee="{{ $annee_cloture }}" data-nb-demandes="{{ $nbDemandesACloturer }}" @endif>
                <i class="now-ui-icons files_box" style="margin-right: 5px;"></i>
                Clôturer l'exercice
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-backdrop fade show"></div>
  @endif

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
    table {
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

    /* Table Moderne Style Datatable */
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
      /* Couleur du thème PDF */
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
      /* Vert très pâle au survol */
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

    .status-approved {
      background-color: #d1e7dd;
      color: #0f5132;
      border: 1px solid #badbcc;
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
    }

    .btn-view {
      background-color: #fff;
      color: #009879;
      border: 1px solid #009879;
    }

    .btn-view:hover {
      background-color: #009879;
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-pdf {
      background-color: #fff;
      color: #e74c3c;
      border: 1px solid #e74c3c;
    }

    .btn-pdf:hover {
      background-color: #e74c3c;
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-archive {
      background-color: #fff;
      color: #6c757d;
      border: 1px solid #6c757d;
      border: none;
      cursor: pointer;
    }

    .btn-archive:hover {
      background-color: #6c757d;
      color: #fff;
      transform: translateY(-2px);
    }

    /* Suppression des styles Bootstrap/NowUI gênants */
    .table>thead>tr>th {
      font-size: 13px;
      font-weight: 600;
      border-bottom-width: 1px;
    }
  </style>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // Utilisation de la délégation d'événements pour fonctionner avec Livewire
    document.addEventListener('click', function(e) {
      if (e.target.closest('.btn-cloturer-exercice')) {
        e.preventDefault();
        e.stopPropagation();

        const btn = e.target.closest('.btn-cloturer-exercice');
        const annee = btn.getAttribute('data-annee');
        const nbDemandes = btn.getAttribute('data-nb-demandes');

        if (!annee || !nbDemandes) return;

        Swal.fire({
          title: 'Confirmation de clôture d\'exercice',
          html: `
            <p>Êtes-vous sûr de vouloir clôturer l'exercice <strong>${annee}</strong> ?</p>
            <p style="margin-top: 10px; color: #dc3545;">
              <strong>${nbDemandes} demande(s)</strong> seront archivées définitivement.
            </p>
            <p style="margin-top: 10px; font-size: 0.9em; color: #666;">
              Cette action est irréversible et les données ne seront plus accessibles dans le système actif.
            </p>
          `,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Oui, clôturer l\'exercice',
          cancelButtonText: 'Annuler',
          customClass: {
            popup: 'swal-poppins'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            // Cliquer sur le bouton caché pour déclencher la méthode Livewire
            const btnConfirm = document.getElementById('btnCloturerConfirm');
            if (btnConfirm) {
              btnConfirm.click();
            }
          }
        });
      }
    });
  </script>

  <style>
    .swal-poppins {
      font-family: 'Poppins', sans-serif !important;
    }
  </style>
</div>