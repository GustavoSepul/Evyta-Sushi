@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Creación nuevo permiso</h2>
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

<form class="formulario-crear" action="{{url('permiso')}}" method="POST" class="col-9">
    @csrf
    <div class="mb-3">
        <label  for="" class="form-label">Nombre</label>
        <input required placeholder="Acceder a productos" id="nombre" name="name" type="text" class="form-control" tabindex="4">
        <input required hidden name="guard_name" type="text" class="form-control" tabindex="-1" value="web">
    </div>

    <button type="submit" class="btn btn-success" tabindex="8">Guardar</button> 

    <a href="/permiso" class="btn btn-secondary" tabindex="9">Cancelar</a>
</form>

<style>
    #permiso{
        background-color: rgb(18,19,23);
    }
    body.light #permiso{
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
        title: '¿Estas seguro que quieres agregar un nuevo permiso?',
        showDenyButton: true,
        confirmButtonText: 'Sí, agregar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('El permiso no ha sido agregado', '', 'info')
        }
        })
        
    });
</script>

@endsection