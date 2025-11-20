@extends('Commun.Client')
@section('contenu')
<section id="resume" class="resume">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Resultat de votre demande</h2>
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
      </div>

      
        
        @if ($demande->status != null &&  $demande->statut != null &&  $demande->statuts != null )
            
        
        <div class="row">
           
            <div class="resume-item">
                <h4>{{$demande->statuts}}</h4>
                <h5>{{$demande->updated_at->locale('fr_FR')->isoFormat(' D MMMM YYYY à H:m:s')}}</h5>
              <p><em>Rochester Institute of Technology, Rochester, NY</em></p>
              <p>Qui deserunt veniam. Et sed aliquam labore tempore sed quisquam iusto autem sit. Ea vero voluptatum qui ut dignissimos deleniti nerada porti sand markend</p>
            </div>
            <div class="resume-item">
                <h4>{{$demande->statut}}</h4>
              
              <p><em>Rochester Institute of Technology, Rochester, NY</em></p>
              <p>Quia nobis sequi est occaecati aut. Repudiandae et iusto quae reiciendis et quis Eius vel ratione eius unde vitae rerum voluptates asperiores voluptatem Earum molestiae consequatur neque etlon sader mart dila</p>
            </div>
            <div class="resume-item">
              <h4>{{$demande->status}}</h4>
              <h5>{{$demande->created_at->locale('fr_FR')->isoFormat(' D MMMM YYYY à H:m:s') }}</h5>
              <p><em>Rochester Institute of Technology, Rochester, NY</em></p>
              <p>Quia nobis sequi est occaecati aut. Repudiandae et iusto quae reiciendis et quis Eius vel ratione eius unde vitae rerum voluptates asperiores voluptatem Earum molestiae consequatur neque etlon sader mart dila</p>
            </div>
          </div>



        @elseif ($demande->status != null &&  $demande->statut != null &&  $demande->statuts == null)


            
        <div class="row">
          
            
            <div class="resume-item">
                <h4>{{$demande->statut}}</h4>
                <h5>{{$demande->updated_at->locale('fr_FR')->isoFormat(' D MMMM YYYY à H:m:s') }}</h5>
              <p><em>Rochester Institute of Technology, Rochester, NY</em></p>
              <p>Quia nobis sequi est occaecati aut. Repudiandae et iusto quae reiciendis et quis Eius vel ratione eius unde vitae rerum voluptates asperiores voluptatem Earum molestiae consequatur neque etlon sader mart dila</p>
            </div>
            <div class="resume-item">
              <h4>{{$demande->status}}</h4>
              <h5>{{$demande->created_at->locale('fr_FR')->isoFormat(' D MMMM YYYY à H:m:s') }}</h5>
              <p><em>Rochester Institute of Technology, Rochester, NY</em></p>
              <p>Quia nobis sequi est occaecati aut. Repudiandae et iusto quae reiciendis et quis Eius vel ratione eius unde vitae rerum voluptates asperiores voluptatem Earum molestiae consequatur neque etlon sader mart dila</p>
            </div>
          </div>


          @elseif ($demande->status != null &&  $demande->statut == null &&  $demande->statuts == null)


          <div class="row">
          
            <div class="resume-item">
              <h4>{{$demande->status}}</h4>
              <h5>{{$demande->created_at->locale('fr_FR')->isoFormat(' D MMMM YYYY à H:m:s') }}</h5>
              <p><em>Rochester Institute of Technology, Rochester, NY</em></p>
              <p>Quia nobis sequi est occaecati aut. Repudiandae et iusto quae reiciendis et quis Eius vel ratione eius unde vitae rerum voluptates asperiores voluptatem Earum molestiae consequatur neque etlon sader mart dila</p>
            </div>
          </div>

        @endif

        <!-- <div class="text-center mt-4">
          @if(isset($demande->message) && strtolower(trim($demande->message)) !== 'null')
            <a href="{{ route('demande.modifier', $demande->id) }}" class="btn btn-warning" style="font-weight: bold">
              Modifier ma demande
            </a>
          @endif
        </div> -->

      </div>

    </div>
  </section><!-- End Resume Section -->


  
@endsection