@if(count($errors)>0)

    <div class="alert alert-danger mt-2" role="alert">
        <ul>
            @foreach($errors->all() as $error)
               <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
    
@endif

    <div class="form-group" >
        <label for="" class="form-label">Nombre del ingrediente</label>
        <input id="nombre" name="nombre" type="text" class="form-control" value="{{ isset($ingrediente->nombre)?$ingrediente->nombre:old('nombre') }}">
    </div>
   
    <button type="submit" class="btn btn-success" tabindex="8">Guardar</button> 

    <a href="/ingrediente" class="btn btn-secondary" tabindex="9">Cancelar</a>
    
<style>
    #ingrediente{
        background-color: rgb(18,19,23);
    }

    body.light #ingrediente{
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
</script>

@endsection