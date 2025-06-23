@extends('Commun.Client')
@section('contenu')
     
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Contactez-nous</h2>
      </div>

      <div class="row mt-1">

        <div class="col-lg-4">
          <div class="info">
            <div class="address">
              <i class="bi bi-geo-alt"></i>
              <h4>Adresse:</h4>
              <p>ZONGO EHUZU, Parcelle n°124563F, Rue n°5100, Porte n°37 Cotonou, Bénin, Cotonou</p>
            </div>

            <div class="email">
              <i class="bi bi-envelope"></i>
              <h4>Email:</h4>
              <p>fda@gmail.com</p>
            </div>

            <div class="phone">
              <i class="bi bi-phone"></i>
              <h4>Tel :</h4>
              <p>+229 21 31 30 01</p>
            </div>

          </div>

        </div>

        <div class="col-lg-8 mt-5 mt-lg-0">
            
            
          <form action="{{ route('contact.submit') }}" method="post" role="form" >
            @csrf
            <div class="row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Votre nom" required>
              </div>
              <div class="col-md-6 form-group mt-3 mt-md-0">
                <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email" required>
              </div>
            </div>
            <div class="form-group mt-3">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="sujet" required>
            </div>
            <div class="form-group mt-3">
              <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
            </div>
            
            <div class="text-center rounded mt-4"><button type="submit" class="btn btn-primary">Envoyer le message</button></div>
          </form>

        </div>

      </div>

    </div>
</section>
@endsection