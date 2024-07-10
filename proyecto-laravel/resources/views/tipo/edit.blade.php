@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Editar tipo de producto</h2>
</div>

<form class="formulario-editar" action="{{ url('/tipo/'.$tipo->id) }}" method="post" enctype="multipart/form-data" class="col-9">
@csrf
{{ method_field('PATCH') }}

@include('tipo.form',['modo'=>'Editar'])

</form>


@endsection