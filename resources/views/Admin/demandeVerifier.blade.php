@extends('Commun.Admin')
@section('contenu')
    @livewire('demande-verifier')

    
    <script>
        window.addEventListener('fermer', event => {
           $('#ValiderModal').modal('hide');
          // $('#studentupdateModal').modal('hide');
        })
    </script>
@endsection