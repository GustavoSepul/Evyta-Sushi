@extends('layouts.layout-landing')

@section('content')
    <form class="formulario-editar" action="{{ url('/guardarperfil/'.$users->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
    <div class="row m-0 p-4">
        <div class="col-12 text-center">
            <span style="font-size: 30px;">Editar su perfil</span>
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
    <div class="form-group col-12">
        <label for="rut">Rut:</label>
        <input placeholder="187520724" type="number" class="form-control" name="rut" value="{{ isset($users->rut)?$users->rut:old('rut') }}" id="rut" disabled>
    </div>

    <div class="form-group col-12">
        <label for="email">Correo:</label>
        <input placeholder="ccamaño@gmail.com" type="text" class="form-control" name="email" value="{{ isset($users->email)?$users->email:old('email') }}" id="email" disabled>
    </div>

    <div class="form-group col-12">
        <label for="name">Nombre:</label>
        <input placeholder="Carlos Camaño" type="text" class="form-control" name="name" value="{{ isset($users->name)?$users->name:old('name') }}" id="name">
    </div>

    <div class="form-group col-12">
        <label for="direccion">Dirección:</label>
        <input placeholder="Pasaje 7 casa #108 Hualpén" type="text" class="form-control" name="direccion" value="{{ isset($users->direccion)?$users->direccion:old('direccion') }}" id="direccion">
    </div>

    <div class="form-group col-12">
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
    </div>

    <div class="mb-3" >
            <input type="double" name="latitud" id="latitud" value="{{ isset($users->latitud)?$users->latitud:old('latitud') }}" class="form-control" hidden>
    </div>

            <div class="mb-3" >
                <input type="double" name="longitud" id="longitud" value="{{ isset($users->longitud)?$users->longitud:old('longitud') }}" class="form-control" hidden>
            </div>
    <div class="input-group col-12">
        <label for="celular">Celular:</label>
    </div>
    <div class="input-group col-12">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">+56</span>
        </div>
        <input placeholder="930324576"type="text" class="form-control" name="celular" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="{{ isset($users->celular)?$users->celular:old('celular') }}" id="celular">
    </div>

    <div class="form-group col-12">
        <label for="telefono">Teléfono:</label>
        <input placeholder="412356743" type="number" class="form-control" name="telefono" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="{{ isset($users->telefono)?$users->telefono:old('telefono') }}" id="telefono">
    </div>
    <input hidden type="text" id="idUser" value="{{isset($users->id)?$users->id:old('id')}}">

    <div class="form-group col-12">
        <label for="imagen">Imagen:</label>
        <br>
        <div class="row m:0 mb-2">
            <div class="col-2 p-0">
                @if(isset($users->imagen))
                <img class="img-thumbnail img-fluid" id="divShow" src="{{ asset('storage').'/'.$users->imagen }}" alt="" style="width:100%; height:100%">
                @else
                <img class="img-thumbnail img-fluid" src="https://upload.wikimedia.org/wikipedia/commons/0/09/Man_Silhouette.png" alt="" style="width:100%; height:100%">
                @endif
            </div>
            <div class="col-10">
                <input type="file" class="form-control" name="imagen" value="" id="imagen" accept="image/png, image/jpeg, image/jpg, image/svg">
                @if(isset($users->imagen))
                <a  class="btn bg-danger mt-2 btn-sm formulario-eliminar" onclick="destroy_imagen({{$users->id}})" style="color:white" href="">Borrar Imagen</a>
                @endif
            </div>
        </div>
        <input class="btn btn-success" type="submit" value="Guardar">
        <a class="btn btn-secondary" href="{{url('verperfil/'.Auth::user()->id)}}">Regresar</a>
    </div>
</div>
    </form>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script>
        var users = {!! json_encode($users->toArray()) !!};
        var marker;
        var coords ={};
        initMap = function()
        {

            coords = {
                lng: {{$users->longitud}},
                lat: {{$users->latitud}}
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


</script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCJo0d84q3_W-zY6-m9_QJGa1UTY_vn2es&callback=initMap" async defer></script>

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
@endsection