@extends('layouts.layout-admin')

@section('content')

<h1 class="mb-3">
  <div class="text-center">
    Vista panel de control 
  </div>
</h1>

<div class="row justify-content-center ">
  {{-- @forelse($notifications as $notification)
        <div class="alert alert-success" role="alert">
            [{{ $notification->created_at }}] User {{ $notification->data['name'] }} ({{ $notification->data['email'] }}) has just registered.
            <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                Mark as read
            </a>
        </div>

        @if($loop->last)
            <a href="#" id="mark-all">
                Mark all as read
            </a>
        @endif
    @empty
        There are no new notifications
    @endforelse --}}

        <div class=" p-2 col-xl-3 col-lg-3 col-md-12 col-sm-12 text-dark rounded m-4 text-center "style="background-color: #ffa500">
    <span class=" mb-3 text-base font-medium text-dark"style="font-size:35px;"> Venta de Hoy</span>
    <br>  
    <span id="ventahoy" class="text-3xl font-bold leading-none "style="font-size:40px;">${{$ventahoy}}</span>
        
    </div>  

    <div class="p-2 col-xl-3 col-lg-3 col-md-12 col-sm-12  rounded m-4 text-center"style="background-color: #ffa500">
    <span class="mb-3 text-base font-medium text-dark"style="font-size:35px;"> Venta Mensual</span>
    <br>
    <span class="text-3xl font-bold leading-none text-dark"style="font-size:40px;">${{$ventames}}</span>
    </div>

    <div class="p-2 col-xl-3 col-lg-3 col-md-12 col-sm-12 rounded m-4 text-center"style="background-color: #ffa500">
    <span class="mb-3 text-base font-medium text-dark"style="font-size:35px;">Total Ventas Anuales</span>
    <br>
    <span class=" text-3xl font-bold leading-none text-dark"style="font-size:40px;">${{$ventanual}}</span>
    </div>
      
</div>
<div class="row justify-content-center ">
    <div class=" p-2 col-xl-4 col-lg-4 col-md-6 col-sm-12  rounded m-4 text-center "style="background-color: #ffa07a">
    <span class=" mb-3 text-base font-medium text-dark  " style="font-size:30px;">   <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class=" text-dark bi bi-cart" viewBox="0 0 16 16">
  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
</svg> Total ordenes</span>
  <br>
      <span class=" mb-3 text-base font-medium text-white  " style="font-size:30px;">{{$ordenes['totales']}}</span>
    

    </div>  
    

    <div class=" p-2 col-xl-4 col-lg-4 col-md-6 col-sm-12  rounded m-4 text-center "style="background-color: #ffa07a">
    <span class=" mb-3 text-base font-medium text-dark   "style="font-size:30px;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
  <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
  <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
</svg> Ordenes pagadas</span>
<br>
<span class=" mb-3 text-base font-medium text-white  " style="font-size:30px;">{{$ordenes['pagadas']}}</span>
    
    </div> 
    <div class=" p-2 col-xl-4 col-lg-4 col-md-6 col-sm-12  rounded m-4 text-center "style="background-color: #ffa07a">
    <span class=" mb-3 text-base font-medium text-dark  "style="font-size:30px;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
  <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
</svg> Ordenes en reparto</span>
<br>
<span class=" mb-3 text-base font-medium text-white  " style="font-size:30px;">{{$ordenes['reparto']}}</span>
    
    </div> 
    <div class=" p-2 col-xl-24 col-lg-4 col-md-6 col-sm-12  rounded m-4 text-center "style="background-color: #ffa07a">
    
    <span class=" mb-3 text-base font-medium text-dark  "style="font-size:30px;">
    
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
              <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z"/>
              <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z"/>
    </svg> Ordenes finalizadas</span>
<br>
<span class=" mb-3 text-base font-medium text-white  " style="font-size:30px;">{{$ordenes['finalizadas']}}</span>  

    </div> 

</div>
<br>

<div class="my-2">
  <canvas id="myChart"></canvas>
</div>
<div class="table-responsive">
  <table class ="table table-striped table-bordered w-100 shadow-sm" id="myTable" style="text-color:white;">
      <thead class="table">
          <tr>
              <th class="text-center datatables1">Fecha Venta</th>
              <th class="text-center datatables1">Dirección</th>
              <th class="text-center datatables1">Método de pago</th>
              <th class="text-center datatables1">Monto</th>
              <th class="text-center datatables1">Estado</th>
          </tr>
      </thead>
      <tbody>
          @foreach($ventasTable as $ventaTable)
              <tr>
                  <td class="text-center datatables2">{{$ventaTable->fechaPedido}}</td>
                  <td class="text-center datatables2">{{$ventaTable->direccionEntrega}}</td>
                  <td class="text-center datatables2">{{$ventaTable->tipoPago}}</td>
                  <td class="text-center datatables2">{{$ventaTable->total}}</td>
                  <td class="text-center datatables2">{{$ventaTable->estado}}</td>
              </tr>
          @endforeach
      </tbody>
  </table>
</div>

    <style>
        #dashboard{
            background-color: rgb(18,19,23);
        }
        body.light #dashboard{
            background-color: #cc3300;
        }
    </style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
     var ventas = {!! json_encode($ventas) !!};
  const labels = [
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Diciembre',

  ];

  const data = {
    labels: labels,
    datasets: [{
      label: 'Ventas del mes',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [ ventas.Enero, ventas.Febrero, ventas.Marzo, ventas.Abril, ventas.Mayo, ventas.Junio, ventas.Julio,
        ventas.Agosto, ventas.Septiembre, ventas.Octubre, ventas.Noviembre,ventas.Diciembre
      ],
    }]
  };

  const config = {
    type: 'bar',
    data: data,
    options: {
          plugins:{
                title:{
                  display:true,
                  text:'Valor total de Ventas por cada mes',
                  font:{
                    size:40
                  }
                }
          }
    }
  };
</script>
<script>
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>

@endsection