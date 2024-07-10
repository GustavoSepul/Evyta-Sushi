@extends('layouts.layout-admin')

@section('content')

<h1 class="mb-3">
  <div class="text-center">
    Registro de Roles
  </div>
</h1>


@canany(['Crear.rol','Editar.rol','Eliminar.rol'])
@can('Crear.rol')
<div class="text-right m-2"><a href="rol/create" class="btn btn-success">+ Nuevo rol</a></div>
@endcan
<div class="table-responsive">
<table id="myTable" class="table table-striped table-bordered w-100 shadow-sm" style="text-color:white;">
   <thead class="table">
       <tr>
            
           
           <th class="text-center datatables1" scope="col">Nombre</th>
           <th class="text-center datatables1"  scope="col" class="ml-5" >Opciones</th>
       </tr>
   </thead>
   <tbody>
       @foreach ($rols as $rol)  
       <tr>
            
            <td class="text-center datatables2">{{ $rol->name}}</td> 
            <td class="text-center datatables2"> 
                    
                    <form action="{{url('/rol/'.$rol->id)}}" method="post" style="" class="formulario-eliminar">
            
                    @csrf
                    {{method_field('DELETE')}}
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @can('Editar.rol')
                        <a class="btn bg-white text-white mt-2 datatables3" href="{{ url('/rol/'.$rol->id.'/edit')}}" role="button" ><i class="pr-1 mr-0" data-feather="edit" style="height:100%; width:100%;  color:black"></i></a>   
                        @endcan
                        @can('Eliminar.rol')
                        <button  class="btn bg-danger mt-2 datatables3" type="submit" onclick=""><i class="pr-1 mr-0" data-feather="trash-2" style="height:100%; width:100%;  color:black; "></i></button>
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
    #rol{
        background-color: rgb(18,19,23);
    }
    body.light #rol{
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
            'El rol se eliminó con éxito.',
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
        '¡Rol agregado con éxito!',
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
        text: "El rol seleccionado se eliminará definitivamente",
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