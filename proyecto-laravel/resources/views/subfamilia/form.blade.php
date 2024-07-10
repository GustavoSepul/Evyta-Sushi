@if(count($errors)>0)

    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
               <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
    
@endif

<div class="form-group">
    <label for="nombre">Nombre:</label>
    <input required placeholder="Frito" type="text" class="form-control" name="nombre" value="{{ isset($subfamilia->nombre)?$subfamilia->nombre:old('nombre') }}" id="nombre">
    <br>
</div>

<input class="btn btn-success" type="submit" value="Guardar">

<a class="btn btn-secondary" href="{{ url('subfamilia/') }}">Cancelar</a>

<style>
    #subfamilia{
        background-color: rgb(18,19,23);
    }
    body.light #subfamilia{
        background-color: #cc3300;
    }
</style>

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
    
    $('.formulario-crear').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Estas seguro que quieres agregar una nueva subcategoría?',
        showDenyButton: true,
        confirmButtonText: 'Sí, agregar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('La subcategoría no ha sido agregada', '', 'info')
        }
        })
        
    });
</script>

@endsection