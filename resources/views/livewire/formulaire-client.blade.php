<div>
    <main id="main">

        <section id="contact" class="contact">
            <div class="container">

                <div class="section-title mb-4">
                    <h2>Formulaire de Demande</h2>
                </div>

                <div class="row mt-1">


                    <div class="col-lg-12 mt-5 mt-lg-0">

                        <form wire:submit.prevent="store" class="php-email-form mt-4" enctype="multipart/form-data">
                            @csrf
                            @if ($formStep == 1)

                            <div class="row mb-2">
                                <div class="text-center mb-4">
                                    <h2 style="font-weight: bold">Informations sur la structure</h2>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Structure Demandeur</label>
                                    <input type="text" name="structure" class="form-control" id=""
                                        wire:model.lazy="structure">
                                    @error('structure') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="" style="font-weight: bold">Service</label>
                                    <select name="service" id="" class="form-control" wire:model.lazy="service">
                                        <option value="" selected>Choisissez un service</option>
                                        <option value="Assistance">Demande Assistance</option>
                                        <option value="Formation">Demande Formation</option>
                                        <option value="Financier">Appui Financier</option>
                                    </select>
                                    @error('service') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>

                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Type Demandeur</label>
                                    <select name="sexe" id="" class="form-control" wire:model.lazy="type_demande">
                                        <option value="" selected>Choisissez le type</option>
                                        <option value="professionnel">Organisations professionnelles d’artisans</option>
                                        <option value="structure">Associations/Structures formelles intervenant dans le
                                            secteur de l’artisanat</option>
                                        <option value="ONG">Organisations Non Gouvernementales (ONG) intervenant dans le
                                            secteur de l’artisanat</option>

                                    </select>

                                    @error('type_demande') <span class="error text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="" style="font-weight: bold">Branche</label>
                                    <select name="branche" id="" class="form-control" wire:model.lazy="branche">
                                        <option value="" selected>Choisissez une branche</option>
                                        @forelse ($branches as $branche )
                                        <option value="{{$branche->id}}">{{$branche->nom}}</option>
                                        @empty
                                        <option value="" disabled>Pas de branche</option>
                                        @endforelse


                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="" style="font-weight: bold">Corps Métier</label>
                                    <select name="corps" id="" class="form-control" wire:model.lazy="corps">
                                        <option value="" selected>Choisissez un corps de métier</option>
                                        @forelse ($corp as $corps )
                                        <option value="{{$corps->id}}">{{$corps->nom}}</option>
                                        @empty
                                        <option value="" disabled>Pas de corps de métier</option>
                                        @endforelse
                                    </select>


                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="" style="font-weight: bold">Metier</label>
                                    <select name="metier" id="" class="form-control" wire:model.lazy="metier">
                                        <option value="" selected>Choisissez un métier</option>
                                        @forelse ($metiers as $metier )
                                        <option value="{{$metier->id}}">{{$metier->nom}}</option>
                                        @empty
                                        <option value="" disabled>Pas de métier</option>
                                        @endforelse
                                    </select>


                                </div>
                            </div>

                            @elseif ($formStep == 2)


                            <div class="row mb-2">

                                <div class="text-center mb-4">
                                    <h2 style="font-weight: bold">Informations personnelles</h2>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Nom</label>
                                    <input type="text" name="nom" class="form-control" id="" wire:model.lazy="nom">
                                    @error('nom') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="" style="font-weight: bold">Prenom</label>
                                    <input type="text" class="form-control" name="prenom" id=""
                                        wire:model.lazy="prenom">
                                    @error('prenom') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Email</label>
                                    <input type="email" name="name" class="form-control" id="" wire:model.lazy="email">
                                    @error('email') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="" style="font-weight: bold">Sexe</label>
                                    <select name="sexe" id="" class="form-control" wire:model.lazy="sexe">
                                        <option value="" selected>Choisissez le sexe</option>
                                        <option value="Masculin">Masculin</option>
                                        <option value="Feminin">Féminin</option>

                                    </select>
                                    @error('sexe') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">IFU</label>
                                    <input type="text" name="ifu" class="form-control" id="" wire:model.lazy="ifu">
                                    @error('ifu') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="" style="font-weight: bold">Contact</label>
                                    <input type="number" class="form-control" name="contact" id=""
                                        wire:model.lazy="contact">
                                    @error('contact') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            @elseif ($formStep == 3)

                            <div class="row mb-2">

                                <div class=" text-center mb-4">
                                    <h2 style="font-weight: bold">Informations sur le projet</h2>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Titre de l'activité</label>
                                    <input type="text" name="titre_activite" class="form-control" id=""
                                        wire:model.lazy="titre_activite">
                                    @error('titre_activite') <span class="error text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="" style="font-weight: bold">Objectif de l'activité</label>
                                    <textarea class="form-control" name="obejectif_activite" id=""
                                        wire:model.lazy="obejectif_activite"></textarea>
                                    @error('obejectif_activite') <span class="error text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Date debut </label>
                                    <input type="date" name="debut_activite" min="{{$date}}" class="form-control" id=""
                                        wire:model.lazy="debut_activite">
                                    @error('debut_activite') <span class="error text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="" style="font-weight: bold">Date fin</label>
                                    <input type="date" class="form-control" min="{{$debut_activite}}" name="fin_activite" id=""
                                        wire:model.lazy="fin_activite">
                                    @error('fin_activite') <span class="error text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Durée </label>
                                    <input type="number" name="dure_activite" class="form-control" id=""
                                        wire:model.lazy="dure_activite" value="" readonly>
                                    @error('dure_activite') <span class="error text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="" style="font-weight: bold">Département</label>
                                    <select name="departement" id="" class="form-control" wire:model.lazy="departement">
                                        <option value="" selected>Choisissez un département</option>
                                        @forelse ($departements as $departement )
                                        <option value="{{$departement->id}}">{{$departement->nom}}</option>
                                        @empty
                                        <option value="" disabled>Pas de département</option>
                                        @endforelse



                                    </select>
                                    @error('departement') <span class="error text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Commune </label>
                                    <select name="commune" id="" class="form-control" wire:model.lazy="commune">
                                        <option value="" selected>Choisissez une commune</option>
                                        @forelse ($communes as $commune )
                                        <option value="{{$commune->id}}">{{$commune->nom}}</option>
                                        @empty
                                        <option value="" disabled>Pas de commune</option>
                                        @endforelse

                                    </select>
                                    @error('commune') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="" style="font-weight: bold">Lieu d'exécution</label>
                                    <input type="text" class="form-control" name="lieux" id="" wire:model.lazy="lieux">
                                    @error('lieux') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Nombre d'homme touché </label>
                                    <input type="number" class="form-control" name="homme_touche" id=""
                                        wire:model.lazy="homme_touche">
                                    @error('homme_touche') <span class="error text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Nombre de femme touchée </label>
                                    <input type="number" class="form-control" name="femme_touche" id=""
                                        wire:model.lazy="femme_touche">
                                    @error('femme_touche') <span class="error text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Budget Prévisionnel</label>
                                    <input type="number" class="form-control" name="budget" id=""
                                        wire:model.lazy="budget">
                                    @error('budget') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            @elseif ($formStep == 4)

                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="" style="font-weight: bold">Fichier</label>
                                    <input type="file" class="form-control" name="piece" id="" wire:model.lazy="piece">
                                    @error('piece') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>

                            </div>
                            @endif

                            @if ($formStep == 1)
                            <div class="text-center"><button type="button" class="bg-success"
                                    wire:click="nextStep1">Suivant</button></div>

                            @elseif ($formStep == 2)
                            <div class="text-center">
                                <button type="button" class="bg-primary" wire:click="prevStep">Précédent</button>
                                <button type="button" class="bg-success" wire:click="nextStep2">Suivant</button>
                            </div>
                            @elseif ($formStep == 3)
                            <div class="text-center">
                                <button type="button" class="bg-primary" wire:click="prevStep">Précédent</button>
                                <button type="button" class="bg-success" wire:click="nextStep3">Suivant</button>
                            </div>
                            @elseif ($formStep == 4)
                            <div class="text-center">
                                <button type="button" class="bg-primary" wire:click="prevStep">Précédent</button>
                                <button type="submit" id="sendButton" class="bg-success" wire:loading.attr="disabled">Envoyer</button>
                            </div>
                            <div id="loadingAnimation" class="loading-animation" wire:loading.flex wire:target="store"></div>

                            @endif

                        </form>

                    </div>

                </div>

            </div>
        </section>
    </main>
</div>


<style>
    .loading-animation {
        position: fixed;
        top: 50%;
        left: 50%;
        width: 50px;
        height: 50px;
        border: 5px solid rgba(0, 0, 0, 0.1);
        border-left-color: #22a6b3;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        transform: translate(-50%, -50%);
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>