@extends('layouts.layout-admin')

@section('content')

<h1 class="mb-3">
  <div class="text-center">
    Registro de Subcategorías
  </div>
</h1>


@canany(['Crear.subfamilia','Editar.subfamilia','Eliminar.subfamilia'])
@can('Crear.subfamilia')
<div class="text-right"><a href="{{ url('subfamilia/create') }}" class="btn btn-success">+ Nueva subcategoría</a></div><br>
@endcan
    <div class="table-responsive">
        <table class="table table-striped table-bordered w-100 shadow-sm" id="myTable" style="text-color:white;">
            <thead class="table-dark">
                <tr>
                    <th class="text-center datatables1">#</th>
                    <th class="text-center datatables1">Nombre</th>
                    <th class="text-center datatables1">Opciones</th>
                </tr>
        
            </thead>
            <tbody>
                @foreach( $datos['subfamilia'] as $subfamilia )
                <tr>
                    <td class="text-center datatables2">{{ $subfamilia->id }}</td>
                    <td class="text-center datatables2">{{ $subfamilia->nombre }}</td>
                    <td class="text-center datatables2">
                        <form action="{{ url('/subfamilia/'.$subfamilia->id ) }}" class="d-inline formulario-eliminar" method="post">
                            @csrf
                            {{ method_field('DELETE') }}
                            <div class="btn-group" role="group" aria-label="Basic example">
                                @can('Editar.subfamilia')
                                <a href="{{ url('/subfamilia/'.$subfamilia->id.'/edit') }}" class="btn bg-white datatables3"><i class="pr-1" data-feather="edit" style="color:black;"></i></a>
                                @endcan
                                @can('Eliminar.subfamilia')
                                <button class="btn bg-danger datatables3" type="submit" onclick=""><i class="pr-1 mr-0" data-feather="trash-2" style="color:black;"></i></button>
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
<style>
    #subfamilia{
        background-color: rgb(18,19,23);
    }
    body.light #subfamilia{
        background-color: #cc3300;
    }
</style>
@endsection

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('eliminar') == 'ok')

        <script>
            Swal.fire(
            '¡Eliminada!',
            'La subcategoría se eliminó con éxito.',
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
                '¡Sucategoría agregada con éxito!',
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
        text: "La subcategoría seleccionada se eliminará definitivamente",
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