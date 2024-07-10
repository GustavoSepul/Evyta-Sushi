@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Editar ingrediente</h2>
</div>

<form class="formulario-editar" action="{{ url('/ingrediente/'.$ingrediente->id) }}" method="post" enctype="multipart/form-data" class="col-9">
@csrf
{{ method_field('PATCH') }}

@include('ingrediente.form',['modo'=>'Editar'])

</form>


@endsection
