@extends('layouts.layout-landing')

@section('content')
    <div class="row m-0 pt-4">
        <div class="col-12 text-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16" style="color:green;">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
            </svg><br>
            <span class="fs-1">¡Gracias por tu compra!</span><br>
            <span class="fs-5 text-muted">Tu solicitud de compra fue recibida</span><br>
            <span class="fs-5 text-muted">En breve recibirás un correo con el detalle de tu compra.</span><br>
            <span class="fs-4"><b>Nº de pedido: {{$compra->id}}</b></span><br>
            <span class="fs-5">Fecha de la compra: {{$fecha_pago}}</span>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12 text-center bg-light py-4">
            <span class="fs-3"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
              </svg> Dirección</span><br>
              <span>{{$venta->direccionEntrega}}</span><br>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12 text-center bg-light py-4">
            <span class="fs-3"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
            </svg> Medio de pago</span><br>
            <span>Número de tarjeta terminado en {{$confirmacion->cardNumber}}</span><br>
            <span>CLP ${{$confirmacion->amount}}</span>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12 text-center bg-light py-4">
            <span class="fs-3"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-layout-text-sidebar-reverse" viewBox="0 0 16 16">
                <path d="M12.5 3a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1h5zm0 3a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1h5zm.5 3.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5zm-.5 2.5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1h5z"/>
                <path d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2zM4 1v14H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h2zm1 0h9a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5V1z"/>
            </svg> Resumen del pedido</span><br>
            <span><b>Subtotal</b>: ${{$compra->subtotal}}</span><br>
            <span><b>Dscto</b>: 
                @if ($cupon_compra->descuento == null)
                    0
                @else
                    {{$cupon_compra->descuento}}%
                @endif
            </span><br>
            <span><b>Total</b>: ${{$compra->total}}</span>
        </div>
        <div class="col-12 text-center my-1">
            <a class="btn text-dark" href="{{url('/')}}" role="button" style="background-color:orange">Volver al inicio</a>
        </div>
    </div>
@endsection