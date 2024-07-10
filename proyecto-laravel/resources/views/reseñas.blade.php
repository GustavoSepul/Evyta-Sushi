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
   .activo + label{
   color: rgb(255, 230, 0) !important;
   }
</style>

<h1>Comentarios</h1>
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
  <input type="double" name="calificacion" id="calificacion"  class="form-control" disabled>
   <div class="row">
      <label> Nombre: </label> <span id="name-info"></span>
      <input class="form-control" id="name" type="text" name="user" disabled> 
   </div>
   <div class="row">
      <label for="mesg"> Mensaje : <span id="message-info"></span></label>
      <textarea class="form-control" id="message" name="message" rows="4" disabled></textarea>   
   </div>

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

    var valor = 4;
    $(".clasificacion").find("input").each(function(index){
        if(index+1<=valor){
        $(this).addClass("activo")
        }
    document.getElementById("calificacion").value = valor;
    })
    var name = "Gustavo Sepúlveda"
    var opinion = "Muy bueno";
    document.getElementById("name").value = name;
    document.getElementById("message").value = opinion;
  </script>
@endsection