@extends('Commun.Client')
@section('contenu')
<main id="main">

    <section id="contact" class="contact">
        <div class="container">

            <div class="section-title mb-4">
                <h2>Suivez votre demande</h2>
            </div>

            <div class="row mt-1">


                <div class="col-lg- mt-5 mt-lg-0">

                    <form id="uploadForm" action="{{url('recherche_demande')}} " method="post" enctype="multipart/form-data">
                        @csrf
                      <!-- 2 column grid layout with text inputs for the first and last names -->
                      @if(session()->has('erreur'))
    
                      <div id="myAlert" class="alert alert-danger alert-dismissible fade show">
                          <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                          <strong>Erreur,</strong>  {{session()->get('erreur')}}
                          <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                          </button>
                      </div>
              
                      @endif
                    <div id="step1">
                        <div class="row-md-6 form-group mb-3 mt-md-0">
                            <label for="sevice">Service</label>
                            <select name="service" id="sevice" class="form-control" required>
                                <option value="" selected>Choisisez un service</option>
                                <option value="Assistance">Demande Assistance</option>
                                <option value="Formation">Demande Formation</option>
                                <option value="Financier">Appui Financier</option>
                            </select>
                       

                        </div>
                          
                          <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example3" style="font-weight: bold">Numero de demande</label>
                            <input type="search" id="form3Example3" name="code" class="form-control" style="font-weight: bold">
                            
                          </div>
                      <!-- Checkbox -->
                     
                      <!-- Submit button -->
                      <button type="submit" class="btn btn-primary next-step">Rechercher</button>
          
                      <!-- Register buttons -->
                      
                    </div>
    
    
    
                    
    
    
                    </form>

                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->


</main>
@endsection