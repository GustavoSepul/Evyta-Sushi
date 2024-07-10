@extends('layouts.layout-landing')

@section('content')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>


    <div class="col">
      <h1 class="mb-3">
        <div class="text-center">
        Ubicación de las sucursales
        </div>
      </h1>

      <div id="map" class="animate__animated animate__fadeInUp"></div>
    </div>

    <script type="text/javascript">
      var locals = {!! json_encode($locals->toArray()) !!};
      var zom = 10;
   
        function initMap() {
          var locales = [];
          var latlngbounds = new google.maps.LatLngBounds();
            const map = new google.maps.Map(document.getElementById("map"), {
              center: new google.maps.LatLng(0, 0),
				      zoom: zom,
              mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            const infoWindow = new google.maps.InfoWindow();
            
            locals.forEach(function(element){
            var cadena = element.area;
            var j = 0;
	          for( var i=0; i<cadena.length; i++){
              if (cadena.charAt(i) == '}') {
                j++;
              }
            };
            let str = element.area;
            let arr = str.split(' ,', j);
            for (let i = 0; i < arr.length; i++) {
              arr[i] = JSON.parse(arr[i]);
            }
            var jsonTexto = arr;
            var myLatLng = { lat: element.latitud, lng: element.longitud, };

            const marker = new google.maps.Marker({
              position: myLatLng,
              map: map,
              title: `Evyta Sushi `+ element.nombre,
            });
            
            marker.addListener('click', function() {
              map.setZoom(13);
              map.setCenter(marker.getPosition());
            });
            marker.addListener("click", () => {
              infoWindow.close();
              infoWindow.setContent(marker.getTitle());
              infoWindow.open(marker.getMap(), marker);
            });
            
            var triangleCoords = [];
            for (x of jsonTexto) {
              triangleCoords.push(new google.maps.LatLng(x.lat, x.lng));
            }

            myPolygon = new google.maps.Polygon({
              paths: triangleCoords,
              strokeColor: '#ff4300',
              strokeWeight: 1.5,
              fillColor: '#ff7700',
              fillOpacity: 0.35
            });
            
            myPolygon.setMap(map);
            locales.push({latlng: new google.maps.LatLng(myLatLng)});
            });

            
            for (var i = 0; i < locales.length; i++) {
              latlngbounds.extend(locales[i].latlng);
            }
            map.fitBounds(latlngbounds);
            var centerControlDiv = document.createElement('div'); 
            var centerControl = new CenterControl(centerControlDiv, map);

            centerControlDiv.index = 1;
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
        }
		    google.maps.event.addDomListener(window, 'load', initMap);
        
    </script>
  
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key=AIzaSyCJo0d84q3_W-zY6-m9_QJGa1UTY_vn2es&callback=initMap" >
    </script>
  <style type="text/css">
        #map {
          width: 100%;
          height: 400px;
          background-color: grey;
          padding-bottom: 30%;
        }
    #mapas{
        background-color: #cc3300;
        transform: translateY(-3px);
        box-shadow: 0 4px 17px rgba(0, 0, 0, 0.35);
    }
    </style>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 
@endsection

