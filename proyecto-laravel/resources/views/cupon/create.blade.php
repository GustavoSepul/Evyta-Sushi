@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
    <span class="mt-2"><h2>Creación nuevo cupón</h2>
</div>

@if(count($errors)>0)

<div class="alert alert-danger" role="alert">
    <ul>
        @foreach($errors->all() as $error)
           <li> {{ $error }} </li>
        @endforeach
    </ul>
</div>

@endif

<form class="formulario-crear" action="{{url('/cupon')}}" method="POST" class="col-9">
    @csrf
    <div class="mb-3">
        <label for="" class="form-label">Nombre</label>
        <input required placeholder="DESCUENTO PRIMERA COMPRA" id="nombre" name="nombre" type="text" class="form-control" tabindex="4">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Código</label>
        <input required placeholder="DSCTCOMPRA1" id="codigo" name="codigo" type="text" maxlength="15" class="form-control" tabindex="5">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Descuento</label>
        <input required placeholder="10" id="descuento" name="descuento" type="number" min="1" max="100" class="form-control" tabindex="6">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Descripción</label>
        <input required placeholder="Descuento de primera compra por registrarse" id="descripcion" name="descripcion" type="text" class="form-control" tabindex="7">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Fecha Inicio</label>
        <input  id="fecha_inicio" name="fecha_inicio" type="date" class="form-control" value="{{$carbon}}" tabindex="2">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Fecha Final</label>
        <input  id="fecha_final" name="fecha_final" type="date" class="form-control" value="{{$carbon}}" tabindex="3">
    </div>

    <button type="submit" class="btn btn-success" tabindex="8">Guardar</button>

    <a href="/cupon" class="btn btn-secondary" tabindex="9">Cancelar</a>

</form>

<style>
    #cupon{
        background-color: rgb(18,19,23);
    }
    body.light #cupon{
        background-color: #cc3300;
    }
</style>

@endsection

@section('js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>     
    $('.formulario-crear').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Estas seguro que quieres agregar un nuevo cupon?',
        showDenyButton: true,
        confirmButtonText: 'Sí, agregar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('El cupon no ha sido agregado', '', 'info')
        }
        })
        
    });
</script>

@endsection