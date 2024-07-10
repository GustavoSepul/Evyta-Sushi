@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
    <span class="mt-2"><h2>Creación nuevo usuario</h2>
</div>

@if(count($errors)>0)

    <div class="alert alert-danger mt-2" role="alert">
        <ul>
            @foreach($errors->all() as $error)
               <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>

@endif


<form class="formulario-crear" action="{{ url('/users') }}" method="post" enctype="multipart/form-data">
@csrf
    <div class="row m:0">
        <div class="col-lg-6 col-xs-12">
            <div class="form-group">
                <label for="rut">Rut:</label>
                <input placeholder="187520724" type="number" class="form-control" name="rut" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="rut"> 
            </div>

            <div class="form-group">
                <label for="name">Nombre:</label>
                <input placeholder="Carlos Camaño" type="text" class="form-control" name="name" id="name">
            </div>

            <div class="form-group">
                <label for="email">Correo:</label>
                <input placeholder="ccamaño@gmail.com" type="text" class="form-control" name="email" id="email">
                <div class="invalid-feedback">El rut ingresado no es válido</div>

            </div>

            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input placeholder="Pasaje 7 casa #108 Hualpén" type="text" class="form-control" name="direccion" id="direccion">
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
            <div class="mb-3" >
                <input type="double" name="latitud" id="latitud"  class="form-control" hidden>
            </div>

            <div class="mb-3" >
                <input type="double" name="longitud" id="longitud"  class="form-control" hidden>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control" name="imagen" value="" id="imagen" accept="image/png, image/jpeg, image/jpg, image/svg">
            </div>

        </div>

        <div class="col-lg-6 col-xs-12 mb-2">
            <label for="celular">Celular:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">+56</span>
                </div>
                <input placeholder="930324576"type="number" class="form-control" name="celular" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="celular">
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input placeholder="412356743" type="number" class="form-control" name="telefono" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="telefono">
            </div>

            <div class="form-group">
                <label for="Contraseña">Contraseña:</label>
                <input placeholder="carlitos90" type="password" class="form-control" name="password" id="Contraseña">
            </div>

            <div class="form-group">
                <label for="id_rol">Rol:</label>
                <select name="rolName" id="id_rol" class="form-control">
                    <option value="">Seleccione un rol</option>
                    @foreach($datos as $roles)
                        <option value="{{ $roles->id }}">
                        {{ $roles->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <label for="" class="form-label">Local donde trabaja</label><br>
            <select multiple="multiple" required class="form-control localSelect" name="local[]"></select>
        </div>
        

        <style>
            #usuario{
                background-color: rgb(18,19,23);
            }
            body.light #usuario{
            background-color: #cc3300;
            }
            
        </style>
        <script>
            window.onload = function(){
                var locales = {!! json_encode($locales->toArray()) !!};
                $('.localSelect').empty();
                $('.localSelect').append($("<option/>", {value: '',text: ''}));
                for (i=0; i<locales.length; i++) {
                    $('.localSelect').append($("<option/>", {
                        value: locales[i].id,
                        text: locales[i].nombre
                    }));
                }
                $('.localSelect').select2({
                    'selectionCssClass' : 'form-control',
                    'placeholder' : 'Seleccione',
                });
            }
        </script>
        <script>
            function destroy_imagen($id){
                $.ajax({
                    url: "{{ url('users/destroy_imagen' )}}"+'/'+$id,
                    type: "DELETE",
                    data: {
                        // 
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(){
                        //
                    },
                    success: function (data) {
                        $('#divShow').addClass('d-none');
                    },
                    error: function (error) {
                    }
                });
            }
        </script>
    </div>
    <input class="btn btn-success" type="submit" value="Guardar">

<a class="btn btn-secondary" href="{{ url('users/') }}">Cancelar</a>
</form>
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

@endsection

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    $('.formulario-crear').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Estas seguro que quieres agregar un nuevo usuario?',
        showDenyButton: true,
        confirmButtonText: 'Sí, agregar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('El usuario no ha sido agregado', '', 'info')
        }
        })
        
    });
</script>
@endsection