@extends('Commun.Admin')
@section('contenu')
    @livewire('demandeur', ['data' => $data])
    @livewireScripts
@endsection