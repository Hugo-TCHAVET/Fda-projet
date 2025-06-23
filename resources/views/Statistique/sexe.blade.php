@extends('Commun.Admin')
@section('contenu')
    @livewire('sexe', ['data' => $data])
    @livewireScripts
@endsection