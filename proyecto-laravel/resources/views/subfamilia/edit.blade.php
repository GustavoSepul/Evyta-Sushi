@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Editar subcategoría</h2>
</div>

<form class="formulario-editar" action="{{ url('/subfamilia/'.$subfamilia->id) }}" method="post" enctype="multipart/form-data" class="col-9">
@csrf
{{ method_field('PATCH') }}

@include('subfamilia.form',['modo'=>'Editar'])

</form>


@endsection