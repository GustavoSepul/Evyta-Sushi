@extends('layouts.layout-landing')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<style>
    .clasificacion input[type='radio'] {
    opacity: 0;
  }
  .clasificacion label {
    font-size: 50px;
    color:rgb(150, 150, 150);
    cursor: pointer;
  }
  .clasificacion label:hover {
    color: rgb(217, 215, 11);
  }
   .activo + label{
   color: rgb(255, 230, 0) !important;
   }
</style>

<h1>Dejar un comentario</h1>
<form action="{{url('/')}}" method="POST" class="col-9">
  <p class="clasificacion">
          <input id="radio1" type="radio" name="estrellas" value="1"><!--
        --><label for="radio1">★</label><!--
        --><input id="radio2" type="radio" name="estrellas" value="2"><!--
        --><label for="radio2">★</label><!--
        --><input id="radio3" type="radio" name="estrellas" value="3"><!--
        --><label for="radio3">★</label><!--
        --><input id="radio4" type="radio" name="estrellas" value="4"><!--
        --><label for="radio4">★</label><!--
        --><input id="radio5" type="radio" name="estrellas" value="5"><!--
        --><label for="radio5">★</label>
  </p>
    <input type="number" name="calificacion" id="calificacion"  class="form-control">

    <div class="row">
        <label for="" class="form-label"> Nombre: </label>
        <input class="form-control" id="name" type="text" name="name"> 
    </div>
    <div class="row">
        <label for="" class="form-label"> Opinión :</label>
        <textarea class="form-control" id="opinion" name="opinion"></textarea>   
    </div>

      <button type="submit" name="submit" id="submit" class="btn btn-primary">Añadir Comentario</button>

      <a href="" class="btn btn-secondary">Cancelar</a>
</form>

  <script>
    // $(".clasificacion").find("input").change(function(){
    // var valor = $(this).val()
    // $(".clasificacion").find("input").removeClass("activo")
    // $(".clasificacion").find("input").each(function(index){
    //     if(index+1<=valor){
    //     $(this).addClass("activo")
    //     }
    // })
    // document.getElementById("calificacion").value = valor;
    // })

    $(".clasificacion").find("label").mouseover(function(){
    var valor = $(this).prev("input").val()
    $(".clasificacion").find("input").removeClass("activo")
    $(".clasificacion").find("input").each(function(index){
        if(index+1<=valor){
        $(this).addClass("activo")
        }
    document.getElementById("calificacion").value = valor;
    })
    })



  </script>
@endsection