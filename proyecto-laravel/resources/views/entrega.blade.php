@extends('layouts.layout-landing')

@section('content')

<h1>Zona de entrega</h1>


    <div class="col-9">
        <input type="text" name="" value="-37.4635782,-72.3192615" id="direccionEditar" class="form-control" hidden>
    </div>
    <button onclick="return mostrarLugar();" 

    type="button" class="btn btn-warning fas fa-plane" 

    href="https://www.google.cl/maps/preview" target="_blank">Ir a Google Maps </button>

<script>
function mostrarLugar(){
  let item = document.getElementById('direccionEditar')
  if(item){
    window.open('https://google.cl/maps/place/'+item.value, '_blank');
  }  
  return false; //No ejecutar el evento.
}
</script>
@endsection