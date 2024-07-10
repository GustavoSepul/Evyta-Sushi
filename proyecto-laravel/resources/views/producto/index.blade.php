@extends('layouts.layout-admin')

@section('content')

<h1 class="mb-3">
  <div class="text-center">
    Registro de Productos
  </div>
</h1>


@canany(['Ver.producto','Crear.producto','Editar.producto','Eliminar.producto'])
@if(Session::has('mensaje'))
<div class="alert alert-success alert-dismissible mt-2" role="alert">
    {{ Session::get('mensaje') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
@endif
<div class="text-right p-2">
    @can('Crear.producto')
    <a class="btn btn-success" href="{{route('producto.create')}}" role="button">+ Nuevo Producto</a>
    @endcan
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered w-100 shadow-sm" id="myTable" style="text-color:white;">
        <thead class="table">
            <tr>
                <th class="text-center datatables1">Nombre Producto</th>
                <th class="text-center datatables1">Disponibilidad</th>
                <th class="text-center datatables1">Descripción</th>
                <th class="text-center datatables1">Precio</th>
                <th class="text-center datatables1">Familia</th>
                <th class="text-center datatables1">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td class="text-center datatables2">{{$producto->nombre_producto}}</td>
                <td class="text-center datatables2">
                    @if ($producto->disponibilidad == 1)
                    Disponible
                    @endif
                    @if ($producto->disponibilidad == 0)
                    No disponible
                    @endif
                </td>
                <td class="text-center datatables2">{{$producto->descripcion}}</td>
                <td class="text-center datatables2">{{$producto->precio}}</td>
                <td class="text-center datatables2">{{$producto->nombre_familia}}</td>
                <td class="text-center datatables2">
                    {{-- <a class="btn bg-info mt-2" onClick="obtenerDatosProducto({{$producto->id}})"><i class="pr-1" data-feather="eye" style="height:100%; width:100%; color:black"></i></a> --}}
                    <form action="{{url('/producto/'.$producto->id)}}" method="post" class="formulario-eliminar">
                        @csrf
                        {{method_field('DELETE')}}
                        <div class="btn-group" role="group" aria-label="Basic example">
                            @can('Ver.producto')
                            <button type="button" class="btn btn-primary datatables3" data-toggle="modal" data-target="#exampleModalLong" onclick="obtenerDatosProducto({{$producto->id}})"><i class="pr-1" data-feather="eye" style="color:black"></i></button>
                            @endcan
                            @can('Editar.producto')
                            <a class="btn bg-white datatables3" href="{{url('/producto/'.$producto->id.'/edit')}}"><i class="pr-1" data-feather="edit" style="color:black;"></i></a>
                            @endcan
                            @can('Eliminar.producto')
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
<!-- <div class="d-none" id="divShow" style="width: 100%; height: 100%; position: fixed; top: 10px; left: 0px; z-index: 990;opacity: 0.8;background:#000;"> 
        <div class="text-right">
            <a class="text-white p-2 mt-2 mr-2" onClick="floatDiv()"><i class="" data-feather="x" style="color:white;"></i>Cerrar ventana</a>
        </div>
        <div class="text-center">
            <img src="" alt="">
        </div>
    </div> -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-dark" id="exampleModalLongTitle">Información del producto</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-dark text-center">
                <img id="imagenProducto" src="" alt="" style="height: 200px; weidth: 200px;"><br>
                <p id="nombreFamiliaProducto"></p><br>
                <div class="row m-0">
                    <div class="col-6" style="border-right: 1px solid;">
                        <h4>Subcategorías</h2>
                            <p id="subfamiliaProducto"></p>
                    </div>
                    <div class="col-6">
                        <h4>Tipos</h2>
                            <p id="tipoProducto"></p>
                    </div>
                    <div class="col-6" style="border-right: 1px solid;">
                        <h4>Locales</h2>
                            <p id="localProducto"></p>
                    </div>
                    <div class="col-6">
                        <h4>Ingredientes</h2>
                            <p id="ingredienteProducto"></p>
                    </div>
                </div>
                <h5 id="disponibilidadPrecioProducto"></h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    function obtenerDatosProducto($id_producto) {
        $.ajax({
            url: "{{ url('producto' )}}" + '/' + $id_producto,
            type: "GET",
            data: {
                // 
            },
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                //
            },
            success: function(data) {
                console.log(data)
                var subfamilia = "";
                var tipo = "";
                var local = "Disponible en: ";
                var ingrediente = "";
                var disponibilidadprecio = "$" + data.info[0].precio;
                if (data.info[0].imagen != "") {
                    $('#imagenProducto').attr("src", "{{ asset('storage').'/'}}" + data.info[0].imagen);
                } else {
                    $('#imagenProducto').attr("src", 'https://electroesencial.com/wp-content/themes/consultix/images/no-image-found-360x250.png');
                }
                $('#nombreFamiliaProducto').text(data.info[0].nombre_familia + ": " + data.info[0].nombre_producto);
                data.info.forEach(element => {
                    if (subfamilia.search(element.nombre_subfamilia) == -1) {
                        subfamilia += element.nombre_subfamilia + ", ";
                    }
                });
                $('#subfamiliaProducto').text(subfamilia.substring(0, subfamilia.length - 2) + ".");
                data.info.forEach(element => {
                    if (tipo.search(element.nombre_tipo) == -1) {
                        tipo += element.nombre_tipo + ", ";
                    }
                });
                $('#tipoProducto').text(tipo.substring(0, tipo.length - 2) + ".");
                data.info.forEach(element => {
                    if (local.search(element.nombre_local) == -1) {
                        local += element.nombre_local + ", ";
                    }
                });
                $('#localProducto').text(local.substring(0, local.length - 2) + ".");
                data.info.forEach(element => {
                    if (ingrediente.search(element.nombre_ingrediente) == -1) {
                        ingrediente += element.nombre_ingrediente + ", ";
                    }
                });
                $('#ingredienteProducto').text(ingrediente.substring(0, ingrediente.length - 2) + ".");
                if (data.info[0].disponibilidad == 1) {
                    disponibilidadprecio += " Disponible";
                } else {
                    disponibilidadprecio += " No Disponible";
                }
                $('#disponibilidadPrecioProducto').text(disponibilidadprecio);
            },
            error: function(lsakdfjnkasdfkjlsa) {
            }
        });
    }
</script>
<style>
    #producto {
        background-color: rgb(18, 19, 23);
    }

    body.light #producto {
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
        'El producto se eliminó con éxito.',
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
                '¡Producto agregado con éxito!',
                '',
                'success'
                )
        </script>

@endif
<script>
    $('.formulario-eliminar').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Estas seguro?',
            text: "El producto seleccionado se eliminará definitivamente",
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