@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
    <span class="mt-2"><h2>Creación nuevo rol</h2>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@if(count($errors)>0)

    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>

@endif    

<form class="formulario-crear" action="{{url('rol')}}" method="POST" class="col-9">
    @csrf
    <div class="mb-3">
        <label for="" class="form-label">Nombre</label>
        <input required placeholder="Administrador" id="nombre" name="name" type="text" class="form-control" tabindex="4"><br>
        <input required hidden value="web" name="guard_name" type="text" class="form-control" tabindex="-1">
        <label for="" class="form-label">Permisos</label>
        <select multiple="multiple" required class="form-control selectpicker" name="rol[]"></select>
    </div>

    <button type="submit" class="btn btn-success" tabindex="8">Guardar</button> 

    <a href="/rol" class="btn btn-secondary" tabindex="9">Cancelar</a>

</form>

<style>
    #rol{
        background-color: rgb(18,19,23);
    }
    body.light #rol{
        background-color: #cc3300;
    }
</style>

<script>
    window.onload = function(){
        var permiso = {!! json_encode($data['permisos']->toArray()) !!};
        $('.selectpicker').empty();
        $('.selectpicker').append($("<option/>", {value: '',text: ''}));
        for (i=0; i<permiso.length; i++) {
            $('.selectpicker').append($("<option/>", {
                value: permiso[i].id,
                text: permiso[i].name
            }));
        }
        $('.selectpicker').select2({
            'selectionCssClass' : 'form-control',
            'dropdownAutoWidth': true,
            'placeholder' : 'Seleccione',
        });
    };
</script>
@endsection

@section('js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>     
    $('.formulario-crear').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Estas seguro que quieres agregar un nuevo rol?',
        showDenyButton: true,
        confirmButtonText: 'Sí, agregar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('El rol no ha sido agregado', '', 'info')
        }
        })
        
    });
</script>

@endsection