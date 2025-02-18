@extends('layouts.layout-admin')

@section('content')
<h1 class="mb-3">
  <div class="text-center">
    Registro de Cupones
  </div>
</h1>


@canany(['Crear.cupon','Editar.cupon','Eliminar.cupon'])
@can('Crear.cupon')
<div class="row">
    <div class="col-6 my-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Recursos externos
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalLongTitle">Recursos externos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body text-dark divCupon">
                <form class="mb-2" action="{{route('descargarCupon')}}" method="get">
                    <span>Descargar plantilla: </span>
                    <button class="btn btn-success" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-excel-fill" viewBox="0 0 16 16">
                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM5.884 6.68 8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 1 1 .768-.64z"/>
                      </svg></button>
                </form>
                <span>Importar datos: </span>
                <form action="{{route('importarCupon')}}" method="post" id="importCupon">
                    <input multiple class="mb-2" type="file" name="plantillaCupon" id="plantillaCupon">
                </form>
                <form class="mb-2" action="{{route('exportarCupon')}}" method="get">
                    <span>Exportar datos: </span>
                    <button class="btn btn-success" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-excel-fill" viewBox="0 0 16 16">
                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM5.884 6.68 8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 1 1 .768-.64z"/>
                      </svg></button>
                      <button class="btn btn-danger" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                        <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                        <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                      </svg></button>
                      <button class="btn btn-secondary" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                      </svg></button>
                </form>
                </div>
                <div class="modal-footer">
                <button type="btn bg-danger" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-6 text-right my-2">
        <a href="cupon/create" class="btn btn-success">+ Nuevo cupón</a>
    </div>
</div>
@endcan
<div class="table-responsive">
<table id="myTable" class="table table-striped table-bordered w-100 shadow-sm" style="text-color:white;">
   <thead class="table">
       <tr>
           
           
           <th class="text-center datatables1" scope="col">Nombre</th>
           <th class="text-center datatables1" scope="col">Codigo</th>
           <th class="text-center datatables1" scope="col">Descuento</th>
           <th class="text-center datatables1" scope="col">Descripcion</th>
           <th class="text-center datatables1" scope="col">Fecha_inicio</th>
           <th class="text-center datatables1" scope="col">Fecha_final</th>
           <th class="text-center datatables1" scope="col" class="">Opciones</th>
       </tr>
   </thead>
   <tbody>
       @foreach ($cupons as $cupon)  
       <tr>
            
           
            <td class="text-center datatables2">{{ $cupon->nombre}}</td> 
            <td class="text-center datatables2">{{ $cupon->codigo}}</td>   
            <td class="text-center datatables2">{{ $cupon->descuento}}</td> 
            <td class="text-center datatables2">{{ $cupon->descripcion}}</td> 
            <td class="text-center datatables2">{{ $cupon->fecha_inicio}}</td> 
            <td class="text-center datatables2">{{ $cupon->fecha_final}}</td>  
            <td class="text-center datatables2"> 
    
            <div class="row m-0">
                
            
                <form action="{{url('/cupon/'.$cupon->id)}}" method="post" class="formulario-eliminar">
                
                    @csrf
                    {{method_field('DELETE')}}
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @can('Editar.cupon')
                        <a class="btn bg-white text-white mt-2 datatables3" href="{{ url('/cupon/'.$cupon->id.'/edit')}}" role="button" ><i class="pr-1 mr-0" data-feather="edit" style="height:100%; width:100%; color:black"></i></a>  
                        @endcan
                        @can('Eliminar.cupon')
                        <button  class="btn bg-danger mt-2 datatables3" type="submit" onclick=""><i class="pr-1 mr-0" data-feather="trash-2" style="height:100%; width:100%; color:black"></i></button>
                        @endcan
                    </div>
                </form>

            </div>
                
            </td>
              
       </tr>
       
       @endforeach
   </tbody>
</table>
</div>
<style>
    #cupon{
        background-color: rgb(18,19,23);
    }
    body.light #cupon{
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
            'El cupón se eliminó con éxito.',
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
        '¡Cupon agregado con éxito!',
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
        text: "El cupón seleccionado se eliminará definitivamente",
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