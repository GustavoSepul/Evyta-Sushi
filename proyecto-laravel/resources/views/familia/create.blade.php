@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Creación nueva categoría</h2>
</div>


<form class="formulario-crear" action="{{ url('/familia') }}" method="post" enctype="multipart/form-data" class="col-9">
@csrf


@include('familia.form',['modo'=>'Crear'])
</form>


<script>
    window.onload = function(){
        var subfamilia = {!! json_encode($data['subfamilias']->toArray()) !!};
        $('.subcategoriaSelect').empty();
        $('.subcategoriaSelect').append($("<option/>", {value: '',text: ''}));
        for (i=0; i<subfamilia.length; i++) {
            $('.subcategoriaSelect').append($("<option/>", {
                value: subfamilia[i].id,
                text: subfamilia[i].nombre
            }));
        }
        $('.subcategoriaSelect').select2({
            'selectionCssClass' : 'form-control',
            'placeholder' : 'Seleccione',
        });

        var tipo = {!! json_encode($data['tipos']->toArray()) !!};
        $('.tipoSelect').empty();
        $('.tipoSelect').append($("<option/>", {value: '',text: ''}));
        for (i=0; i<tipo.length; i++) {
            $('.tipoSelect').append($("<option/>", {
                value: tipo[i].id,
                text: tipo[i].nombre
            }));
        }
        $('.tipoSelect').select2({
            'selectionCssClass' : 'form-control',
            'placeholder' : 'Seleccione',
        });
    };
</script>

@endsection