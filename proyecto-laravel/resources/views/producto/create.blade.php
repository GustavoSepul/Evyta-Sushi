@extends('layouts.layout-admin')

@section('content')

<div class="text-center">
    <span class="mt-2"><h2>Creación nuevo producto</h2>
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

    <form action="{{route('producto.store')}}" method="POST" enctype="multipart/form-data" class="formulario-crear">
        <div class="row">
            <div class="col-lg-6 col-xs-12 mb-5">
                @csrf
                <label for="">Nombre</label>
                <input required placeholder="Sushi Premium 20 cortes" class="form-control" type="text" name="nombre" id="nombre"><br>
                <label for="">¿Disponible?</label><br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input checked type="checkbox" aria-label="Checkbox for following text input" name="disponibilidad" id="disponibilidad">
                        </div>
                    </div>
                    <input disabled value="Desmarque la casilla si no lo está" type="text" class="form-control" aria-label="Text input with checkbox">
                </div>
                <label for="">Descripcion</label><br>
                <textarea required placeholder="Sushi premium de 20 cortes, contempla 10 fritos de pollo, palta, queso ..." class="form-control mb-3" name="descripcion" id="descripcion" style="resize:none; width:100%; height:50%"></textarea><br>
                

            </div>
            <div class="col-lg-6 col-xs-12">
                <label for="">Precio</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input required name="precio" id="precio" placeholder="7500" type="number" max="1000000" class="form-control" aria-label="Amount (to the nearest dollar)">
                </div><br>
                <label for="">Categoría a la que pertenece</label><br>
                <select required class="form-control" name="familia" id="familiaSelect"></select><br>
                <label for="" class="form-label">Ingredientes</label>
                <select multiple="multiple" required class="form-control ingredienteSelect" name="ingrediente[]"></select>
                <label for="" class="form-label">Locales</label><br>
                <select multiple="multiple" required class="form-control localSelect" name="local[]"></select><br>
                <label for="">Imagen</label>
                <input class="form-control" type="file" name="imagen" id="imagen" accept="image/png, image/jpeg, image/jpg, image/svg"><br>
            </div>
        </div>
        <input class="btn btn-success" type="submit" value="Guardar">
        <a class="btn btn-secondary" href="{{ url('producto') }}">Cancelar</a>
    </form>

    <style>
        #producto{
            background-color: rgb(18,19,23);
        }
        body.light #producto{
        background-color: #cc3300;
        }
    </style>

    <script>
        window.onload = function(){
            var familia = {!! json_encode($data['familias']->toArray()) !!};
            $('#familiaSelect').append($("<option/>", {value: '',text: ''}));
            for (i=0; i<familia.length; i++) {
                $('#familiaSelect').append($("<option/>", {
                    value: familia[i].id,
                    text: familia[i].nombre
                }));
            }
            $('#familiaSelect').select2({
                'selectionCssClass' : 'form-control',
                'dropdownAutoWidth': true,
                'allowClear': true,
                'placeholder' : 'Seleccione',
            });
            var ingrediente = {!! json_encode($data['ingredientes']->toArray()) !!};
            $('.ingredienteSelect').empty();
            $('.ingredienteSelect').append($("<option/>", {value: '',text: ''}));
            for (i=0; i<ingrediente.length; i++) {
                $('.ingredienteSelect').append($("<option/>", {
                    value: ingrediente[i].id,
                    text: ingrediente[i].nombre
                }));
            }
            $('.ingredienteSelect').select2({
                'selectionCssClass' : 'form-control',
                'dropdownAutoWidth': true,
                'placeholder' : 'Seleccione',
            });

            var local = {!! json_encode($data['locales']->toArray()) !!};
            $('.localSelect').empty();
            $('.localSelect').append($("<option/>", {value: '',text: ''}));
            for (i=0; i<local.length; i++) {
                $('.localSelect').append($("<option/>", {
                    value: local[i].id,
                    text: local[i].nombre
                }));
            }
            $('.localSelect').select2({
                'selectionCssClass' : 'form-control',
                'dropdownAutoWidth': true,
                'placeholder' : 'Seleccione',
            });
        };
    </script>

@endsection

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>     
    $('.formulario-crear').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Estas seguro que quieres agregar un nuevo producto?',
        showDenyButton: true,
        confirmButtonText: 'Sí, agregar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('El producto no ha sido agregado', '', 'info')
        }
        })
        
    });
</script>

@endsection