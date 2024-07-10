@extends('layouts.layout-landing')

@section('content')
<style>
    #mapSect {
  height: 100%;
  width: 100%;
}


/* Optional: Makes the sample page fill the window. */

html,
body {
  height: 50%;
  margin: 0;
  padding: 0;
}
  </style>
  <h1>Seleccionar ubicacion de entrega</h1>

  <div id="mapSect"></div>
  <div class="mb-3" >
        <input type="double" name="latitud" id="latitud"  class="form-control">
    </div>

    <div class="mb-3" >
        <input type="double" name="longitud" id="longitud"  class="form-control">
    </div>

    <div class="mb-3" >
        <textarea type="text" name="direccionEntrega" id="direccionEntrega"  class="form-control"></textarea>
    </div>

  <label id="label">La dirección seleccionada no cuenta con reparto a domicilio</label>
  <button class="btn btn-primary" id="pedir">Pedir</button> 
  <br>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>



<script type="text/javascript">
    var locals = {!! json_encode($local->toArray()) !!};
    var cadena = locals.area;
                var j = 0;
                for( var i=0; i<cadena.length; i++){
                if (cadena.charAt(i) == '}') {
                    j++;
                }
                };
                let str = locals.area;
                let arr = str.split(' ,', j);
                for (let i = 0; i < arr.length; i++) {
                arr[i] = JSON.parse(arr[i]);
                }

  const button = document.getElementById('pedir');

  initMap = function()
        {

            navigator.geolocation.getCurrentPosition(
                function(position){
                    coords = {
                        lng: position.coords.longitude,
                        lat: position.coords.latitude
                    };
                    setMapa(coords);

                },
                function(error){
                    
            });
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
    map: map
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

  var geocoder = new google.maps.Geocoder();
  var selectedFullAddress = "Zona"
  geocoder.geocode({
    address: selectedFullAddress,
  }, 
    function(results, status) {
    
    var curPosition = marker.getPosition();
    var isWithinPolygon = google.maps.geometry.poly.containsLocation(curPosition, rightShoulderFront);
    if (isWithinPolygon == true) {
      button.disabled = false
      label.hidden = true
    }else{
      button.disabled = true
      label.hidden = false

    }

  });

  marker.addListener('dragend', function(event){

    document.getElementById("latitud").value = this.getPosition().lat();
    document.getElementById("longitud").value = this.getPosition().lng();
    document.getElementById('direccionEntrega').innerHTML =document.getElementById("latitud").value + "," + document.getElementById("longitud").value;
    geocoder.geocode({

    address: selectedFullAddress,

  }, 
    function(results, status) {
    
    var curPosition = marker.getPosition();
    var isWithinPolygon = google.maps.geometry.poly.containsLocation(curPosition, rightShoulderFront);
    if (isWithinPolygon == true) {
      button.disabled = false
      label.hidden = true
    }else{
      button.disabled = true
      label.hidden = false    
    }
    });
  });
}

function isActivated(hoursActive) {
    const dates = hoursActive.map(dateString => {
        const [hour, minute] = dateString.split(':')
        let date = new Date()
        date.setHours(hour, minute, 0, 0)
        return date
    })

    let isActive = false;
    const now = new Date();

    for (let i = 0; i < dates.length; i = i + 2) {
        isActive = isActive || now.valueOf() >= dates[i].valueOf()
            && now.valueOf() <= dates[i + 1].valueOf()
    }
    return isActive
}

window.setInterval(
    function () {
        let hoursActive = ['14:00', '22:00']
        if (isActivated(hoursActive)) {
            document.getElementById('pedir').style.display = 'block';
        } else {
            document.getElementById('pedir').style.display = 'none';
        }
    }
    , 2000);

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJo0d84q3_W-zY6-m9_QJGa1UTY_vn2es&callback=initMap&libraries=&v=weekly" defer></script>

@endsection
  