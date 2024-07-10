@extends('layouts.layout-landing')

@section('content')


@if (count($pedidos)==0 and count($pedidos2)==0)

<div class="p-2 text-center">
    <h1>Aun no has realizado compras</h1>
    <img class="text-center logo_vacio" src="{{asset('storage/logo.png')}}" alt="Logo evita sushi" style="width: 200px;"><hr>
    <h2>Revisa nuestro catálogo <a href="{{route('catalogo')}}">aquí</a></h2>
</div>
@else
<div class="row m-2">
    <div class="col-lg-6 col-xs-12">
        <h1 class="text-center">Pedidos Actuales</h1>
        @if (count($pedidos2)==0)
            <div class="p-2 text-center">
                <h1>Actualmente no tienes pedidos</h1>
                <img class="text-center logo_vacio" src="{{asset('storage/logo.png')}}" alt="Logo evita sushi" style="width: 200px"><hr>
                <h2>Revisa nuestro catálogo <a href="{{route('catalogo')}}">aquí</a></h2>
            </div>
        @else
        @foreach ($pedidos2 as $key => $pedido)  
                    
                    @if ( $pedido->estado == 'pagado')
                    <div class="card p-4 col-lg-8 bg-white container mt-4 mb-4 p-3 d-flex justify-content-center">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <p class="lead mt-3">
                                <h1 class="text-center">
                                Pedido {{$key+1}}: En preparación
                                </h1>
                            </p>
                            <img class="avatar" src="https://i.pinimg.com/originals/27/f2/62/27f262313d1cf187b3a7d19e1ee1f523.gif">

                            <div class="text mt-3"> 
                                <p class="lead text-center">Su pago ya fue recibido y su pedido se esta preparando </p>
                            </div>
                            <button class="boton cinco" onclick="detallespedido({{$pedido->id}})" data-toggle="modal" data-target="#detallepedido">
                                <div class="icono">
                                    <i data-feather="shopping-bag"></i>
                                </div>
                                <span>Ver Productos</span>
                            </button>
                        </div>
                    </div>
                        
                    @endif
                    @if ( $pedido->estado == 'en_reparto')
                    <div class="card p-4 col-lg-8 bg-white container mt-4 mb-4 p-3 d-flex justify-content-center">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <p class="lead mt-3">
                                <h1 class="text-center">
                                Pedido {{$key+1}}: En reparto
                                </h1>
                            </p>
                            <img class="avatar" src="https://i.gifer.com/origin/ca/cacaa11091931d565bfab63f4303f2b4.gif">

                            <div class="text mt-3"> 
                                <h2 class="lead text-center">Su pedido ya fue preparando y se encuentra en reparto</h2>
                            </div>
                            <button class="boton cinco" onclick="detallespedido({{$pedido->id}})" data-toggle="modal" data-target="#detallepedido">
                                <div class="icono">
                                    <i data-feather="shopping-bag"></i>
                                </div>
                                <span>Ver Productos</span>
                            </button>
                        </div>
                    </div>
                    @endif

                    @endforeach
        @endif
    </div>
    <div class="table-responsive col-lg-6 col-xs-12">
        @if (count($pedidos)==0)
            <div class="p-2 text-center">
                <h1>Aún no has recibido ningún pedido</h1>
                <img class="text-center logo_vacio" src="{{asset('storage/logo.png')}}" alt="Logo evita sushi" style="width: 200px"><hr>
                <h2>Revisa nuestro catálogo <a href="{{route('catalogo')}}">aquí</a></h2>
            </div>
        @else
        <table class="table table-striped table-bordered w-100 shadow-sm" id="myTable" style="text-color:white;">
            <thead class="table">
                <tr>
                    <th class="text-center " scope="col">Fecha</th>    
                    <th class="text-center " scope="col">Tipo de entrega</th>
                    <th class="text-center " scope="col">Local</th>
                    <th class="text-center " scope="col">Productos</th>
                    <th class="text-center " scope="col">Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)  
                <tr>
                     <td class="text-center">{{ $pedido->fechaPedido}}</td> 
                     <td class="text-center">
                        @if ($pedido->destino == 'adomicilio')
                            A domicilio
                        @endif
                        @if ($pedido->destino == 'retirolocal')
                            Retiro en local
                        @endif
                    </td>
                     <td class="text-center">{{$pedido->local}}</td>
                     <td class="text-center">
                        <button type="button" class="btn btn-success" onclick="detallespedido({{$pedido->id}})" data-toggle="modal" data-target="#detallepedido"><i data-feather="shopping-bag"></i></button>
                     </td>
                     <td class="text-center">${{ $pedido->total}}</td> 
                </tr>
                @endforeach
            </tbody>
         </table>
        @endif
    </div>
    
</div>
 <div class="modal fade text-dark animate__animated animate__fadeInUpBig" id="detallepedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detalles del pedido</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row text-center" id="masinfo">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar carrito</button>
        </div>
      </div>
    </div>
  </div>

@endif

@endsection

<style>
    
    @keyframes float {
        0% {
            box-shadow: 0 5px 15px 0px rgba(0,0,0,0.6);
            transform: translatey(0px);
        }
        50% {
            box-shadow: 0 25px 15px 0px rgba(0,0,0,0.2);
            transform: translatey(-20px);
        }
        100% {
            box-shadow: 0 5px 15px 0px rgba(0,0,0,0.6);
            transform: translatey(0px);
        }
    }

    .avatar {
        width: 250px;
        height: 250px;
        box-sizing: border-box;
        border: 5px white solid;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 5px 15px 0px rgba(0,0,0,0.6);
        transform: translatey(0px);
        animation: float 6s ease-in-out infinite;
    }
    .avatar img { width: 100%; height: 100%; }
    .boton {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 250px;
        height: 50px;
        background: #141414;
        color: #fff;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        border-radius: 5px;
        position: relative;
        overflow: hidden;
    }

    .boton span {
        position: relative;
        z-index: 2;
        transition: .3s ease all;
    }
    .boton.cinco span {
        transition: .4s ease-in-out all;
        position: absolute;
        left: 25%;
    }

    .boton.cinco .icono {
        display: flex;
        align-items: center;
        position: absolute;
        z-index: 2;
        left: -40px;
        transition: .3s ease-in-out all;
        opacity: 0;
    }

    .boton.cinco svg {
        color: #fff;
        width: 35px;
        height: 35px;
    }

    .boton.cinco:hover {
        background: #2f9b05;
    }

    .boton.cinco:hover .icono {
        left: calc(100% - 50px);
        opacity: 1;
    }

    .boton.cinco:hover span {
        left: 20px;
    }
</style>

<script>
    var pedidos = {!! json_encode($pedidos->toArray()) !!};
    console.log(pedidos)
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
                    divinfo.setAttribute('class','col-12');
                    var info = "<div><span>"+"<strong>"+producto.nombre+" x </strong>"+"<strong>"+producto.cantidad+" Uds.</strong>"+"</span></div>";
                    var info_img = producto.imagen;
                    
                    divinfo.insertAdjacentHTML('beforeend',info);
                    divinfo.insertAdjacentHTML('beforeend', `<br><img id="imagenProducto" class="mb-4" src="{{ asset('storage').'/${info_img}'}}" style="height: 200px; weidth: 200px;">`);
                    divinfo.insertAdjacentHTML('beforeend',`<hr>`);
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
</script>