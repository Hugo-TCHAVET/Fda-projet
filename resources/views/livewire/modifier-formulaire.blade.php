<div>
    <main id="main">

        <section id="contact" class="contact">
            <div class="container" >

                <div class="section-title mb-4">
                    <h2>Contact</h2>
                </div>

                <div class="row mt-1">


                    <div class="col-lg- mt-5 mt-lg-0">

                        <form method="post" class="php-email-form mt-4" enctype="multipart/form-data">
                            @csrf
                            @if ($formStep == 1)

                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">Structure Demandeur</label>
                                    <input type="text" name="structure" class="form-control" id=""
                                       wire:model.lazy="structure">
                                       @error('structure') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="">Service</label>
                                    <select name="service" id="" class="form-control" wire:model.lazy="service">
                                        <option value="" selected>Choisisez un service</option>
                                        <option value="Assistance">Demande Assistance</option>
                                        <option value="Formation">Demande Formation</option>
                                        <option value="Financier">Appui Financier</option>
                                    </select>
                                    @error('service') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">Type Demandeur</label>
                                    <input type="text" name="type_demande" class="form-control" id=""
                                        wire:model.lazy="type_demande">
                                       @error('type_demande') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="">Branche</label>
                                    <select name="branche" id="" class="form-control" wire:model.lazy="branche">
                                        <option value="" selected>Choisisez une branche</option>
                                        @forelse ($branches as $branche )
                                        <option value="{{$branche->id}}">{{$branche->nom}}</option>
                                        @empty
                                        <option value="Masculin">Pas de branche</option>
                                        @endforelse 
                                     

                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="">Corps Métier</label>
                                    <select name="corps" id="" class="form-control" wire:model.lazy="corps">
                                        <option value="" selected>Choisisez un corps de metier</option>
                                        @forelse ($corp as $corps )
                                        <option value="{{$corps->id}}">{{$corps->nom}}</option>
                                        @empty
                                        <option value="Masculin">Pas de corps de métier</option>
                                        @endforelse 
                                    </select>
                                    

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="">Metier</label>
                                    <select name="metier" id="" class="form-control" wire:model.lazy="metier">
                                        <option value="" selected>Choisisez un métier</option>
                                        @forelse ($metiers as $metier )
                                        <option value="{{$metier->id}}">{{$metier->nom}}</option>
                                        @empty
                                        <option value="Masculin">Pas de corps de métier</option>
                                        @endforelse 
                                    </select>
                                     

                                </div>
                            </div>

                            @elseif ($formStep == 2)


                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">Nom</label>
                                    <input type="text" name="nom" class="form-control" id=""
                                    wire:model.lazy="nom">
                                       @error('nom') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="">Prenom</label>
                                    <input type="text" class="form-control" name="prenom" id=""
                                    wire:model.lazy="prenom">
                                       @error('prenom') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="name" class="form-control" id=""
                                       wire:model.lazy="email">
                                       @error('email') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="">Sexe</label>
                                    <select name="sexe" id="" class="form-control" wire:model.lazy="sexe">
                                        <option value="" selected>Choisisez le sexe</option>
                                        <option value="Masculin">Masculin</option>
                                        <option value="Feminin">Féminin</option>

                                    </select>
                                       @error('sexe') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">IFU</label>
                                    <input type="text" name="ifu" class="form-control" id=""
                                       wire:model.lazy="ifu">
                                       @error('ifu') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="">Contact</label>
                                    <input type="number" class="form-control" name="contact" id=""
                                        wire:model.lazy="contact">
                                        @error('contact') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            @elseif ($formStep == 3)

                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">Titre de l'activité</label>
                                    <input type="text" name="titre_activite" class="form-control" id=""
                                        wire:model.lazy="titre_activite">
                                       @error('titre_activite') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="">Objectif de l'activité</label>
                                    <textarea class="form-control" name="obejectif_activite" id="" wire:model.lazy="obejectif_activite"></textarea>
                                       @error('obejectif_activite') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">Date debut </label>
                                    <input type="date" name="debut_activite" class="form-control" id=""
                                        wire:model.lazy="debut_activite">
                                       @error('debut_activite') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="">Date fin</label>
                                    <input type="date" class="form-control" name="fin_activite" id=""
                                        wire:model.lazy="fin_activite">
                                       @error('fin_activite') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">Durée </label>
                                    <input type="number" name="dure_activite" class="form-control" id=""
                                        wire:model.lazy="dure_activite">
                                       @error('dure_activite') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="">Département</label>
                                    <select name="departement" id="" class="form-control" wire:model.lazy="departement">
                                        <option value="" selected>Choisisez un département</option>
                                        @forelse ($departements as $departement )
                                        <option value="{{$departement->id}}">{{$departement->nom}}</option>
                                        @empty
                                        <option value="Masculin">Pas de département</option>
                                        @endforelse 
                                       
                                        

                                    </select>
                                       @error('departement') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">Commune </label>
                                    <select name="commune" id="" class="form-control" wire:model.lazy="commune">
                                        <option value="" selected>Choisisez une commune</option> 
                                        @forelse ($communes as $commune )
                                        <option value="{{$commune->id}}">{{$commune->nom}}</option>
                                        @empty
                                        <option value="Masculin">Pas de commune</option>
                                        @endforelse 

                                    </select>
                                       @error('commune') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="">Lieu d'exécution</label>
                                    <input type="text" class="form-control" name="lieux" id=""
                                        wire:model.lazy="lieux">
                                       @error('lieux') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">Nombre d'homme touché </label>
                                    <input type="number" class="form-control" name="homme_touche" id=""
                                        wire:model.lazy="homme_touche">
                                       @error('homme_touche') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">Nombre de femme touchée </label>
                                    <input type="number" class="form-control" name="femme_touche" id=""
                                       wire:model.lazy="femme_touche">
                                       @error('femme_touche') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">Budget Prévisionnel</label>
                                    <input type="number" class="form-control" name="budget" id=""
                                      wire:model.lazy="budget">
                                       @error('budget') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            @elseif ($formStep == 4)

                            <div class="row mb-2">
                                <div class="col-md-6 form-group">
                                    <label for="">Fichier</label>
                                    <input type="file" class="form-control" name="piece" id=""
                                       wire:model.lazy="piece">
                                       @error('piece') <span class="error text-danger">{{ $message }}</span> @enderror

                                </div>

                            </div>
                            @endif

                            @if ($formStep == 1)
                            <div class="text-center"><button type="submit" class="bg-success" wire:click="nextStep1">Suivant</button></div>

                            @elseif ($formStep == 2)
                            <div class="text-center">
                                <button type="submit" class="bg-primary" wire:click="prevStep">Précédent</button>
                                <button type="submit" class="bg-success" wire:click="nextStep2">Suivant</button>
                            </div>
                            @elseif ($formStep == 3)
                            <div class="text-center">
                                <button type="submit" class="bg-primary" wire:click="prevStep">Précédent</button>
                                <button type="submit" class="bg-success" wire:click="nextStep3">Suivant</button>
                            </div>
                            @elseif ($formStep == 4)
                            <div class="text-center">
                                <button type="submit" class="bg-primary" wire:click="prevStep">Précédent</button>
                                <button type="submit" class="bg-success" wire:click="store">Envoyer</button>
                            </div>

                            @endif





                        </form>

                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

       
    </main>

</div>