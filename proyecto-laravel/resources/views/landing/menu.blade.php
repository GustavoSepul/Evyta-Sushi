@extends('layouts.layout-landing')

@section('content')
    <div class="col-12 text-center py-1" style="background-image:url('https://img.freepik.com/foto-gratis/arreglo-sushi-endecha-plana-sobre-fondo-pizarra_23-2148224566.jpg?w=2000');">
        <img class="img-fluid" style="width:900px; height:1400px;" src="{{asset('storage/sushi-vip.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:1400px;" src="{{asset('storage/sushi-premium.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:1400px;" src="{{asset('storage/sushi-mixtos-o-fritos.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:1400px;" src="{{asset('storage/hand-roll.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:1400px;" src="{{asset('storage/fritos.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:1400px;" src="{{asset('storage/pizzas.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:600px;" src="{{asset('storage/combo-1.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:600px;" src="{{asset('storage/combo-2.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:600px;" src="{{asset('storage/combo-3.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:600px;" src="{{asset('storage/combo-4.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:600px;" src="{{asset('storage/combo-5.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:600px;" src="{{asset('storage/combo-6.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:600px;" src="{{asset('storage/combo-7.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:600px;" src="{{asset('storage/combo-8.jpeg')}}" alt="">
        <img class="img-fluid" style="width:900px; height:600px;" src="{{asset('storage/combo-9.jpeg')}}" alt="">
    </div>
    <style>
    #menu{
        background-color: #cc3300;
        transform: translateY(-3px);
        box-shadow: 0 4px 17px rgba(0, 0, 0, 0.35);
    }
    </style>
@endsection