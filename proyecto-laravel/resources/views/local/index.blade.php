@extends('layouts.layout-admin')

@section('content')

<h1 class="mb-3">
  <div class="text-center">
    Registro de Locales
  </div>
</h1>


@canany(['Crear.local','Editar.local','Eliminar.local'])
<div class="p-2 text-right">
    @can('Crear.local')
    <a href="local/create" class="btn btn-success">+ Nuevo Local</a>
    @endcan
</div>
<div class="table-responsive col-12">
<table id="myTable" class="table table-striped table-bordered w-100 shadow-sm" style="text-color:white;">
   <thead>
       <tr>
            <th class="text-center datatables1" style="" scope="col">Nombre</th>          
            <th class="text-center datatables1" style="" scope="col">Direccion </th>
            <th class="text-center datatables1" style="" scope="col">Celular</th>
            <th class="text-center datatables1" style="" scope="col">Apertura</th>
            <th class="text-center datatables1" style="" scope="col">Cierre</th>
            <th class="text-center datatables1" style="" scope="col">Estado</th>
            <th class="text-center datatables1" style="" scope="col" class="ml-5" >Opciones</th>
       </tr>
   </thead>
   <tbody>
       @foreach ($locals as $local)  
       <tr>
            
            <td class="text-center datatables2" style="">{{ $local->nombre}}</td> 
            <td class="text-center datatables2" style="">{{ $local->direccion}}</td>  
            <td class="text-center datatables2" style="">{{ $local->celular}}</td>
            <td class="text-center datatables2" style="">{{ $local->horario_a}}</td>  
            <td class="text-center datatables2" style="">{{ $local->horario_c}}</td>
            <td class="text-center datatables2" style="">                    
                    @if ($local->abierto == 1)
                    Abierto
                    @endif
                    @if ($local->abierto == 0)
                    Cerrado
                    @endif</td>       
            
            <td class="text-center datatables2" style=""> 
            <form action="{{url('/local/'.$local->id)}}" method="post" class="formulario-eliminar" >
            
                @csrf
                {{method_field('DELETE')}}
                <div class="btn-group" role="group" aria-label="Basic example">
                    @can('Editar.local')
                    <a class="btn bg-white text-white mt-2 datatables3" href="{{ url('/local/'.$local->id.'/edit')}}" role="button" ><i class="pr-1 mr-0" data-feather="edit" style="height:100%; width:100%; color:black"></i></a>   
                    @endcan
                    @can('Eliminar.local')
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
    #local{
        background-color: rgb(18,19,23);
    }
    body.light #local{
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
            'El local se eliminó con éxito.',
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
        '¡Local agregado con éxito!',
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
        text: "El local seleccionado se eliminará definitivamente",
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