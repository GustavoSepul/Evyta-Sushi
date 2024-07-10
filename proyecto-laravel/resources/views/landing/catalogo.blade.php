@extends('layouts.layout-landing')

@section('content')
@livewireStyles
    @livewire('buscador');
    @livewireScripts
    <style>
    #catalogo{
        background-color: #cc3300;
        transform: translateY(-3px);
        box-shadow: 0 4px 17px rgba(0, 0, 0, 0.35);
    }
    </style>
@endsection