@extends('Commun.Admin')
@section('contenu')
    @livewire('liste-demande')

    <script>
        window.addEventListener('fermer', event => {
           $('#suspendreModal').modal('hide');
          // $('#studentupdateModal').modal('hide');
        })
    </script>
@endsection