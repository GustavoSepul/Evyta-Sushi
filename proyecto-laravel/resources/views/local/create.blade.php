@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
    <span class="mt-2"><h2>Creación nuevo local</h2>
</div>

@if(count($errors)>0)

    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
               <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>

@endif

<form class="formulario-crear" action="{{url('local')}}" method="POST" class="col-9">
    @csrf

    <div class="row m:0">
        <div class="col-lg-6 col-xs-12">
            <label for="" class="form-label">Nombre</label>
            <input id="nombre" name="nombre" type="text" class="form-control" tabindex="4" placeholder="Pinto">
        
            <label for="" class="form-label">Horario Apertura</label>
            <input id="horario_a" name="horario_a" type="time" class="form-control" tabindex="4" min="00:01" max="23:59" placeholder="00:00">

        </div>
        <div class="col-lg-6 col-xs-12">
            <label for="celular" class="form-label">Celular</label>
            <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">+56</span>
                    </div>
                    <input placeholder="930324576" type="number" class="form-control" name="celular" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="celular" tabindex="5">
            </div>

            <label for="" class="form-label">Horario Cierre</label>
            <input id="horario_c" name="horario_c" type="time" class="form-control" tabindex="4" min="00:01" max="23:59" placeholder="00:00">
        
        </div>


    </div>





    <input type="checkbox" aria-label="Checkbox for following text input" name="abierto" id="abierto" checked hidden>

    <div class="mb-3" >
        <label for="" class="form-label">Dirección</label>
        <input id="direccion" name="direccion" type="text" class="form-control" tabindex="6" placeholder="Av. Santa María #501-B">
    </div>

    <div id="map"></div>

    <textarea id="area" name="area" type="text" class="form-control" tabindex="7" placeholder="Av. Santa María #501-B" hidden></textarea>

    <div class="mb-3" >
        <input type="double" name="latitud" id="latitud"  class="form-control" hidden>
    </div>

    <div class="mb-3" >
        <input type="double" name="longitud" id="longitud"  class="form-control" hidden>
    </div>

    <button type="submit" class="btn btn-success" tabindex="8">Guardar</button>

    <a href="/local" class="btn btn-secondary" tabindex="9">Cancelar</a>

</form>


