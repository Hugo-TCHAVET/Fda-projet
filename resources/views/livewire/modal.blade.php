<!-- Modal  visualiser-->

<div wire:ignore.self class="modal fade" id="visualiserBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="visualiserBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="visualiserBackdropLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="content">
                    <div class="row">
                        <div class="col">
                            <div class="card">

                                <div class="card-body">
                                    <form>
                                        <div id="step1" class="step active">
                                            <div class="card-header">
                                                <h5 class="title">Information Générale</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 pr-1">
                                                    <div class="form-group">
                                                        <label>Structure du Demandeur</label>
                                                        <input type="text" class="form-control"
                                                            value="Creative Code Inc." readonly wire:model="structure">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 px-1">
                                                    <div class="form-group">
                                                        <label>Service</label>
                                                        <input type="text" class="form-control" value="" readonly
                                                            wire:model="service">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pl-1">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Type de Demande </label>
                                                        <input type="text" class="form-control" readonly
                                                            wire:model="type_demande">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 pr-1">
                                                    <div class="form-group">
                                                        <label>Branche</label>
                                                        <input type="text" class="form-control" @if($branche)
                                                            wire:model="branche" @else value="null" @endif readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pl-1">
                                                    <div class="form-group">
                                                        <label>Corps du Métier</label>
                                                        <input type="text" class="form-control" @if($corps)
                                                            wire:model="corps" @else value="null" @endif readonly>
                                                    </div>

                                                </div>
                                                <div class="col-md-6 pl-1">
                                                    <div class="form-group">
                                                        <label>Métier</label>
                                                        <input type="text" class="form-control" @if($metier)
                                                            wire:model="metier" @else value="null" @endif readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <button type="button" class="btn btn-primary next-step">Suivant</button>
                                            </div>
                                        </div>
                                        <div id="step2" class="step">
                                            <div class="card-header">
                                                <h5 class="title">Information Personelle</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 pr-1">
                                                    <div class="form-group">
                                                        <label>Nom</label>
                                                        <input type="text" class="form-control" placeholder="City"
                                                            wire:model="nom" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 px-1">
                                                    <div class="form-group">
                                                        <label>Prenom</label>
                                                        <input type="text" class="form-control" placeholder="Country"
                                                            wire:model="prenom" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pl-1">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" wire:model="email"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 pr-1">
                                                    <div class="form-group">
                                                        <label>Sexe</label>
                                                        <input type="text" class="form-control" wire:model="sexe"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 px-1">
                                                    <div class="form-group">
                                                        <label>Ifu</label>
                                                        <input type="text" class="form-control" wire:model="ifu"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pl-1">
                                                    <div class="form-group">
                                                        <label>Contact</label>
                                                        <input type="number" class="form-control" wire:model="contact"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <button type="button"
                                                    class="btn btn-primary prev-step">Précédent</button>
                                                <button type="button" class="btn btn-primary next-step">Suivant</button>
                                            </div>
                                        </div>
                                        <div id="step3" class="step">
                                            <div class="card-header">
                                                <h5 class="title">Information sur le projet</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 pr-1">
                                                    <div class="form-group">
                                                        <label>Titre de l'activité</label>
                                                        <input type="text" class="form-control" placeholder="City"
                                                            wire:model="titre_activite" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 px-1">
                                                    <div class="form-group">
                                                        <label>Objectif de l'activité</label>
                                                        <textarea class="form-control" placeholder="Country"
                                                            wire:model="obejectif_activite" readonly></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pl-1">
                                                    <div class="form-group">
                                                        <label>Date du debut </label>
                                                        <input type="date" class="form-control"
                                                            wire:model="debut_activite" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 pr-1">
                                                    <div class="form-group">
                                                        <label>Date du fin</label>
                                                        <input type="date" class="form-control" placeholder="City"
                                                            wire:model="fin_activite" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 px-1">
                                                    <div class="form-group">
                                                        <label>Durée d'exécution</label>
                                                        <input type="text" class="form-control" placeholder="Country"
                                                            wire:model="dure_activite" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pl-1">
                                                    <div class="form-group">
                                                        <label>Departement</label>
                                                        <input type="text" class="form-control"
                                                            wire:model="departement" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 pr-1">
                                                    <div class="form-group">
                                                        <label>Commune</label>
                                                        <input type="text" class="form-control" placeholder="City"
                                                            wire:model="commune" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 px-1">
                                                    <div class="form-group">
                                                        <label>Lieux d'exécution</label>
                                                        <input type="text" class="form-control" placeholder="Country"
                                                            wire:model="lieux" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pl-1">
                                                    <div class="form-group">
                                                        <label>Personne touchées ( Hommes )</label>
                                                        <input type="number" class="form-control"
                                                            wire:model="homme_touche" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 pr-1">
                                                    <div class="form-group">
                                                        <label>Personne touchées ( Femmes )</label>
                                                        <input type="text" class="form-control" placeholder="City"
                                                            wire:model="femme_touche" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 px-1">
                                                    <div class="form-group">
                                                        <label>Budget</label>
                                                        <input type="text" class="form-control" placeholder="Country"
                                                            wire:model="budget" readonly>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="d-flex justify-content-center items-center">
                                                <button wire:click="downloadRapportEnquete(($demande->id))"
                                                    class="btn btn-success">Télécharger le fichier</button>
                                            </div>


                                            <div>
                                                <button type="button"
                                                    class="btn btn-primary prev-step">Précédent</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

            </div>
        </div>
    </div>
</div>







<!-- Modal  Suspension-->


<div wire:ignore.self class="modal fade" id="suspendreModal" tabindex="-1" aria-labelledby="suspendreModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suspendreModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 px-1">
                    <form method="post" wire:submit.prevent="updateMessage">
                        @csrf
                        <div class="card-header">
                            <h5 class="title">Message de suspension</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label> Votre Message </label>
                                    <input type="text" class="form-control" value="Creative Code Inc."
                                        wire:model="message">
                                </div>

                                <button type="submit" class="btn btn-success">Confirmer</button>
                            </div>

                        </div>






                    </form>

                </div>
            </div>

        </div>
    </div>
</div>







<!-- Modal  Valider-->


<div wire:ignore.self class="modal fade" id="ValiderModal" tabindex="-1" aria-labelledby="validerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="validerModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 px-1">
                    <form method="post" wire:submit.prevent="updateBudget">
                        @csrf

                        <div class="card-header">
                            <h5 class="title">Budget Attribué</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label> Le Montant</label>
                                    <input type="number" class="form-control" value="Creative Code Inc."
                                        wire:model="buget_prevu">
                                </div>

                                <button type="submit" class="btn btn-success">Confirmer</button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>




