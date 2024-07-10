@extends('layouts.layout-landing')

@section('content')
<div class="row m-0">
    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-4">
        <span class="d-flex h3">Carrito de compras</span><br>
        <span class="d-flex">Selecciona un método de pago:</span><br>
        <div class="card" style="cursor: pointer;" type="submit" id='div-forma-pago' onclick=" location.href='/iniciar_venta' ">
            <div class="card-body">
                <!-- <h5 class="card-title"><i data-feather="home" style=" width:4%; color:black"></i>Retiro en local</h5> -->
                <div class="row">
                    <div class="col-6 my-auto">
                        <span class="align-middle">Tarjetas de Débito / Crédito - Cuenta Vista / RUT</span>
                    </div>
                    <div class="col-6">
                        <img src="{{asset('storage/checkout/redcompra.jpg')}}" alt="icon_debit" class="float-right" style="width:125px">
                    </div>
                </div>
            </div>
        </div>
        <div class="card" class="m-3">
            <div class="card-body">
                <!-- <h5 class="card-title"><i data-feather="truck" style=" width:4%; color:black"></i>Entrega a domicilio</h5> -->
                <div class="row">
                    <div class="col-6">
                        <span class="align-middle">Ingresa un cupón de descuento</span>
                    </div>
                    <div class="col-6">
                        <input placeholder="" id="escribecupon" name="nombre" type="text" class="form-control" tabindex="4">
                        <a type="button" onclick="ingresocupon()" class="text-dark btn border-secondary w-100" style="overflow: hidden;">Presiona aquí para canjear tu cupón</a>   
                    </div>
                </div>
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
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <hr><span><strong>Subtotal</strong>: ${{$productos[0]->subtotal}}</span>
        <br><span id="descuentoporcupon"><strong>Descuento Cupón</strong>: @if(isset($productos[0]->id_cupon)) {{$productos[0]->descuento}}%@else - @endif</span>
        <hr><span id='totalapagar'><strong>Total a pagar</strong>: ${{$productos[0]->total}}</span>
    </div>
</div>
<style>
    #div-forma-pago:hover{
        background: orange;
    }
</style>
<script> 
    function ingresocupon(){
        var codigo= document.getElementById('escribecupon').value;
        $.ajax({
            url: "{{ url('ingresocupon' )}}" + '/' + codigo,
            type: "GET",
            data: {
                // 
            },
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                Swal.fire({
                icon: 'success',
                title: 'Cupón agregado con éxito',
                showConfirmButton: false,
                timer: 1500
                });
                setTimeout(() => {window.location.reload()}, "1500")
            },
            error: function(error){
                Swal.fire({
                icon: 'error',
                title: 'Oops, parece que algo salió mal.',
                showConfirmButton: false,
                timer: 1500
                });
                setTimeout(() => {window.location.reload()}, "1500")
            }
        });  
    }
</script>
@endsection