@extends('layouts.layout-landing')

@section('content')
<div class="row m-0">
    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-4">
        <span class="d-flex h3">Seleccionar ubicación de entrega</span><br>
        <div id="mapSect" style="height: 500px; width: 100%;" class="mb-1"></div>
        <input type="double" name="latitud" id="latitud"  class="form-control" hidden>
        <input type="double" name="longitud" id="longitud"  class="form-control" hidden>
        <label id="pedi">La dirección seleccionada no cuenta con reparto a domicilio</label>
        <form id="formulario" action="{{url('/selecciondepago')}}" method="post" style=" color:white">
            @csrf
            <input name="local" type="number" value="{{$local->id}}" hidden required>
            <textarea type="text" name="direccionEntrega" id="direccionEntrega"  class="form-control" hidden></textarea>
            <textarea type="text" name="entrega" id="entrega"  class="form-control" hidden></textarea>
            <input class="btn btn-success" type="submit" value="Confirmar" id="pedir">
            <input type="text" name="formaretiro" hidden id="" value="adomicilio">
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
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>


<script type="text/javascript">
  var local = {!! json_encode($local) !!};
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

  const seleccionar_button = document.getElementById('pedir');
  const seleccionar_label = document.getElementById('pedi');

  initMap = function()
        {

            coords = {
                lng: -72.1025887406764, 
                lat: -36.61442112597284
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
      draggable: true,
      map: map
    })

  document.getElementById("latitud").value = lat;
  document.getElementById("longitud").value = lng;
  document.getElementById('direccionEntrega').innerHTML =document.getElementById("latitud").value + "," + document.getElementById("longitud").value;
  var direc = getReverseGeocodingData(lat,lng);
  console.log(direc);
  document.getElementById('entrega').innerHTML = direc;
  
  function getReverseGeocodingData(lat, lng) {
    var latlng = new google.maps.LatLng(lat, lng);
    // This is making the Geocode request
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'latLng': latlng },  (results, status) =>{
        if (status !== google.maps.GeocoderStatus.OK) {
            alert(status);
        }
        // This is checking to see if the Geoeode Status is OK before proceeding
        if (status == google.maps.GeocoderStatus.OK) {
            var address = (results[0].formatted_address);
            document.getElementById('entrega').innerHTML = address;
        }
    });
}


  var geocoder = new google.maps.Geocoder();
  var selectedFullAddress = "Zona"
  geocoder.geocode({
    address: selectedFullAddress,
  }, 
    function(results, status) {
    
    var curPosition = marker.getPosition();
    var isWithinPolygon = google.maps.geometry.poly.containsLocation(curPosition, rightShoulderFront);
    if (isWithinPolygon == true) {
      seleccionar_button.disabled = false
      seleccionar_label.hidden = true
    }else{
      seleccionar_button.disabled = true
      seleccionar_label.hidden = false

    }

  });

  marker.addListener('dragend', function(event){

    document.getElementById("latitud").value = this.getPosition().lat();
    document.getElementById("longitud").value = this.getPosition().lng();
    document.getElementById('direccionEntrega').innerHTML =document.getElementById("latitud").value + "," + document.getElementById("longitud").value;
    document.getElementById('entrega').text = getReverseGeocodingData(this.getPosition().lat(),this.getPosition().lng());
    geocoder.geocode({

    address: selectedFullAddress,

  }, 
    function(results, status) {
    
    var curPosition = marker.getPosition();
    var isWithinPolygon = google.maps.geometry.poly.containsLocation(curPosition, rightShoulderFront);
    if (isWithinPolygon == true) {
      seleccionar_button.disabled = false
      seleccionar_label.hidden = true
    }else{
      seleccionar_button.disabled = true
      seleccionar_label.hidden = false    
    }
    });
  });
}



</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJo0d84q3_W-zY6-m9_QJGa1UTY_vn2es&callback=initMap&libraries=&v=weekly" defer></script>

@endsection