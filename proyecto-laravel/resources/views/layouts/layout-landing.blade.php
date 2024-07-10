<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Evita Sushi</title>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet"> 
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>@stack('styles')
<style>
.circular--landscape {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
  overflow: hidden;
  border-radius: 50%;
}
.barra1 {
    background: rgb(251,70,58);
    background: linear-gradient(180deg, rgba(251,70,58,1) 0%, rgba(246,92,34,1) 50%, rgba(240,105,16,1) 100%);
}
.circular--landscape img {
  width: auto;
  height: 100%;
  margin-left: 0px;
  border: solid;
  border-color: white;
}
.circular--landscape img:hover{
  border-color: black;
  
}
.card-container .card:not(.highlight-card) {
    background-color: transparent;
    border-color: transparent;
    box-shadow: 0 4px 17px rgba(0, 0, 0, 0.2);
}

.card-container .card:not(.highlight-card):hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 17px rgba(0, 0, 0, 0.35);
}
.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 17px rgba(0, 0, 0, 0.35);
}
</style>
</head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark sticky-top barra1">
        <div class="circular--landscape">
        <a href="{{url('/')}}"><img class="circular--landscape animate__animated animate__pulse" src="{{asset('storage/logo.png')}}" alt="Logo evita sushi"></a>
        </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item m-2 text-center">
                        <div class="card-container">
                            <a id="inicio" class="nav-link text-white card" href="{{url('/')}}">Evyta Sushi</a>
                        </div>
                    </li>
                    <li class="nav-item m-2 text-center">
                        <div class="card-container">
                            <a id="catalogo" class="nav-link text-white card" href="{{route('catalogo')}}">Catálogo</a>
                        </div>
                    </li>
                    <li class="nav-item m-2 text-center">
                        <div class="card-container">
                            <a id="mapas" class="nav-link text-white card" href="{{url('mapas')}}">Mapa Locales</a>
                        </div>
                    </li>
                    <li class="nav-item m-2 text-center">
                        <div class="card-container">
                            <a id="menu" class="nav-link text-white card" href="{{url('menu')}}">Menú</a>
                        </div>
                    </li>
                </ul>
                <span class="navbar-text mr-4">
                    <div class="dropdown">
                            @guest
                                <a class="btn btn-secondary text-white" href="{{route('ingresar')}}" role="button">
                                    Ingresar / Registrarse
                                </a>
                            @else
                                <button class="text-white mx-4 carrito" id="carrovacio" data-feather="shopping-cart" data-toggle="modal" data-target="#exampleModal" type="button" style="cursor:pointer;" onclick="datoscarrito({{Auth::user()->id}})"></button>
                                <span class="badge badge-danger" id="count2"></span>
                                <a class="btn btn-dark dropdown-toggle text-white" href="#" role="button" id="dropdown-perfil" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-perfil">
                                <a class="dropdown-item" href="{{url('verperfil/'.Auth::user()->id)}}">Ver perfil</a>
                                <a class="dropdown-item" href="{{url('mispedidos/'.Auth::user()->id)}}">Ver pedidos</a>
                                @role('administrador')
                                    <a class="dropdown-item" href="{{route('administrador')}}">Volver a administrador</a>
                                @endrole
                                @role('repartidor')
                                    <a class="dropdown-item" href="{{route('pedidos')}}">Volver a pedidos</a>
                                @endrole
                                @role('vendedor')
                                    <a class="dropdown-item" href="{{route('pedidos')}}">Volver a pedidos</a>
                                @endrole
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Cerrar sesión') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </div>
                            @endauth
                      </div>
                </span>
            </div>
        </nav>
        <div class="container2">
        @yield('content')
        </div>
        <footer class="bg-dark text-white mt-2 navbar-fixed-bottom">
            <div class="row m-0 py-2">
                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 col-xs-12 text-center">
                    <span class="h2">Información de contacto</span>
                    <br>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                    </svg>
                    <span>Whatsapp +56981351797</span>
                </div>
                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 col-xs-12 text-center">
                    <span class="h2">Horario de atención</span>
                    <br>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                    </svg>
                    <span>Lunes a jueves de 14:00 a 22:00</span>
                    <br>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                    </svg>
                    <span>Viernes y Sabados 15:00 a 23:00</span>
                </div>
                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 col-xs-12 text-center">
                    <span class="h2">Redes Sociales</span>
                    <br>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                    </svg>
                    <a class="text-decoration-none text-white" href="https://www.instagram.com/evyta.sushi.coihueco/"><span>evyta.sushi.coihueco</span></a>
                    <br>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                    </svg>
                    <a class="text-decoration-none text-white" href="https://www.instagram.com/evyta.sushi.bulnes/"><span>evyta.sushi.bulnes</span></a>
                </div>
            </div>
        </footer>
        <div class="modal fade" id="verdetalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title text-dark" id="exampleModalLongTitle">Información del producto</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body text-dark text-center">
                      <img id="imagenProducto" src="" alt="" style="height: 200px; weidth: 200px;"><br>
                      <p id="nombreFamiliaProducto"></p><br>
                      <div class="row m-0">
                        <div class="col-6" style="border-right: 1px solid;">
                          <h4>Subcategorías</h2>
                          <p id="subfamiliaProducto"></p>
                        </div>
                        <div class="col-6">
                            <h4>Tipos</h2>
                            <p id="tipoProducto"></p>
                        </div>
                        <div class="col-6" style="border-right: 1px solid;">
                          <h4>Locales</h2>
                            <p id="localProducto"></p>
                        </div>
                        <div class="col-6">
                          <h4>Ingredientes</h2>
                            <p id="ingredienteProducto"></p>
                        </div>
                      </div>
                    <h5 id="disponibilidadPrecioProducto"></h5>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
      </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Resumen de compra</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row" id="dato" >

              <span id="subtotal"></span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar carrito</button>
              <a type="button" href="{{route('carrito')}}" class="btn btn-success">Ir a pagar</a>
            </div>
          </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>@stack('styles')
    <script src="https://unpkg.com/feather-icons"></script> 
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    AOS.init({
        duration: 1000,
        delay: 200
    });
    </script>
    <script>
        feather.replace()
    </script>
    <style>
        #count2{
            position: relative;
            top: -10px;
            left: -35px;
        }
        .badge{
            font-weight: 450;
        }
        .carrito:hover{
        cursor:pointer;
        }
        #map{
            max-width: 100%;
            height: 500px;
        }
        @keyframes rotate {from {transform: rotate(0deg);}
            to {transform: rotate(360deg);}}
        @-webkit-keyframes rotate {from {-webkit-transform: rotate(0deg);}
        to {-webkit-transform: rotate(360deg);}}
        .logo_vacio{
            -webkit-animation: 3s rotate linear infinite;
            animation: 3s rotate linear infinite;
            -webkit-transform-origin: 50% 50%;
            transform-origin: 50% 50%;
        }
        .container2{
            min-height: calc(72.2vh);
        }
        footer {
        position:relative;
        left:0px;
        bottom:0px;
        width:100%;
        }
    </style>
    <script>

        window.onload=function(){
            window.localStorage.clear();
        $.ajax({
          url: "{{ url('cantidad_productos' )}}",
            type: "GET",
            data: {
                // 
            },
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                var j = 0;
                const button = document.getElementById('count2');
                data.forEach(element=>j+=element.cantidad);
                function notificaciones(j){
                    button.hidden= false;
                    document.getElementById("count2").innerHTML=j;
                };
                notificaciones(j);
            },
            error: function(error){
            }
        });
        

        }
    </script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
      function verdetalles($id) {
        $.ajax({
            url: "{{ url('verdetalles' )}}" + '/' + $id,
            type: "GET",
            data: {
                // 
            },
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                //
            },
            success: function(data) {
                console.log(data.info);
                var subfamilia = "";
                var tipo = "";
                var local = "Disponible en: ";
                var ingrediente = "";
                var disponibilidadprecio = "$" + data.info[0].precio;
                if (data.info[0].imagen != "") {
                    $('#imagenProducto').attr("src", "{{ asset('storage').'/'}}" + data.info[0].imagen);
                } else {
                    $('#imagenProducto').attr("src", 'https://electroesencial.com/wp-content/themes/consultix/images/no-image-found-360x250.png');
                }
                $('#nombreFamiliaProducto').text(data.info[0].nombre_familia + ": " + data.info[0].nombre_producto);
                data.info.forEach(element => {
                    if (subfamilia.search(element.nombre_subfamilia) == -1) {
                        subfamilia += element.nombre_subfamilia + ", ";
                    }
                });
                $('#subfamiliaProducto').text(subfamilia.substring(0, subfamilia.length - 2) + ".");
                data.info.forEach(element => {
                    if (tipo.search(element.nombre_tipo) == -1) {
                        tipo += element.nombre_tipo + ", ";
                    }
                });
                $('#tipoProducto').text(tipo.substring(0, tipo.length - 2) + ".");
                data.info.forEach(element => {
                    if (local.search(element.nombre_local) == -1) {
                        local += element.nombre_local + ", ";
                    }
                });
                $('#localProducto').text(local.substring(0, local.length - 2) + ".");
                data.info.forEach(element => {
                    if (ingrediente.search(element.nombre_ingrediente) == -1) {
                        ingrediente += element.nombre_ingrediente + ", ";
                    }
                });
                $('#ingredienteProducto').text(ingrediente.substring(0, ingrediente.length - 2) + ".");
                $('#disponibilidadPrecioProducto').text(disponibilidadprecio);
            },
            error: function(error) {
                console.log(error);
            }
        });
      }

      function agregaralcarrito($otherid, $id){
        var cantidad = document.getElementById($otherid).value;
        $.ajax({
          url: "{{ url('agregaralcarrito' )}}" + '/' + $id + '/' + cantidad,
            type: "GET",
            data: {
                // 
            },
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                Swal.fire({
                position: 'bottom-end',
                icon: 'success',
                title: 'Producto(s) agregado(s) con éxito',
                showConfirmButton: false,
                timer: 1500
                });
                setTimeout(() => {window.location.href = "";}, "1500")
            },
            error: function(error){
            }
        });
      }

    function datoscarrito($id_usuario){
        $.ajax({
            url: "{{ url('datoscarrito')}}"+'/'+$id_usuario,
            type: "GET",
            data: {
                // 
            },
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                //
            },
            success: function (data) {
                if(window.localStorage.getItem('carro') == null){
                var i = 0;
                
                var element=document.getElementById('dato');

                $.each(data,function(i,producto){
                    
                    var divimagen = document.createElement('div');
                    divimagen.setAttribute('id','idproducto');
                    divimagen.setAttribute('class','col-3');
                    var imagen = document.createElement('img');
                    imagen.src= "storage/"+producto.imagen;
                    console.log(imagen.src);
                    imagen.width= 100;
                    imagen.height= 100;
                    divimagen.appendChild(imagen);
                    element.appendChild(divimagen);
                    var divinfo = document.createElement('div');
                    divinfo.setAttribute('class','col-9',);
                    var info = "<span>"+"<strong>"+producto.nombre+"</strong>"+"<br>"+producto.descripcion+"<br>"+"<strong>"+producto.cantidad+"x $"+producto.precio+"</strong>"+"</span> <hr>";
                    divinfo.insertAdjacentHTML('beforeend',info);
                    element.appendChild(divinfo);
                    
                })
                element.insertAdjacentHTML('afterend','<hr>');
                var subtotal = "<span class='pl-1'> SUBTOTAL : $"+data[0].subtotal+"</span>";
                element.insertAdjacentHTML('afterend',subtotal);
                window.localStorage.setItem('carro','Juan');
                }
            },
            error: function (error) {
            }
        });
    }
</script>
@stack('scripts')
</body>
</html>