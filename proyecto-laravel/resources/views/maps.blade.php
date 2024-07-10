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
<h1>Domicilio</h1>

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


<script>
    
var x = "Av alemania 200, Los Angeles, Chile";
// var x = "Av alemania 100, Los Angeles, Chile";
var API_KEY = "AIzaSyCJo0d84q3_W-zY6-m9_QJGa1UTY_vn2es";

var cadena = '{"lat":"-37.46006758959347","lng":"-72.32724230444336"} ,{"lat":"-37.47731190590521","lng":"-72.33136217749023"} ,{"lat":"-37.476971331387745","lng":"-72.34698481237791"} ,{"lat":"-37.47690321629799","lng":"-72.35471102392576"} ,{"lat":"-37.469030857245514","lng":"-72.35488268530271"} ,{"lat":"-37.4619752182211","lng":"-72.35024782812498"} ,{"lat":"-37.45993132854353","lng":"-72.34749979650877"} ,';
                var j = 0;
                for( var i=0; i<cadena.length; i++){
                if (cadena.charAt(i) == '}') {
                    j++;
                }
                };
                let str = '{"lat":"-37.46006758959347","lng":"-72.32724230444336"} ,{"lat":"-37.47731190590521","lng":"-72.33136217749023"} ,{"lat":"-37.476971331387745","lng":"-72.34698481237791"} ,{"lat":"-37.47690321629799","lng":"-72.35471102392576"} ,{"lat":"-37.469030857245514","lng":"-72.35488268530271"} ,{"lat":"-37.4619752182211","lng":"-72.35024782812498"} ,{"lat":"-37.45993132854353","lng":"-72.34749979650877"} ,';
                let arr = str.split(' ,', j);
                for (let i = 0; i < arr.length; i++) {
                arr[i] = JSON.parse(arr[i]);
                }

  const button = document.getElementById('pedir');

function getCoordinates(address){
  address = x;
  fetch("https://maps.googleapis.com/maps/api/geocode/json?address="+address+'&key='+API_KEY)
    .then(response => response.json())
    .then(data => {
      const latitude = data.results[0].geometry.location.lat;
      const longitude = data.results[0].geometry.location.lng;
      coords = {
                lng: longitude,
                lat: latitude
      }
      setMapa(coords);
    })
    
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

  // marker.addListener('dragend', function(event){

  //   document.getElementById("latitud").value = this.getPosition().lat();
  //   document.getElementById("longitud").value = this.getPosition().lng();
  //   document.getElementById('direccionEntrega').innerHTML =document.getElementById("latitud").value + "," + document.getElementById("longitud").value;
  //   geocoder.geocode({

  //   address: selectedFullAddress,

  // }, 
  //   function(results, status) {
    
  //   var curPosition = marker.getPosition();
  //   var isWithinPolygon = google.maps.geometry.poly.containsLocation(curPosition, rightShoulderFront);
  //   if (isWithinPolygon == true) {
  //     button.disabled = false
  //     label.hidden = true
  //   }else{
  //     button.disabled = true
  //     label.hidden = false    
  //   }
  //   });
  // });
}


</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJo0d84q3_W-zY6-m9_QJGa1UTY_vn2es&callback=getCoordinates&libraries=&v=weekly" defer></script>

@endsection