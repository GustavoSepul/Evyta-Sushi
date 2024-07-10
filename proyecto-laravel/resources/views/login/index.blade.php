<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evyta Sushi</title>
    <style type="text/css">
        #map{
          width: 100%;
          height: 400px;
        }
        .fondo-login{
            background-image: url('https://i.pinimg.com/736x/d0/3f/de/d03fde84499e848fa292fe0fd63a367d.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none; /* Chrome, Safari, Edge, Opera */
            margin: 0;
        }

        input[type=number] {
            -moz-appearance:textfield; /* Firefox */
        }
    </style>
</head>
<body>
    <div class="row m-0">
        <div class="col fondo-login" style="padding-top: 6%; padding-bottom: 6%;">
            
            <div class="row m-0">
                
                <div class="col-sm-12 col-md-12 col-xl-4 col-lg-4 offset-xl-1 offset-lg-1 my-4 p-4 rounded">
                    <div class="text-center">
                        <span class="h1 text-white"><strong>Iniciar sesión</strong></span><br>
                    </div>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <span class="text-white">Correo Electrónico</span><br>
                        <input placeholder="ejemplo@dominio.com" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>                  
                        <span class="text-white">Contraseña</span><br>
                        <input placeholder="Contraseña" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        
                            <div class="btn-group mt-2 " role="group" aria-label="Basic example">
                            <button type="submit" class="btn" style="background-color: rgb(249,149,22); float: left">{{ __('Ingresar') }}</button>
                            <a class="btn text-white p-2" href="{{ route('password.request') }}" style="background-color:black; margin-left: auto; margin-right: auto;">¿Olvidó su contraseña?</a>
                            </div>
                            <a class="btn rounded text-white p-2 mt-2 " href="{{ url('/') }}" style="background-color:red; float: right;">Atrás</a>
                        
                    </form>
                </div>
                
                <div class="col-sm-12 col-md-12 col-xl-4 col-lg-4 offset-xl-2 offset-lg-2 my-4 rounded" style="background: rgb(255,139,0); background: linear-gradient(198deg, rgba(255,139,0,1) 0%, rgba(255,134,0,1) 50%, rgba(212,44,0,1) 100%);">
                    @if(count($errors)>0)

    <div class="alert alert-danger mt-2" role="alert">
        <ul>
            @foreach($errors->all() as $error)
               <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(Session::has('mensaje'))
<div class="alert alert-success alert-dismissible mt-2" role="alert">
{{ Session::get('mensaje') }}
{{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button> --}}
</div>
@endif
                    <div class="text-center">
                        <span class="h1 text-black"><strong>Regístrate</strong></span><br>
                    </div>
                    <form action="{{ url('/registrarCliente') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- <span class="text-white">Correo Electrónico</span><br>
                        <input placeholder="ejemplo@dominio.com" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>                  
                        <span class="text-white">Contraseña</span><br>
                        <input placeholder="Contraseña" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> --}}
                        

                        <div class="form-group">
                            <label for="rut">Rut:</label>
                            <input required placeholder="187520724" type="number" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" name="rut" value="{{ isset($users->rut)?$users->rut:old('rut') }}" id="rut">
                            <small class="form-text text-muted">Si tu rut termina en k reemplázalo por un 0</small>
                        </div>
                    
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input required placeholder="Carlos Camaño" type="text" class="form-control" name="name" value="{{ isset($users->name)?$users->name:old('name') }}" id="name">
                        </div>
                    
                        <div class="form-group">
                            <label for="email">Correo:</label>
                            <input required placeholder="ccamaño@gmail.com" type="text" class="form-control" name="email" value="{{ isset($users->email)?$users->email:old('email') }}" id="email">
                        </div>
                    
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input required placeholder="Pasaje 7 casa #108 Hualpén" type="text" class="form-control" name="direccion" value="{{ isset($users->direccion)?$users->direccion:old('direccion') }}" id="direccion">
                        </div>
                        
                            <button type="button" id="open" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                Seleccionar ubicación en el mapa
                            </button>

                            <div class="modal" id="myModal">
                                <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                    <h4 class="modal-title">Seleccione su ubicación en el mapa</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <div id="map"></div>
                                    </div>

                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                    </div>

                                </div>
                                </div>
                            </div>

                        <div class="form-group">
                            <label for="celular">Celular:</label>
                            <input required placeholder="930324576" type="number" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" name="celular" value="{{ isset($users->celular)?$users->celular:old('celular') }}" id="celular">
                        </div>
                    
                        <div class="form-group">
                            <label for="telefono">Telefono:</label>
                            <input placeholder="412356743" type="number" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control"  name="telefono" value="{{ isset($users->telefono)?$users->telefono:old('telefono') }}" id="telefono">
                        </div>
                        <div class="mb-3" >
                            <input type="double" name="latitud" id="latitud"  class="form-control" hidden>
                        </div>

                        <div class="mb-3" >
                            <input type="double" name="longitud" id="longitud"  class="form-control" hidden>
                        </div>
                        <div class="form-group">
                            <label for="Contraseña">Contraseña:</label>
                            <input required placeholder="carlitos90" type="password" class="form-control" name="password" value="{{ isset($users->password)?$users->password:old('password') }}" id="Contraseña">
                        </div>
                        <button type="submit" class="my-2 btn" style="background-color: rgb(249,149,22);">{{ __('Registrarse') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var marker;
        var coords ={};

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
                    zoom: 13,
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
        
                
                marker.addListener('dragend', function(event)
                {
                    document.getElementById("latitud").value = this.getPosition().lat();
                    document.getElementById("longitud").value = this.getPosition().lng();
                });
                

                

                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                        map.setZoom(13);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(13);
                    }
                    
                    marker.setPosition(place.geometry.location);
                    document.getElementById("latitud").value = place.geometry.location.lat();
                    document.getElementById("longitud").value = place.geometry.location.lng();

                });
        }

        $("#open").click(function(){
            initMap(new google.maps.LatLng(document.getElementById("latitud").value = place.geometry.location.lat(), document.getElementById("longitud").value = place.geometry.location.lng()));
            });

</script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCJo0d84q3_W-zY6-m9_QJGa1UTY_vn2es&callback=initMap" async defer></script>

</body>
</html>