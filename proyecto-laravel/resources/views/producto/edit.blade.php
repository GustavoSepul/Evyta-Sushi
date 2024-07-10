@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
        <span class="mt-2"><h2>Editar producto</h2>
</div>

@if(count($errors)>0)

<div class="alert alert-danger" role="alert">
    <ul>
        @foreach($errors->all() as $error)
           <li> {{ $error }} </li>
        @endforeach
    </ul>
</div>

@endif

    <div class="container mt-2 mb-2">
        <form action="{{url('/producto/'.$data['producto'][0]->id)}}" method="POST" enctype="multipart/form-data" class="formulario-editar">
            <div class="row m:0">
                <div class="col-lg-6 col-xs-12">
                    @csrf
                    {{ method_field('PATCH') }}
                    <label for="">Nombre</label>
                    <input required value="{{$data['producto'][0]->nombre_producto}}" class="form-control" type="text" name="nombre" id="nombre"><br>
                    <label for="">¿Disponible?</label><br>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="checkbox" aria-label="Checkbox for following text input" name="disponibilidad" id="disponibilidad">
                            </div>
                        </div>
                        <input disabled value="Desmarque la casilla si no lo está" type="text" class="form-control" aria-label="Text input with checkbox"><br>
                    </div>
                    <label for="" class="form-label">Locales</label><br>
                    <select multiple="multiple" required class="form-control localSelect" name="local[]"></select><br>
                    <label for="">Imagen</label><br>
                    <div class="text-center">
                    @if($data['producto'][0]->imagen != "")
                    <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$data['producto'][0]->imagen }}" alt="" style="width:300px;"><br>
                    @endif
                    <input type="file" class="form-control mt-2" name="imagen" value="" id="imagen" accept="image/png, .jpeg, .jpg .svg"><br>
                    </div>
                

                </div>
                <div class="col-lg-6 col-xs-12 mb-5">
                    <label for="">Precio</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input required name="precio" id="precio" value="{{$data['producto'][0]->precio}}" type="number" class="form-control" aria-label="Amount (to the nearest dollar)">
                    </div><br>
                    <label for="">Familia a la que pertenece</label>
                    <select required class="form-control select2" name="familia" id="familia">
                        <option value="{{$data['producto'][0]->id_familia}}">{{$data['producto'][0]->nombre_familia}}</option>
                        @foreach ($data['familias'] as $familia)
                            <option name="id_familia" id="id_familia" value="{{$familia->id}}">{{$familia->nombre}}</option>
                        @endforeach
                    </select><br>
                    <label for="" class="form-label">Ingredientes</label><br>
                    <select multiple="multiple" required class="form-control IngredienteEditar" name="ingredienteEdit[]"></select><br>
                    <label for="">Descripción</label><br>
                    <textarea required class="form-control" name="descripcion" id="descripcion" style="resize:none; width:100%; height:200px">{{$data['producto'][0]->descripcion}}</textarea>
                </div>
            </div>
            <input class="btn btn-success" type="submit" value="Guardar">
            <a class="btn btn-secondary" href="{{ url('producto') }}">Cancelar</a>
        </form>
    </div>

    <style>
        #producto{
            background-color: rgb(18,19,23);
        }
        body.light #producto{
        background-color: #cc3300;
        }
    </style>

    <script type="text/javascript">
        window.onload = function(){
            var producto = {!! json_encode($data['producto']->toArray()) !!};
            if(producto[0]['disponibilidad'] == 1){
                var help = document.getElementById('disponibilidad');
                help.setAttribute('checked',true);
            }
            var ingrediente = {!! json_encode($ingredientes) !!};
            var allIngrediente = {!! json_encode($allIngredientes->toArray()) !!};
            for (j=0; j<ingrediente.length; j++) {
                $('.IngredienteEditar').append($("<option/>", {
                    value: ingrediente[j].id,
                    text: ingrediente[j].nombre,
                    selected: true
                }));
            }
            for (i=0; i<allIngrediente.length; i++) {
                var flag = false;
                for(j=0; j<ingrediente.length; j++){
                    if(allIngrediente[i].id == ingrediente[j].id) flag = true;
                }
                if(!flag){
                    $('.IngredienteEditar').append($("<option/>", {
                        value: allIngrediente[i].id,
                        text: allIngrediente[i].nombre
                    }));
                }
            }
            $('.IngredienteEditar').select2({
                'selectionCssClass' : 'form-control',
                'dropdownAutoWidth': true,
            });

            var local = {!! json_encode($locales) !!};
            var allLocales = {!! json_encode($allLocales->toArray()) !!};
            for (j=0; j<local.length; j++) {
                $('.localSelect').append($("<option/>", {
                    value: local[j].id,
                    text: local[j].nombre,
                    selected: true
                }));
            }
            for (i=0; i<allLocales.length; i++) {
                var flag = false;
                for(j=0; j<local.length; j++){
                    if(allLocales[i].id == local[j].id) flag = true;
                }
                if(!flag){
                    $('.localSelect').append($("<option/>", {
                        value: allLocales[i].id,
                        text: allLocales[i].nombre
                    }));
                }
            }
            $('.localSelect').select2({
                'selectionCssClass' : 'form-control',
                'dropdownAutoWidth': true,
            });
        };
    </script>

@endsection

@section('js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>     
    $('.formulario-editar').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Quieres guardar los cambios?',
        showDenyButton: true,
        confirmButtonText: 'Guardar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('Los cambios no han sido guardados', '', 'info')
        }
        })
        
    });
</script>

@endsection