@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
    <span class="mt-2"><h2>Editar cupón</h2>
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
            
<form class="formulario-editar" action="{{url('/cupon/'.$cupon->id)}}" method="POST" class="col-9 ">
    @csrf
    {{method_field('PATCH')}}
    <div class="mb-3">
        <label for="" class="form-label">Nombre</label>
        <input id="nombre" name="nombre" type="text" class="form-control" value="{{$cupon->nombre}}" tabindex="4">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Código</label>
        <input id="codigo" name="codigo" type="text" maxlength="15" class="form-control" value="{{$cupon->codigo}}" tabindex="5">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Descuento</label>
        <input id="descuento" name="descuento" type="number" min="1" max="100" class="form-control" value="{{$cupon->descuento}}" tabindex="6">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Descripción</label>
        <input id="descripcion" name="descripcion" type="text" class="form-control" value="{{$cupon->descripcion}}" tabindex="7">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Fecha_inicio</label>
        <input id="fecha_inicio" name="fecha_inicio" type="date" class="form-control" value="{{$cupon->fecha_inicio}}" tabindex="2">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Fecha_final</label>
        <input id="fecha_final" name="fecha_final" type="date" class="form-control" value="{{$cupon->fecha_final}}" tabindex="3">
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
    $('.formulario-editar').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Quieres guardar los cambios?',
        showDenyButton: true,
        confirmButtonText: 'Guardar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('Los cambios no han sido guardados', '', 'info')
        }
        })
        
    });
</script>

@endsection