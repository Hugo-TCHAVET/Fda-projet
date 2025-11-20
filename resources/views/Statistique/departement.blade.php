@extends('Commun.Admin')
@section('contenu')
    @livewire('departement', ['data' => $data])
    @livewireScripts
@endsection