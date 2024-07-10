@extends('layouts.layout-landing')

@section('content')
    <div class="row m-0">
        <div class="col-8 offset-2 mt-4">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="img-fluid  d-block w-100" style="height: 600px; width: 3500px;" src="{{ asset('storage/first-slide.png') }}" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="img-fluid  d-block w-100" style="height: 600px; width: 3500px;" src="{{ asset('storage/second-slide.png') }}" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="img-fluid  d-block w-100" style="height: 600px; width: 3500px;" src="{{ asset('storage/third-slide.png') }}" alt="Third slide">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
        <div class="col-12 text-center" data-aos="fade-right">
            <hr>
            <span class="d-flex h1">Combos</span>
            <br>
            <div class="card-deck">
                @foreach ($promociones as $promocion)
                    <div class="card">
                        <img class="card-img-top" src="{{asset('storage/'.$promocion->imagen)}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{$promocion->nombre}} x ${{$promocion->precio}}</h5>
                            <p class="card-text">{{$promocion->descripcion}}</p>
                        </div>
                        @auth
                        <div class="card-footer">
                            <small class="w-50 text-center py-2">
                                <a class="text-body carrito" data-toggle="modal" data-target="#verdetalles" onclick="verdetalles({{$promocion->id}})"><i class="fa fa-eye text-primary me-2"></i>Ver detalles</a>
                            </small>
                            <small-w-50 class="text-center py-2">
                                <input required min="1" type="number" name="" id="{{$promocion->precio.$promocion->id}}" value="1" style="width:40px">
                            </small-w-50>
                            <small class="w-50 text-center py-2">
                                <a class="text-body carrito" onclick="agregaralcarrito({{$promocion->precio.$promocion->id}}, {{$promocion->id}})"><i class="fa fa-shopping-bag text-primary me-2"></i>Agregar al carrito</a>
                            </small>
                        </div>
                        @endauth
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12 text-center" data-aos="fade-right">
            <hr>
            <span class="d-flex h1">Pizzas</span>
            <br>
            <div class="card-deck">
                @foreach ($pizzas as $pizza)
                    <div class="card">
                        <img class="card-img-top" src="{{asset('storage/'.$pizza->imagen)}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{$pizza->nombre}} x ${{$pizza->precio}}</h5>
                            <p class="card-text">{{$pizza->descripcion}}</p>
                        </div>
                        @auth
                        <div class="card-footer">
                            <small class="w-50 text-center py-2">
                                <a class="text-body carrito" data-toggle="modal" data-target="#verdetalles" onclick="verdetalles({{$pizza->id}})"><i class="fa fa-eye text-primary me-2"></i>Ver detalles</a>
                            </small>
                            <small-w-50 class="text-center py-2">
                                <input required min="1" type="number" name="" id="{{$pizza->precio.$pizza->id}}" value="1" style="width:40px">
                            </small-w-50>
                            <small class="w-50 text-center py-2">
                                <a class="text-body carrito" onclick="agregaralcarrito({{$pizza->precio.$pizza->id}}, {{$pizza->id}})"><i class="fa fa-shopping-bag text-primary me-2"></i>Agregar al carrito</a>
                            </small>
                        </div>
                        @endauth
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12 text-center" data-aos="fade-right">
            <hr>
            <span class="d-flex h1">Sushis</span>
            <br>
            <div class="card-deck">
                @foreach ($sushis as $sushi)
                    <div class="card">
                        <img class="card-img-top" src="{{asset('storage/'.$sushi->imagen)}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{$sushi->nombre}} x ${{$sushi->precio}}</h5>
                            <p class="card-text">{{$sushi->descripcion}}</p>
                        </div>
                        @auth
                        <div class="card-footer">
                            <small class="w-50 text-center py-2">
                                <a class="text-body carrito" data-toggle="modal" data-target="#verdetalles" onclick="verdetalles({{$sushi->id}})"><i class="fa fa-eye text-primary me-2"></i>Ver detalles</a>
                            </small>
                            <small-w-50 class="text-center py-2">
                                <input required min="1" type="number" name="" id="{{$sushi->precio.$sushi->id}}" value="1" style="width:40px">
                            </small-w-50>
                            <small class="w-50 text-center py-2">
                                <a class="text-body carrito" onclick="agregaralcarrito({{$sushi->precio.$sushi->id}}, {{$sushi->id}})"><i class="fa fa-shopping-bag text-primary me-2"></i>Agregar al carrito</a>
                            </small>
                        </div>
                        @endauth
                    </div>
                @endforeach
            </div>
        </div>
    </div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    #inicio{
        background-color: #cc3300;
        transform: translateY(-3px);
        box-shadow: 0 4px 17px rgba(0, 0, 0, 0.35);
    }
    </style>
@if(session('horario') == 'no')

        <script>
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Estas fuera del horario permitido para comprar'
             })
        </script>

@endif
@endsection
