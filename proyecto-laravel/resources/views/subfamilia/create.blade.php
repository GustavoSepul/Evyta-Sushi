@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Creación nueva subcategoría</h2>
</div>


<form action="{{ url('/subfamilia') }}" class="formulario-crear" method="post" enctype="multipart/form-data" class="col-9">
@csrf


@include('subfamilia.form',['modo'=>'Crear'])

</form>

@endsection