@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
    <span class="mt-2"><h2>Creación nuevo tipo de producto</h2>
</div>


<form class="formulario-crear" action="{{ url('/tipo') }}" method="post" enctype="multipart/form-data" class="col-9">
@csrf


@include('tipo.form',['modo'=>'Crear'])

</form>


@endsection