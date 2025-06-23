@extends('Commun.Admin')
@section('contenu')
    @livewire('service', ['data' => $data])
    @livewireScripts
@endsection