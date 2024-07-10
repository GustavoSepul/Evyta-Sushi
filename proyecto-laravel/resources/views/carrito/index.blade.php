@extends('layouts.layout-landing')

@section('content')
<div class="row m-0">
    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-4">
        <span class="d-flex h3">Carrito de compras</span><br>
        <span class="d-flex">Selecciona un tipo de entrega:</span><br>
        <div class="card" style="cursor: pointer;" type="submit" data-toggle="modal" data-target="#elegir_local2" id='div-forma-pago'>
            <div class="card-body">
                <h5 class="card-title"><i data-feather="home" style=" width:35px; color:black; position: relative; bottom: 3px;"></i>Retiro en local</h5>
                <p class="card-text">Compra y retira tus productos en nuestro local sin costo adicional.</p>
                <span class="strong font-weight-bold">Continuar con retiro ></span>
            </div>
        </div>
        <div class="card" style="cursor: pointer;" class="m-3" data-toggle="modal" data-target="#elegir_local" id='div-forma-pago'>
            <div class="card-body">
                <h5 class="card-title"><i data-feather="truck" style=" width:35px; color:black ;position: relative; bottom: 3px;"></i>Entrega a domicilio</h5>
                <p class="card-text">Ingresa tu dirección y recibe donde quieras tu pedido.</p>
                <span class="strong font-weight-bold">Continuar con despacho ></span>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-4">
        <span class="d-flex h3">Resumen de compra</span><hr>
        <div class="overflow-auto" style="width:100%; height:550px; overflow-y: auto;">
            @foreach($productos as $producto)
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="card-title">{{$producto->nombre}}</h5>
                            <p class="card-text">{{$producto->descripcion}}</p>
                        </div>
                        <div class="col-6 text-right">
                            <h5 class="card-title">{{$producto->cantidad}} x  {{$producto->precio}}</h5>
                            <input style="width:20%; display: inline-block !important;" class="form-control" type="number" min="1" value="1" id="{{$producto->precio.$producto->id}}">
                            <a href="{{url('carrito')}}" class="btn btn-danger text-white" onclick="eliminardelcarrito({{$producto->precio.$producto->id}},{{$producto->id}})">eliminar producto</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <hr><span><strong>Subtotal</strong>: ${{$productos[0]->subtotal}}</span>
        <hr><span><strong>Total a pagar</strong>: ${{$productos[0]->total}}</span>
    </div>
</div>
<div class="modal fade" id="elegir_local" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selección de local</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('ingresadireccion')}}" method="post">
                <div class="modal-body">
                    @csrf
                    <span>Seleccione su local más cercano</span>
                    <select name="local" class="form-control">
                        @foreach($locales as $local)
                            <option value="{{$local->id}}">{{$local->nombre}}</option>
                        @endforeach
                    </select>
                    <input type="text" name="formaretiro" hidden id="" value="adomicilio">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="elegir_local2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selección de local</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('selecciondepago')}}" method="post">
                <div class="modal-body">
                    @csrf
                    <span>Seleccione su local más cercano</span>
                    <select name="local" class="form-control">
                        @foreach($locales as $local)
                            <option value="{{$local->id}}">{{$local->nombre}}</option>
                        @endforeach
                    </select>
                    <input type="text" name="formaretiro" hidden id="" value="retirolocal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    #div-forma-pago:hover{
        background: orange;
        transform: translateY(-3px);
        box-shadow: 0 4px 17px rgba(0, 0, 0, 0.35);
    }
</style>
<script> 

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script> 
    var locals = {!! json_encode($locales->toArray()) !!};
    
    function ingresadireccion(){
        console.log("entre");
    document.getElementById('elegir_local').hidden = false;
    }
    function selecciondepago(){
    $('#formulario2').submit();
    }

</script>
<script>
    function eliminardelcarrito(idcantidad,id){

        var cantidad = document.getElementById(idcantidad).value;
        $.ajax({
            url: "{{ url('eliminardelcarrito' )}}" + '/' + id+'/'+cantidad,
            type: "GET",
            data: {
                // 
            },
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
              
            },
            error: function(error){
            }
        })
    }
</script>


@endsection