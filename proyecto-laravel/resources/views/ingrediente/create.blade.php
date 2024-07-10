@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Creación nuevo ingrediente</h2>
</div>

@if(count($errors)>0)

<div class="container">

    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
               <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>

@endif

<form class="formulario-crear" action="{{url('ingrediente')}}" method="POST" class="col-9">
@csrf
<div class="mb-3" >
   <label for="" class="form-label">Nombre</label>
   <input id="nombre" name="nombre" type="text" class="form-control" tabindex="4" placeholder="Salmón">
</div>
{{-- <div class="mb-3" >
   <label for="" class="form-label">Cantidad de ingredientes</label>
   <input id="cantidad" name="cantidad" type="number" class="form-control" tabindex="5">
</div>
<div class="mb-3" >
   <label for="" class="form-label">Medida de los ingredientes (Kg, Lts, unidades)</label>
   <input id="medida" name="medida" type="number" class="form-control" tabindex="6"> 
</div> --}}

<button type="submit" class="btn btn-success" tabindex="8">Guardar</button> 
<a href="/ingrediente" class="btn btn-secondary" tabindex="9">Cancelar</a>
</form>
</div>

<style>
    #ingrediente{
        background-color: rgb(18,19,23);
    }
    body.light #ingrediente{
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
        title: '¿Estas seguro que quieres agregar un nuevo ingrediente?',
        showDenyButton: true,
        confirmButtonText: 'Sí, agregar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('El ingrediente no ha sido agregado', '', 'info')
        }
        })
        
    });
</script>
@endsection