<script>
        var marker;
        var coords ={};
        var triangleCoords = [];

        initMap = function()
        {

            coords = {
                lng: -72.1025887406764, 
                lat: -36.61442112597284
                };
            setMapa(coords);

        }


        function setMapa (coords)
        {

                var map = new google.maps.Map(document.getElementById('map'),
                {
                    zoom: 11,
                    center:new google.maps.LatLng(coords.lat,coords.lng),

                })
                var input = document.getElementById('direccion');

                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo('bounds', map);

                var infowindow = new google.maps.InfoWindow();

                marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: new google.maps.LatLng(coords.lat,coords.lng),

                });

                document.getElementById("latitud").value = coords.lat;
                document.getElementById("longitud").value = coords.lng;
                document.getElementById('area').innerHTML = 
                "{\"lat" + "\":" + "\"" + (coords.lat+0.02) + "\"" + "," + "\"lng" + "\":" + "\"" + (coords.lng+0.02) + "\"" + "} , " +
                "{\"lat" + "\":" + "\"" + (coords.lat-0.02) + "\"" + "," + "\"lng" + "\":" + "\"" + (coords.lng+0.02) + "\"" + "} , " + 
                "{\"lat" + "\":" + "\"" + (coords.lat-0.02) + "\"" + "," + "\"lng" + "\":" + "\"" + (coords.lng-0.02) + "\"" + "} , " +
                "{\"lat" + "\":" + "\"" + (coords.lat+0.02) + "\"" + "," + "\"lng" + "\":" + "\"" + (coords.lng-0.02) + "\"" + "} , " ;
                
                triangleCoords = [
                    new google.maps.LatLng(coords.lat+0.02,coords.lng+0.02),
                    new google.maps.LatLng(coords.lat-0.02,coords.lng+0.02),
                    new google.maps.LatLng(coords.lat-0.02,coords.lng-0.02),
                    new google.maps.LatLng(coords.lat+0.02,coords.lng-0.02),
                    ];
                
                marker.addListener('dragend', function(event)
                {
                    document.getElementById("latitud").value = this.getPosition().lat();
                    document.getElementById("longitud").value = this.getPosition().lng();
                });
                
                myPolygon = new google.maps.Polygon({
                    paths: triangleCoords,
                    draggable: true, 
                    editable: true,
                    strokeColor: '#ff4300',
                    strokeWeight: 1.5,
                    fillColor: '#ff7700',
                    fillOpacity: 0.35
                });
                

                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    triangleCoords = [];
                    myPolygon.setMap(null);
                    
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                        map.setZoom(13);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(13);
                    }
                    
                    marker.setPosition(place.geometry.location);
                    triangleCoords = [
                    new google.maps.LatLng(place.geometry.location.lat()+0.02, place.geometry.location.lng()+0.02),
                    new google.maps.LatLng(place.geometry.location.lat()-0.02, place.geometry.location.lng()+0.02),
                    new google.maps.LatLng(place.geometry.location.lat()-0.02, place.geometry.location.lng()-0.02),
                    new google.maps.LatLng(place.geometry.location.lat()+0.02, place.geometry.location.lng()-0.02),
                    ];
                    document.getElementById('area').innerHTML = 
                    "{\"lat" + "\":" + "\"" + (place.geometry.location.lat()+0.02) + "\"" + "," + "\"lng" + "\":" + "\"" + (place.geometry.location.lng()+0.02) + "\"" + "} , " +
                    "{\"lat" + "\":" + "\"" + (place.geometry.location.lat()-0.02) + "\"" + "," + "\"lng" + "\":" + "\"" + (place.geometry.location.lng()+0.02) + "\"" + "} , " + 
                    "{\"lat" + "\":" + "\"" + (place.geometry.location.lat()-0.02) + "\"" + "," + "\"lng" + "\":" + "\"" + (place.geometry.location.lng()-0.02) + "\"" + "} , " +
                    "{\"lat" + "\":" + "\"" + (place.geometry.location.lat()+0.02) + "\"" + "," + "\"lng" + "\":" + "\"" + (place.geometry.location.lng()-0.02) + "\"" + "} , " ;
                    document.getElementById("latitud").value = place.geometry.location.lat();
                    document.getElementById("longitud").value = place.geometry.location.lng();
                    
                    myPolygon = new google.maps.Polygon({
                        paths: triangleCoords,
                        draggable: true, 
                        editable: true,
                        strokeColor: '#ff4300',
                        strokeWeight: 1.5,
                        fillColor: '#ff7700',
                        fillOpacity: 0.35
                    });

                    myPolygon.setMap(map);
                    google.maps.event.addListener(myPolygon.getPath(), "set_at", getPolygonCoords);

                });

                myPolygon.setMap(map);
                google.maps.event.addListener(myPolygon.getPath(), "set_at", getPolygonCoords);
        }
        
        function getPolygonCoords() {
            var len = myPolygon.getPath().getLength();
            var htmlStr = [];
            for (var i = 0; i < len; i++) {
                htmlStr.push("{\"lat" + "\":" + "\"" + myPolygon.getPath().getAt(i).lat() + "\"" + "," + "\"lng" + "\":" + "\"" + myPolygon.getPath().getAt(i).lng() + "\"" + "} ");
                //Use this one instead if you want to get rid of the wrap > new google.maps.LatLng(),
                //htmlStr += "" + myPolygon.getPath().getAt(i).toUrlValue(5);
            }
            htmlStr.push("");
            document.getElementById('area').innerHTML = htmlStr;
        }

</script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCJo0d84q3_W-zY6-m9_QJGa1UTY_vn2es&callback=initMap" async defer></script>

<style>
    #area {
  height: 140px;
  float: left;
  margin-bottom: 30px;
  border: solid 2px #eee;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  -moz-box-shadow: inset 0 2px 5px #444;
  -webkit-box-shadow: inset 0 2px 5px #444;
  box-shadow: inset 0 2px 5px #444;
}

#area, .lngLat {
  font-family: arial, sans-serif;
  font-size: 12px;
  padding-top: 10px;
  width: 270px;
}

#local{
    background-color: rgb(18,19,23);
}

body.light #local{
    background-color: #cc3300;
}
</style>

@endsection

@section('js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>     
    $('.formulario-crear').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Estas seguro que quieres agregar un nuevo local?',
        showDenyButton: true,
        confirmButtonText: 'Sí, agregar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('El local no ha sido agregado', '', 'info')
        }
        })
        
    });
</script>

@endsection