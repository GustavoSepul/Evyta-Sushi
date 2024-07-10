@extends('layouts.layout-admin')

@section('content')
<div class="p-2">
    <div class="col-12 text-center h1">
        Pedidos por entregar
    </div>
    <div class="table-responsive col-12">
        <table id="myTable" class="table table-striped table-bordered w-100 shadow-sm" style="text-color:white;">
            <thead>
                <tr>
                    <th class="text-center datatables1" scope="col">Fecha venta</th>    
                    <th class="text-center datatables1" scope="col">Nombre cliente</th>
                    <th class="text-center datatables1" scope="col">Tipo de entrega</th>
                    <th class="text-center datatables1" scope="col">Direccion</th>
                    <th class="text-center datatables1" scope="col">Resumen pedido</th>
                    <th class="text-center datatables1" scope="col">Marcar como entregado</th>
                    <th class="text-center datatables1" scope="col">Google Maps</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)  
                <tr>
                     <td class="text-center datatables2">{{ $pedido->fechaPedido}}</td> 
                     <td class="text-center datatables2">{{$pedido->name}}</td>
                     <td class="text-center datatables2">
                        @if ($pedido->destino == 'adomicilio')
                            A domicilio
                        @endif
                        @if ($pedido->destino == 'retirolocal')
                            Retiro en local
                        @endif
                    </td>
                     <td class="text-center datatables2">{{$pedido->direccionEntrega}}</td>
                     <td class="text-center datatables2">
                        <button type="button" class="btn btn-success" onclick="detallespedido({{$pedido->id}})" data-toggle="modal" data-target="#detallepedido"><i data-feather="shopping-bag"></i></button>
                     </td>
                     <td class="text-center datatables2">
                        <a href="" type="button" class="btn btn-success" onclick="marcarentregado({{$pedido->id}})"><i data-feather="check"></i></a>
                     </td>
                     <td class="text-center datatables2">
                        <input type="text" name="direccionEditar" id="direccionEditar" value="{{$pedido->coordenadas}}" hidden>
                        <button onclick="return mostrarLugar();" type="button" class="btn btn-warning" href="https://www.google.cl/maps/preview" target="_blank"><i data-feather="map"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
         </table>
    </div>
</div>
<div class="modal fade text-dark" id="detallepedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detalles del pedido</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row" id="masinfo">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar carrito</button>
        </div>
      </div>
    </div>
  </div>
<style>
    #pedido{
        background-color: rgb(18,19,23);
    }
    body.light #ingrediente{
        background-color: #cc3300;
    }
</style>
<script>
    function mostrarLugar(){
        let item = document.getElementById('direccionEditar');
        if(item){
            window.open('https://google.cl/maps/place/'+item.value, '_blank');
        }  
        return false; //No ejecutar el evento.
    };
    function detallespedido($id){
        $.ajax({
          url: "{{ url('detallespedido' )}}"+'/'+$id,
            type: "GET",
            data: {
                // 
            },
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                deleteChild();
                var element=document.getElementById('masinfo');
                $.each(data,function(i,producto){
                    var divinfo = document.createElement('div');
                    divinfo.setAttribute('class','col-12',);
                    var info = "<span>"+"<strong>"+producto.nombre+" x </strong>"+"<strong>"+producto.cantidad+" Uds.</strong>"+"</span>";
                    divinfo.insertAdjacentHTML('beforeend',info);
                    element.appendChild(divinfo);
                });
            },
            error: function(error){

            }
        });
    };
    function deleteChild() {
        var e = document.getElementById("masinfo");
        
        //e.firstElementChild can be used.
        var child = e.lastElementChild; 
        while (child) {
            e.removeChild(child);
            child = e.lastElementChild;
        }
    };
    function marcarentregado($id){
        $.ajax({
          url: "{{ url('marcarentregado' )}}"+'/'+$id,
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
        });
    }
</script>
@endsection