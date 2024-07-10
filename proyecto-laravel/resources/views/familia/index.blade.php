@extends('layouts.layout-admin')

@section('content')
<h1 class="mb-3">
  <div class="text-center">
    Registro de Categorías
  </div>
</h1>


@canany(['Crear.familia','Editar.familia','Eliminar.familia'])
    @can('Crear.familia')
    <div class="text-right"><a href="{{ url('familia/create') }}" class="btn btn-success">+ Nueva categoría</a></div><br>
    @endcan
        <table class="table table-striped table-bordered w-100 shadow-sm" id="myTable" style="text-color:white;">
            <thead>
                <tr>
                    <th class="text-center datatables1" >#</th>
                    <th class="text-center datatables1" >Nombre</th>
                    <th class="text-center datatables1" >Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $datos['familia'] as $familia )
                <tr>
                    <td class="text-center datatables2">{{ $familia->id }}</td>
                    <td class="text-center datatables2">{{ $familia->nombre }}</td>
                    <td class="text-center datatables2">
                        <form action="{{url('/familia/'.$familia->id)}}" class="formulario-eliminar" method="post" style="" >
                            @csrf
                            {{method_field('DELETE')}}
                            <div class="btn-group" role="group" aria-label="Basic example">
                                @can('Editar.familia')
                                <a class="btn bg-white text-white mt-2 datatables3" href="{{ url('/familia/'.$familia->id.'/edit')}}" role="button" ><i class="pr-1 mr-0" data-feather="edit" style="height:100%; width:100%; color:black"></i></a>   
                                @endcan
                                @can('Eliminar.familia')
                                <button  class="btn bg-danger mt-2 datatables3" type="submit" onclick=""><i class="pr-1 mr-0" data-feather="trash-2" style="height:100%; width:100%; color:black; "></i></button>
                                @endcan
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <style>
        #familia{
            background-color: rgb(18,19,23);
        }
        body.light #familia{
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
            'La categoría se eliminó con éxito.',
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
                '¡Categoría agregada con éxito!',
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
        text: "La categoría seleccionada se eliminará definitivamente",
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