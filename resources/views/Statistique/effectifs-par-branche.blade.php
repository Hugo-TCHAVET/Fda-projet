@extends('Commun.Admin')
@section('contenu')
@livewire('effectifs-par-branche', ['data' => $data])
@livewireScripts
@endsection