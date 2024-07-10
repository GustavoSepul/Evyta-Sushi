@if(count($errors)>0)

    <div class="alert alert-danger mt-2" role="alert">
        <ul>
            @foreach($errors->all() as $error)
               <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
    

@endif
<div class="row m:0">
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label for="rut">Rut:</label>
            <input placeholder="187520724" type="number" class="form-control" name="rut" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="{{ isset($users->rut)?$users->rut:old('rut') }}" id="rut" disabled> 
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input placeholder="Pasaje 7 casa #108 Hualpén" type="text" class="form-control" name="direccion" value="{{ isset($users->direccion)?$users->direccion:old('direccion') }}" id="direccion">
        </div>

        <button type="button" id="open" class="btn btn-info" data-toggle="modal" data-target="#myModal">
            Seleccionar ubicación en el mapa
        </button>

        <div class="modal" id="myModal">
            <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                                <h4 class="modal-title">Seleccione su ubicación en el mapa</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                            <div class="modal-body">
                                <div id="map"></div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>

                    </div>
            </div>
        </div>
            <div class="mb-3" >
                <input type="double" name="latitud" id="latitud" value="{{$users->latitud}}" class="form-control" hidden>
            </div>

            <div class="mb-3" >
                <input type="double" name="longitud" id="longitud" value="{{$users->longitud}}" class="form-control" hidden>
            </div>
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input placeholder="Carlos Camaño" type="text" class="form-control" name="name" value="{{ isset($users->name)?$users->name:old('name') }}" id="name">
        </div>

                <label for="imagen">Imagen:</label>

                <div class="text-center">
                    @if(isset($users->imagen))
                    <img class="img-thumbnail img-fluid" id="divShow" src="{{ asset('storage').'/'.$users->imagen }}" alt="" style="width:300px;"><br>
                    @else
                    <img class="img-thumbnail img-fluid" src="https://upload.wikimedia.org/wikipedia/commons/0/09/Man_Silhouette.png" alt="" style="width:300px;"><br>
                    @endif
                
                    <input type="file" class="form-control mt-2" name="imagen" value="" id="imagen" accept="image/png, image/jpeg, image/jpg, image/svg">
                    @if(isset($users->imagen))
                    <a  class="btn bg-danger mt-2 btn-sm formulario-eliminar" onclick="destroy_imagen({{$users->id}})" style="color:white" href="">Borrar Imagen</a>
                    @endif
                </div>
    </div>

    <div class="col-lg-6 col-xs-12 mb-2">
        <div class="form-group">
            <label for="email">Correo:</label>
            <input placeholder="ccamaño@gmail.com" type="text" class="form-control" name="email" value="{{ isset($users->email)?$users->email:old('email') }}" id="email" disabled>
            <div class="invalid-feedback">El rut ingresado no es válido</div>
        </div>

        <label for="celular">Celular:</label>
        
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">+56</span>
            </div>
            <input placeholder="930324576"type="number" class="form-control" name="celular" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="{{ isset($users->celular)?$users->celular:old('celular') }}" id="celular">
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input placeholder="412356743" type="number" class="form-control" name="telefono" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="{{ isset($users->telefono)?$users->telefono:old('telefono') }}" id="telefono">
        </div>

        @if($modo == 'Crear')
        <div class="form-group">
            <label for="Contraseña">Contraseña:</label>
            <input placeholder="carlitos90" type="password" class="form-control" name="password" value="{{ isset($users->password)?$users->password:old('password') }}" id="Contraseña">
        </div>
        @endif
        <div class="form-group">
            <label for="id_rol">Rol:</label>
            <select name="rolName" id="id_rol" class="form-control">
                <option value="">Seleccione un rol</option>
                @foreach($datos as $roles)
                    <option value="{{ $roles->id }}">
                    {{ $roles->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <label for="" class="form-label">Local donde trabaja</label><br>
        <select multiple="multiple" required class="form-control localSelect" name="local[]"></select>
        <div id="map" hidden></div>
        <input hidden type="text" id="rolUser" value="{{$users->getRoleNames()->first()}}">
        <input hidden type="text" id="idUser" value="{{isset($users->id)?$users->id:old('id')}}">


    </div>
    
</div>
<div class="mt-2">
<input class="btn btn-success" type="submit" value="Guardar">

<a class="btn btn-secondary" href="{{ url('users/') }}">Cancelar</a>
</div>

    <style>
        #usuario{
            background-color: rgb(18,19,23);
        }
        body.light #usuario{
        background-color: #cc3300;
    }
    </style>

    <script>
        function destroy_imagen($id){
            $.ajax({
                url: "{{ url('users/destroy_imagen' )}}"+'/'+$id,
                type: "DELETE",
                data: {
                    // 
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(){
                    //
                },
                success: function (data) {
                    $('#divShow').addClass('d-none');
                },
                error: function (error) {
                }
            });
        }
    </script>

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('eliminar') == 'ok')

        <script>
            Swal.fire(
            '¡Eliminada!',
            'La imagen se eliminó con éxito.',
            'success'
            )
        </script>

@endif

<script>

    $('.formulario-eliminar').click(function(e){
        e.preventDefault();
        $id=$('#idUser').val();
        Swal.fire({
        title: '¿Estas seguro?',
        text: "Esta imagen se eliminara definitivamente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, eliminar!',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
            this.submit();
        }
        })
        return url('users/'+$id+'/edit');
    });

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
        title: '¿Estas seguro que quieres agregar un nuevo usuario?',
        showDenyButton: true,
        confirmButtonText: 'Sí, agregar',
        denyButtonText: `Cancelar`,
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else if (result.isDenied) {
            Swal.fire('El usuario no ha sido agregado', '', 'info')
        }
        })
        
    });
</script>
@endsection