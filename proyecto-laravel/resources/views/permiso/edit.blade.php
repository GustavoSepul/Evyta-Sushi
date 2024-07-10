@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Editar permiso</h2>
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
        

<form class="formulario-editar" action="{{url('/permiso/'.$permiso->id)}}" method="POST" class="col-9">
    @csrf
    {{method_field('PATCH')}}
    <div class="mb-3">
        <label for="" class="form-label">Nombre</label>
        <input id="nombre" name="name" type="text" class="form-control" value="{{$permiso->name}}" tabindex="4">
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