@extends('layouts.layout-admin')

@section('content')

<h1 class="mb-3">
  <div class="text-center">
    Registro de Usuarios
  </div>
</h1>


@canany(['Crear.usuario','Editar.usuario','Eliminar.usuario'])
@can('Crear.usuario')
<div class="text-right"><a href="{{ url('users/create') }}" class="btn btn-success">+ Nuevo usuario</a></div>
@endcan
<br>
<div class="table-responsive">
    <table class="table table-striped table-bordered w-100 shadow-sm" id="myTable" style="text-color:white;">
    
        <thead class="table-dark">
            <tr>
                <th class="text-center datatables1" >Imagen</th>
                <th class="text-center datatables1" >Nombre</th>
                <th class="text-center datatables1" >Rut</th>
                <th class="text-center datatables1" >Correo</th>
                <th class="text-center datatables1" >Dirección</th>
                <th class="text-center datatables1" >Celular</th>
                <th class="text-center datatables1" >Teléfono</th>
                <th class="text-center datatables1" >Rol</th>
                <th class="text-center datatables1" >Acciones</th>
            </tr>
    
        </thead>
    
        <tbody>
            @foreach( $datosrol['users'] as $user )
            <tr>
            <td class="text-center datatables2">
                @if(isset($user->imagen))
                <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$user->imagen }}" width="100" alt="">
                @else
                <img class="img-thumbnail img-fluid" src="https://upload.wikimedia.org/wikipedia/commons/0/09/Man_Silhouette.png" alt="" width="100">
                @endif
                </td>
                <td class="text-center align-middle datatables2" >{{ $user->name }}</td>
                <td class="text-center align-middle datatables2" >{{ $user->rut }}</td>
                <td class="text-center align-middle datatables2" >{{ $user->email }}</td>
                <td class="text-center align-middle datatables2" >{{ $user->direccion }}</td>
                <td class="text-center align-middle datatables2" >{{ $user->celular }}</td>
                <td class="text-center align-middle datatables2" >{{ $user->telefono }}</td>
                <td class="text-center align-middle datatables2" >{{ $user->getRoleNames()->first() }}</td>
                
                <td class="text-center align-middle datatables2">
                    
                    

                    <form action="{{url('/users/'.$user->id)}}" method="post" style="" class="formulario-eliminar">
            
                    @csrf
                    {{method_field('DELETE')}}
                    <div class="btn-group text-center" role="group" aria-label="Basic example">
                    @can('Editar.usuario')
                    <a class="btn bg-white text-white mt-2 btn-sm datatables3" href="{{ url('/users/'.$user->id.'/edit')}}" role="button" ><i class="pr-1 mr-0" data-feather="edit" style="  color:black"></i></a>   
                    @endcan
                    @can('Eliminar.usuario')
                    <button  class="btn bg-danger mt-2 btn-sm datatables3" type="submit" onclick=""><i class="pr-1 mr-0" data-feather="trash-2" style="  color:black; "></i></button>
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
        #usuario{
            background-color: rgb(18,19,23);
        }
        body.light #usuario{
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
            'El usuario se eliminó con éxito.',
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
                '¡Usuario agregado con éxito!',
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
        text: "El usuario seleccionado se eliminará definitivamente",
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