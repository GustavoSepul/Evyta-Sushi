@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
    <span class="mt-2"><h2>Editar local</h2>
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
<div class="container mt-2 mb-2">
<form class="formulario-editar" action="{{url('/local/'.$local->id)}}" method="POST" class="col-9">
    @csrf
    {{method_field('PATCH')}}
    <div class="row m:0">
    
    <div class="col-lg-6 col-xs-12">
        <label for="" class="form-label">Nombre</label>
        <input id="nombre" name="nombre" type="text" class="form-control" value="{{$local->nombre}}" tabindex="1" placeholder="Pinto">
   
        <label for="" class="form-label">Horario Apertura</label>
        <input id="horario_a" name="horario_a" type="time" class="form-control" value="{{$local->horario_a}}" tabindex="3" min="00:01" max="23:59" placeholder="00:00">
    
        <label for="" class="form-label">Dirección</label>
        <input id="direccion" name="direccion" type="text" class="form-control" value="{{$local->direccion}}" tabindex="5" placeholder="Av. Santa María #501-B">

    </div>
   

    <div class="col-lg-6 col-xs-12">
        <label for="celular" class="form-label">Celular</label>
        <div class="input-group"><br>
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">+56</span>
            </div>
            <input placeholder="930324576" type="number" class="form-control" name="celular" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="{{$local->celular}}" id="celular" tabindex="5">
        </div>
    
        <label for="" class="form-label">Horario Cierre</label>
        <input id="horario_c" name="horario_c" type="time" class="form-control" value="{{$local->horario_c}}" tabindex="4" min="00:01" max="23:59" placeholder="00:00">
    
        <label for="">¿Abierto?</label><br>
        <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" aria-label="Checkbox for following text input" name="abierto" id="abierto">
                    </div>
                </div>
                <input disabled value="Desmarque la casilla si no lo está" type="text" class="form-control" aria-label="Text input with checkbox"><br>
        </div>
    </div>

    </div>



 




    <br>

    <div id="map"></div>

    <div class="mb-3" >
        <textarea id="area" name="area" type="text" class="form-control" tabindex="7" placeholder="" hidden>{{$local->area}}</textarea>
    </div>

    <div class="mb-3" >
        <input type="double" name="latitud" id="latitud" value="{{$local->latitud}}" class="form-control" hidden>
    </div>

    <div class="mb-3" >
        <input type="double" name="longitud" id="longitud" value="{{$local->longitud}}" class="form-control" hidden>   
    </div>
                
    <button type="submit" class="btn btn-success" tabindex="8">Guardar</button>

    <a href="/local" class="btn btn-secondary" tabindex="9">Cancelar</a>

</form>
</div>

    <style>
    #local{
        background-color: rgb(18,19,23);
    }
    body.light #local{
        background-color: #cc3300;
    }
</style>
@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>     
    $('.formulario-editar').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Quieres guardar los cambios?',
        showDenyButton: true,
        confirmButtonText: 'Guardar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('Los cambios no han sido guardados', '', 'info')
        }
        })
        
    });
    
</script>
@endsection

<script type="text/javascript">


            var locals = {!! json_encode($local->toArray()) !!};
            var marker;
            var coords ={};
            window.onload = function(){
                if(locals['abierto'] == 1){
                    var help = document.getElementById('abierto');
                    help.setAttribute('checked',true);
                }
            };
                

            initMap = function()
            {

           
                        coords = {
                            lng: {{$local->latitud}},
                            lat: {{$local->longitud}}
                        };
                        setMapa(coords);

            }


            function setMapa (coords)
            {
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

                var map = new google.maps.Map(document.getElementById('map'),
                {
                    zoom: 13,
                    center:new google.maps.LatLng({{$local->latitud}},{{$local->longitud}}),
                });

                var input = document.getElementById('direccion');

                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo('bounds', map);

                var infowindow = new google.maps.InfoWindow();

                marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: new google.maps.LatLng({{$local->latitud}},{{$local->longitud}}),

                });
                var jsonTexto = arr;

                var triangleCoords = [];
                        for (x of jsonTexto) {
                        triangleCoords.push(new google.maps.LatLng(x.lat, x.lng));
                        }
                marker.addListener('dragend', function(event)
                {
                    document.getElementById("latitud").value = this.getPosition().lat();
                    document.getElementById("longitud").value = this.getPosition().lng();
                });





                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    triangleCoords = [];
                    myPolygon.setMap(null);
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
                    
                    marker.setPosition(place.geometry.location);
                    triangleCoords = [
                    new google.maps.LatLng(place.geometry.location.lat()+0.02, place.geometry.location.lng()+0.02),
                    new google.maps.LatLng(place.geometry.location.lat()-0.02, place.geometry.location.lng()+0.02),
                    new google.maps.LatLng(place.geometry.location.lat()-0.02, place.geometry.location.lng()-0.02),
                    new google.maps.LatLng(place.geometry.location.lat()+0.02, place.geometry.location.lng()-0.02),
                    ];
                    document.getElementById("latitud").value = place.geometry.location.lat();
                    document.getElementById("longitud").value = place.geometry.location.lng();
                    // Styling & Controls
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
                    //google.maps.event.addListener(myPolygon, "dragend", getPolygonCoords);
                    google.maps.event.addListener(myPolygon.getPath(), "insert_at", getPolygonCoords);
                    //google.maps.event.addListener(myPolygon.getPath(), "remove_at", getPolygonCoords);
                    google.maps.event.addListener(myPolygon.getPath(), "set_at", getPolygonCoords);
                });

                myPolygon = new google.maps.Polygon({
                    paths: triangleCoords,
                    draggable: true, // turn off if it gets annoying
                    editable: true,
                    strokeColor: '#ff4300',
                    strokeWeight: 1.5,
                    fillColor: '#ff7700',
                    fillOpacity: 0.35
                });

                myPolygon.setMap(map);
                //google.maps.event.addListener(myPolygon, "dragend", getPolygonCoords);
                google.maps.event.addListener(myPolygon.getPath(), "insert_at", getPolygonCoords);
                //google.maps.event.addListener(myPolygon.getPath(), "remove_at", getPolygonCoords);
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

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCJo0d84q3_W-zY6-m9_QJGa1UTY_vn2es&callback=initMap" 
async defer></script>

@endsection