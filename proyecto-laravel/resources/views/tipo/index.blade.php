@extends('layouts.layout-admin')

@section('content')

<h1 class="mb-3">
  <div class="text-center">
    Registro de Tipos de Productos
  </div>
</h1>

@canany(['Crear.tipo','Editar.tipo','Eliminar.tipo'])
@can('Crear.tipo')
<div class="text-right"><a href="{{ url('tipo/create') }}" class="btn btn-success">+ Nuevo tipo</a></div><br>
@endcan
<div class="table-responsive">
    <table class="table table-striped table-bordered w-100 shadow-sm" id="myTable" style="text-color:white;">
    
        <thead class="table">
            <tr>
                <th class="text-center datatables1">#</th>
                <th class="text-center datatables1">Nombre</th>
                <th class="text-center datatables1">Opciones</th>
            </tr>
    
        </thead>
    
        <tbody>
            @foreach( $datos['tipo'] as $tipo )
            <tr>
                <td class="text-center datatables2">{{ $tipo->id }}</td>
                <td class="text-center datatables2">{{ $tipo->nombre }}</td>
                <td class="text-center datatables2">
    
    
                <form action="{{ url('/tipo/'.$tipo->id ) }}" class="d-inline formulario-eliminar" method="post">
                @csrf
                {{ method_field('DELETE') }}
                <div class="btn-group" role="group" aria-label="Basic example">
                    @can('Editar.tipo')
                    <a href="{{ url('/tipo/'.$tipo->id.'/edit') }}" class="btn  bg-white text-white datatables3"><i class="pr-1 mr-0" data-feather="edit" style="height:100%; width:100%; color:black"></i></a>
                    @endcan
                    @can('Eliminar.tipo')
                    <button type="submit" class="btn btn-danger datatables3" onclick="" value="Borrar"><i class="pr-1 mr-0" data-feather="trash-2" style="height:100%; width:100%; color:black"></i></button>
                    @endcan
                </div>
                </form>
    
                </td>
            </tr>
            @endforeach
        </tbody>
    
    </table>
</div>
</div>
<script>
        $(document).ready( function () {
    $('#myTable').DataTable();
} );
    </script>
    <style>
        #tipo{
            background-color: rgb(18,19,23);
        }
        body.light #tipo{
        background-color: #cc3300;
    }
    </style>
@endsection

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('eliminar') == 'ok')

        <script>
            Swal.fire(
            '¡Eliminado!',
            'El tipo se eliminó con éxito.',
            'success'
            )
        </script>

@endif

@if(session('editar') == 'ok')

        <script>
            Swal.fire(
                '¡Cambios Guardados!',
                '',
                'success'
                )
        </script>

@endif

@if(session('crear') == 'ok')

        <script>
            Swal.fire(
                '¡Tipo agregado con éxito!',
                '',
                'success'
                )
        </script>

@endif
<script>

    $('.formulario-eliminar').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Estas seguro?',
        text: "El tipo seleccionado se eliminará definitivamente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, eliminar!',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
        })
    });

    
</script>
@endcan
@endsection