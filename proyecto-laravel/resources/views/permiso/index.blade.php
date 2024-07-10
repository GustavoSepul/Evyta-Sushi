@extends('layouts.layout-admin')

@section('content')

<h1 class="mb-3">
  <div class="text-center">
    Registro de Permisos
  </div>
</h1>


@canany(['Crear.permiso','Editar.permiso','Eliminar.permiso'])
@can('Crear.permiso')
<div class="text-right m-2"><a href="permiso/create" class="btn btn-success">+ Nuevo permiso</a></div>
@endcan
<div class="table-responsive">
<table id="myTable" class="table table-striped table-bordered w-100 shadow-sm" style="text-color:white;">
   <thead class="table-dark">
       <tr>
            
           
           <th class="text-center datatables1"scope="col">Nombre</th>
           <th class="text-center datatables1" scope="col" class="ml-5" >Opciones</th>
       </tr>
   </thead>
   <tbody>
       @foreach ($permisos as $permiso)  
       <tr>
            
            <td class="text-center datatables2">{{ $permiso->name}}</td> 
            <td class="text-center datatables2"> 

                
            
                <form action="{{url('/permiso/'.$permiso->id)}}"class="formulario-eliminar" method="post" style="" >
                
                    @csrf
                    {{method_field('DELETE')}}
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @can('Editar.permiso')
                        <a class="btn bg-white text-white mt-2 datatables3" href="{{ url('/permiso/'.$permiso->id.'/edit')}}" role="button" ><i class="pr-1 mr-0" data-feather="edit" style="height:100%; width:100%; color:black"></i></a>
                        @endcan
                        @can('Eliminar.permiso')
                        <button  class="btn bg-danger mt-2 datatables3" type="submit" onclick=""><i class="pr-1 mr-0" data-feather="trash-2" style="height:100%; width:100%; color:black"></i></button>
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

@if(session('eliminar') == 'ok')

        <script>
            Swal.fire(
            '¡Eliminado!',
            'El permiso se eliminó con éxito.',
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
        '¡Permiso agregado con éxito!',
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
        text: "El permiso seleccionado se eliminará definitivamente",
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