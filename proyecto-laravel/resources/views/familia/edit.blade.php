@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Editar categoría</h2>
</div>

<form class="formulario-editar" action="{{ url('/familia/'.$familia->id) }}" method="post" enctype="multipart/form-data" class="col-9">
@csrf
{{ method_field('PATCH') }}

@include('familia.form',['modo'=>'Editar'])

</form>

<script>
    window.onload = function(){
        var subfamilia = {!! json_encode($subfamilias) !!};
        var allSubfamilias = {!! json_encode($allSubfamilias->toArray()) !!};
        for (j=0; j<subfamilia.length; j++) {
            $('.subcategoriaSelect').append($("<option/>", {
                value: subfamilia[j].id,
                text: subfamilia[j].nombre,
                selected: true
            }));
        }
        for (i=0; i<allSubfamilias.length; i++) {
            var flag = false;
            for(j=0; j<permiso.length; j++){
                if(allSubfamilias[i].id == permiso[j].id) flag = true;
            }
            if(!flag){
                $('.subcategoriaSelect').append($("<option/>", {
                    value: allSubfamilias[i].id,
                    text: allSubfamilias[i].nombre
                }));
            }
        }
        $('.subcategoriaSelect').select2({
            'selectionCssClass' : 'form-control',
            'dropdownAutoWidth': true,
        });

        var tipo = {!! json_encode($tipos) !!};
        var allTipos = {!! json_encode($allTipos->toArray()) !!};
        for (j=0; j<tipo.length; j++) {
            $('.tipoSelect').append($("<option/>", {
                value: tipo[j].id,
                text: tipo[j].nombre,
                selected: true
            }));
        }
        for (i=0; i<allTipos.length; i++) {
            var flag = false;
            for(j=0; j<tipo.length; j++){
                if(allTipos[i].id == tipo[j].id) flag = true;
            }
            if(!flag){
                $('.tipoSelect').append($("<option/>", {
                    value: allTipos[i].id,
                    text: allTipos[i].nombre
                }));
            }
        }
        $('.tipoSelect').select2({
            'selectionCssClass' : 'form-control',
            'dropdownAutoWidth': true,
        });
    };
</script>

@endsection