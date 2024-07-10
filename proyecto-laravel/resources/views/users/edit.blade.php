@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Editar usuario</h2>
</div>

<form class="formulario-editar" action="{{ url('/users/'.$users->id) }}" method="post" enctype="multipart/form-data">
@csrf
{{ method_field('PATCH') }}

@include('users.form',['modo'=>'Editar'])
<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
    $( document ).ready(function() {
        $.ajax({
            url: "{{ url('getRoles' )}}",
            type: "GET",
            data: {
                // 
            },
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
            },
            success: function (data) {
                var $select = $('#id_rol');
                var $rolUser = $('#rolUser').val();
                $select.find('option').remove();
                data.forEach(rol => {
                    if($rolUser == rol.name){
                        $select.append('<option value=' + rol.id + '>' + rol.name + '</option>');
                    }
                });
                data.forEach(rol => {
                    if($rolUser != rol.name){
                        $select.append('<option value=' + rol.id + '>' + rol.name + '</option>');
                    }
                });
            },
            error: function (error) {
            }
        });
    });
</script>
</form>
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

@endsection
