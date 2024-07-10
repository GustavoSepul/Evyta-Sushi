@extends('layouts.layout-landing')

@section('content')
<div class="row m-0">
    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-4">
        <span class="d-flex h3">Enviar a:</span>
        <input type="double" name="direccion" id="direccion"  class="form-control" value="{{ Auth::user()->direccion }}" disabled> <br>
        <input type="double" name="lati" id="lati"  class="form-control" value="{{ Auth::user()->latitud }}"disabled hidden>
        <input type="double" name="longi" id="longi"  class="form-control" value="{{ Auth::user()->longitud }}"disabled hidden>
        <div id="mapSect" style="height: 500px; width: 100%;"></div>
        <input type="double" name="latitud" id="latitud"  class="form-control" hidden>
        <input type="double" name="longitud" id="longitud"  class="form-control" hidden>
        <label id="pedi">La dirección seleccionada no cuenta con reparto a domicilio</label><br>
        <form action="{{url('cambiardireccion')}}" method="post">
          @csrf
          <input name="local" type="number" value="{{$local->id}}" hidden required>
          <button type="submit" class="btn btn-success mt-2">Seleccionar otra ubicación</button>
        </form>
        <form id="formulario" action="{{url('/selecciondepago')}}" method="post" style=" color:white">
                @csrf
                      <input name="local" type="number" value="{{$local->id}}" hidden required>
                      <textarea type="text" name="direccionEntrega" id="direccionEntrega"  class="form-control" hidden></textarea>
                      <textarea type="text" name="entrega" id="entrega"  class="form-control" hidden >{{ Auth::user()->direccion }}</textarea>
                      <input type="text" name="formaretiro" hidden id="" value="adomicilio">
                      <input class="btn btn-success mt-2" type="submit" value="Confirmar" id="pedir">
                      
                </form>
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
<style>
    #div-forma-pago:hover{
        background: orange;
    }
</style>
<script> 

function selecciondepago(){
$('#formulario').submit();
}

</script>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>


<script>
var local = {!! json_encode($local) !!};
console.log(local.area);
var x = document.getElementById("direccion").value;
var la = parseFloat(document.getElementById("lati").value);
  var lg = parseFloat(document.getElementById("longi").value);
var API_KEY = "AIzaSyCJo0d84q3_W-zY6-m9_QJGa1UTY_vn2es";

var cadena = local.area;
                var j = 0;
                for( var i=0; i<cadena.length; i++){
                if (cadena.charAt(i) == '}') {
                    j++;
                }
                };
                let str = cadena;
                let arr = str.split(' ,', j);
                for (let i = 0; i < arr.length; i++) {
                arr[i] = JSON.parse(arr[i]);
                }

  const input = document.getElementById('pedir');
  const input2 = document.getElementById('cambiar');
  const label = document.getElementById('pedi');

  initMap = function()
        {

            coords = {
                lng: lg, 
                lat: la
                };
            setMapa(coords);

        }


function setMapa(coords) {
  var infowindow = new google.maps.InfoWindow();
  var jsonTexto = arr;
  var triangleCoords = [];
  for (x of jsonTexto) {
      triangleCoords.push(new google.maps.LatLng(x.lat, x.lng));
  }

  var map = new google.maps.Map(document.getElementById('mapSect'),
                {
                    zoom: 13,
                    center:new google.maps.LatLng(coords.lat,coords.lng),

                })

  var rightShoulderFront = new google.maps.Polygon({
    paths: triangleCoords,
    map: map,
    strokeColor: '#ff4300',
    strokeWeight: 1.5,
    fillColor: '#ff7700',
    fillOpacity: 0.35
  });

    lat = coords.lat;
    lng = coords.lng;

    var myLatLng = { lat: lat, lng: lng };
    var marker = new google.maps.Marker({
      position: myLatLng,
      map: map
    })
  document.getElementById("latitud").value = lat;
  document.getElementById("longitud").value = lng;
  console.log(lat);
  console.log(lng);
  console.log(document.getElementById('direccionEntrega').innerHTML)
  document.getElementById('direccionEntrega').innerHTML =lat + "," + lng;
  

  var geocoder = new google.maps.Geocoder();
  var selectedFullAddress = "Zona"
  geocoder.geocode({
    address: selectedFullAddress,
  }, 
    function(results, status) {
    
    var curPosition = marker.getPosition();
    var isWithinPolygon = google.maps.geometry.poly.containsLocation(curPosition, rightShoulderFront);
    if (isWithinPolygon == true) {
      input.hidden = false
      label.hidden = true
      input2.hidden = true
    }else{
      input.hidden = true
      label.hidden = false
      input2.hidden = false

    }

  });
}


</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJo0d84q3_W-zY6-m9_QJGa1UTY_vn2es&callback=initMap&libraries=&v=weekly" defer></script>


@endsection