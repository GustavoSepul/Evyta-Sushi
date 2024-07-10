@extends('layouts.layout-landing')

@section('content')
    <div class="row m-0 p-4">
        <div class="col-12 text-center">
            <span style="font-size: 30px;">Perfil del usuario</span>
        </div>   
    </div>

<div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
            <div class="card p-4 bg-white">
                <div class="d-flex flex-column justify-content-center align-items-center">
                @if(isset($users->imagen))
                <div class="circular--landscape">
                <img src="{{ asset('storage').'/'.$users->imagen }}">
                </div>
                @else
                <img class="circular--landscape2" src="https://upload.wikimedia.org/wikipedia/commons/0/09/Man_Silhouette.png">
                @endif
                    <p class="lead mt-3">
                        <strong>
                            {{ isset($users->name)?$users->name:old('name') }}
                        </strong>
                    </p>
                    <p class="lead">
                        <strong>
                            {{ isset($users->rut)?$users->rut:old('rut') }}
                        </strong>  
                    </p>
                    <div class="text mt-3"> 
                        <p class="lead">Correo: {{ isset($users->email)?$users->email:old('email') }}</p>
                        <p class="lead">Celular: {{ isset($users->celular)?$users->celular:old('celular') }}</p>
                        <p class="lead">Teléfono: {{ isset($users->telefono)?$users->telefono:old('telefono') }}</p>
                        <p class="lead">Dirección: {{ isset($users->direccion)?$users->direccion:old('direccion') }}</p>
                    </div>
                        <div class=" d-flex m-2"> <a class="btn btn-dark" href="{{ url('editarperfil/'.Auth::user()->id) }}">Editar perfil</a> </div>
                        <a class="btn btn-secondary" href="{{ url('/') }}">Regresar</a>
                    </a>
                </div>
            </div>
        </div>
</div>

<style>
.circular--landscape2 {
  display: inline-block;
  position: relative;
  width: 200px;
  height: 200px;
  overflow: hidden;
  border-radius: 50%;
}

.circular--landscape2 img {
  width: auto;
  height: 100%;
  margin-left: -50px;
}
</style>
@endsection