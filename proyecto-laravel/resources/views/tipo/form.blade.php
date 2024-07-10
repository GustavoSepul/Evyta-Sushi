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
    <input type="text" class="form-control" placeholder="VIP" name="nombre" value="{{ isset($tipo->nombre)?$tipo->nombre:old('nombre') }}" id="nombre">
</div>

<input class="btn btn-success" type="submit" value="Guardar">

<a class="btn btn-secondary" href="{{ url('tipo/') }}">Cancelar</a>

<style>
    #tipo{
        background-color: rgb(18,19,23);
    }
    body.light #tipo{
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
        title: '¿Estas seguro que quieres agregar un nuevo tipo?',
        showDenyButton: true,
        confirmButtonText: 'Sí, agregar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('El tipo no ha sido agregado', '', 'info')
        }
        })
        
    });
</script>

@endsection