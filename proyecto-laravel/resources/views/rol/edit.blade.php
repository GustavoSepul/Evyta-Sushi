@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Editar rol</h2>
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

    <form class="formulario-editar" action="{{url('/rol/'.$rol->id)}}" method="POST" class="col-9">
        @csrf
        {{method_field('PATCH')}}
        <div class="mb-3">
            <label for="" class="form-label">Nombre</label>
            <input id="nombre" name="name" type="text" class="form-control" value="{{$rol->name}}" tabindex="4"><br>
            <label for="" class="form-label">Permisos</label><br>
            <select multiple="multiple" required class="form-control selectpicker" name="rolEdit[]"></select>
        </div>

        <button type="submit" class="btn btn-success" tabindex="9">Guardar</button> 

        <a href="/rol" class="btn btn-secondary" tabindex="8">Cancelar</a>
        
    </form>

    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('select2.css')}}">
    <link rel="stylesheet" href="{{asset('select2-bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap')}}">

    <style>
    #rol{
        background-color: rgb(18,19,23);
    }
    body.light #rol{
        background-color: #cc3300;
    }
    </style>

    <script>
        var permiso = {!! json_encode($permisos) !!};
        var allPermiso = {!! json_encode($allPermisos->toArray()) !!};
        for (j=0; j<permiso.length; j++) {
            $('.selectpicker').append($("<option/>", {
                value: permiso[j].id,
                text: permiso[j].name,
                selected: true
            }));
        }
        for (i=0; i<allPermiso.length; i++) {
            var flag = false;
            for(j=0; j<permiso.length; j++){
                if(allPermiso[i].id == permiso[j].id) flag = true;
            }
            if(!flag){
                $('.selectpicker').append($("<option/>", {
                    value: allPermiso[i].id,
                    text: allPermiso[i].name
                }));
            }
        }
        $('.selectpicker').select2({
            'selectionCssClass' : 'form-control',
            'dropdownAutoWidth': true,
        });
    </script>

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