<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrador</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet"> 
	<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg py-0 sticky-top barra1">
        <img src="{{asset('storage/logo.png')}}"
         class="d-inline-block align-top img-responsive mt-2 ml-2" style="width:100px; height:100px; border-radius:50%" alt="">
        <ul class="navbar-nav mr-auto"></ul>
        <button class="switch" id="switch">
            <span><i class="fas fa-moon"></i></span>
            <span><i class="fas fa-sun"></i></span>
        </button>                
        <span class="navbar-text" style="width:100px">
                <div class="dropdown dropleft drop campana" id="campana" style="display: inline;">
                    <i class="dropdown-toggle campana" id="campanaa" data-feather="bell" style="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i> 
                    <span class="badge badge-danger count" id="count"></span>
                    <div class="dropdown-menu p-2 notis" aria-labelledby="dropdownMenuButton" style="width:500%; overflow:hidden; max-height: 350px; overflow-y: auto;">
                        <form>
                            @forelse($notifications as $notification)
                                <div class="alert alert-success" role="alert">
                                    [{{ $notification->created_at }}] {{$notification->data['origen']}} "{{ $notification->data['name'] }}" @isset($notification->data['extra']) [{{$notification->data['extra']}}] @endisset fue eliminado.
                                    <a data-dismiss="alert" aria-label="Close" class="close" onClick='mark_as_read({!! json_encode($notification->id) !!})'>
                                        X
                                    </a>
                                </div>
                                @if($loop->last)
                                    <a href="#" onClick="mark_all_as_read({{Auth::user()->id}})">
                                        Marcar todas como leidas
                                    </a>
                                @endif
                            @empty
                            <span class="nots">
                            No hay notificaciones sin leer
                            </span>
                            @endforelse
                        </form>
                    </div>
                </div>

                <div class="dropdown dropleft drop" style="display: inline;" >
                    <i class="dropdown-toggle user" id="dropdownMenuButton" data-toggle="dropdown" ria-haspopup="true" aria-expanded="false" data-feather="user" style="width:40%; height:40%;"></i>
                    <div class="dropdown-menu p-2 notis" aria-labelledby="dropdownMenuButton" style="width:500%; overflow:hidden; max-height: 350px; overflow-y: auto; text-align: center;">
                        <a class="btn btn-info text-white mt-2 p-2" href="{{ url('/') }}">Ir a inicio</a>
                        <a class="btn text-white mt-2 p-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="background-color: rgb(255,63,54); border-color:black">{{ __('Cerrar Sesión') }}</a>
                    </div>
                </div>
                <div style="display: inline;">
                    <a id="sideButton" class="btn text-white mt-2 d-xl-none d-lg-none" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="pr-1" data-feather="align-justify" style="color:white;"></i></a>
                </div>
        </span>
    </nav>
    <div class="row m-0">
        <div id="sidebarMenu" class="col-lg-2 col-xl-2 text-center d-none d-lg-block d-xl-block pb-2 menu" style="min-height:950px">
            <nav class="d-lg-block sidebar sticky-top botones" style="top:135px;">
                <div class="position-sticky">
                    <div class="list-group list-group-flush mt-4">
                        @role('administrador')
                        <a id="dashboard" class="btn text-white mt-2 p-2 text-left btn-route botones" href="{{route('administrador')}}" role="button" style="overflow:hidden;"><i class="pr-1" data-feather="grid" style="color:white;"></i>Panel de Control</a>
                        @endrole
                        @canany(['Ver.producto','Crear.producto','Editar.producto','Eliminar.producto'])
                        <a id="producto" class="btn text-white mt-2 p-2 text-left btn-route" href="{{route('producto.index')}}" role="button" style=""><i class="pr-1" data-feather="shopping-bag" style="color:white"></i>Producto</a>
                        @endcan
                        @canany(['Crear.familia','Editar.familia','Eliminar.familia'])
                        <a id="familia" class="btn text-white mt-2 p-2 text-left btn-route ml-3" href="{{route('familia.index')}}" role="button" style=""><i class="pr-1" data-feather="list" style="color:white"></i>Categoría</a>
                        @endcan
                        @canany(['Crear.subfamilia','Editar.subfamilia','Eliminar.subfamilia'])
                        <a id="subfamilia" class="btn text-white mt-2 p-2 text-left btn-route ml-3" href="{{route('subfamilia.index')}}" role="button" style=""><i class="pr-1" data-feather="list" style="color:white"></i>Subcategoría</a>
                        @endcan
                        @canany(['Crear.tipo','Editar.tipo','Eliminar.tipo'])
                        <a id="tipo" class="btn text-white mt-2 p-2 text-left btn-route ml-3" href="{{route('tipo.index')}}" role="button" style=""><i class="pr-1" data-feather="list" style="color:white"></i>Tipo</a>
                        @endcan
                        @canany(['Crear.ingrediente','Editar.ingrediente','Eliminar.ingrediente'])
                        <a id="ingrediente" class="btn text-white mt-2 p-2 text-left btn-route ml-3" href="{{route('ingrediente.index')}}" role="button" style=""><i class="pr-1" data-feather="list" style="color:white"></i>Ingrediente</a>
                        @endcan
                        @canany(['Crear.usuario','Editar.usuario','Eliminar.usuario'])
                        <a id="usuario" class="btn text-white mt-2 p-2 text-left btn-route" href="{{route('users.index')}}" role="button" style=""><i class="pr-1" data-feather="users" style="color:white"></i>Usuarios</a>
                        @endcan
                        @canany(['Crear.permiso','Editar.permiso','Eliminar.permiso'])
                        <a id="permiso" class="btn text-white mt-2 p-2 text-left btn-route ml-3" href="{{route('permiso.index')}}" role="button" style=""><i class="pr-1" data-feather="user-check" style="color:white"></i>Permiso</a>
                        @endcan
                        @canany(['Crear.rol','Editar.rol','Eliminar.rol'])
                        <a id="rol" class="btn text-white mt-2 p-2 text-left btn-route ml-3" href="{{route('rol.index')}}" role="button" style=""><i class="pr-1" data-feather="clipboard" style="color:white"></i>Rol</a>
                        @endcan
                        @canany(['Crear.cupon','Editar.cupon','Eliminar.cupon'])
                        <a id="cupon" class="btn text-white mt-2 p-2 text-left btn-route" href="{{route('cupon.index')}}" role="button" style=""><i class="pr-1" data-feather="gift" style="color:white"></i>Cupón</a>
                        @endcan
                        @canany(['Crear.local','Editar.local','Eliminar.local'])
                        <a id="local" class="btn text-white mt-2 p-2 text-left btn-route" href="{{route('local.index')}}" role="button" style=""><i class="pr-1" data-feather="home" style="color:white"></i>Local</a>
                        @endcan
                        @canany(['Ver.pedidos'])
                        <a id="pedido" class="btn text-white mt-2 p-2 text-left btn-route" href="{{route('pedidos')}}" role="button" style=""><i class="pr-1" data-feather="map" style="color:white"></i>Pedidos</a>
                        @endcan
                        <a class="btn text-white mt-2 p-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="background-color: rgb(255,63,54); border-color:black">{{ __('Cerrar Sesión') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </nav>
        </div>
        <div id="sidebarMenu2" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 pb-2 panel" style="min-height:950px">
            @yield('content')
        </div>
    </div>
    
    <script>
        const btnSwitch = document.querySelector('#switch');

        btnSwitch.addEventListener('click', () => {
            document.body.classList.toggle('light');
            btnSwitch.classList.toggle('active');

            if(document.body.classList.contains('light')){
                localStorage.setItem('light-mode', 'true');
            } else {
                localStorage.setItem('light-mode', 'false');
            }
        });

        if(localStorage.getItem('light-mode') === 'true'){
            document.body.classList.add('light');
            btnSwitch.classList.add('active');
        } else {
            document.body.classList.remove('light');
            btnSwitch.classList.remove('active');
        }
    </script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>    
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    
    <script>
        feather.replace()
    </script>
    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        const inputElement = document.querySelector('div.divCupon input[type="file"]');        
        const pond = FilePond.create(inputElement, {
            acceptedFileTypes: ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '.xlsx'],
        });
        $('#plantillaCupon').change(function() {
            $('#importCupon').submit();
        });
        $('#importCupon').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ url('importarCupon' )}}",
                type: "POST",
                data: {
                    formData,
                },
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                },
                beforeSend: function(){
                    //
                },
                success: function (data) {

                },
                error: function (error) {
                }
            });
            return false
        });
    </script>
    <script>
        var count = 0;
        $('#sideButton').click(function(){
            count++;
            count % 2 ? $firstFunction() : $secondFunction();
            function $firstFunction(){
                $('#sidebarMenu').removeClass('d-none');
                $('#sidebarMenu').addClass('col-xs-3 col-sm-3 col-md-3');
                $('#sidebarMenu2').removeClass('col-xs-12 col-sm-12 col-md-12');
                $('#sidebarMenu2').addClass('col-xs-9 col-sm-9 col-md-9');
            }
            function $secondFunction(){
                $('#sidebarMenu').addClass('d-none');
                $('#sidebarMenu').removeClass('col-xs-3 col-sm-3 col-md-3');
                $('#sidebarMenu2').addClass('col-xs-12 col-sm-12 col-md-12');
                $('#sidebarMenu2').removeClass('col-xs-9 col-sm-9 col-md-9');
            }
        });
    </script>
    <script>
        $('#myTable').DataTable({
            "language": {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "infoThousands": ",",
                "loadingRecords": "Cargando...",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad",
                    "collection": "Colección",
                    "colvisRestore": "Restaurar visibilidad",
                    "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                    "copySuccess": {
                        "1": "Copiada 1 fila al portapapeles",
                        "_": "Copiadas %ds fila al portapapeles"
                    },
                    "copyTitle": "Copiar al portapapeles",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Mostrar todas las filas",
                        "_": "Mostrar %d filas"
                    },
                    "pdf": "PDF",
                    "print": "Imprimir",
                    "renameState": "Cambiar nombre",
                    "updateState": "Actualizar",
                    "createState": "Crear Estado",
                    "removeAllStates": "Remover Estados",
                    "removeState": "Remover",
                    "savedStates": "Estados Guardados",
                    "stateRestore": "Estado %d"
                },
                "autoFill": {
                    "cancel": "Cancelar",
                    "fill": "Rellene todas las celdas con <i>%d<\/i>",
                    "fillHorizontal": "Rellenar celdas horizontalmente",
                    "fillVertical": "Rellenar celdas verticalmentemente"
                },
                "decimal": ",",
                "searchBuilder": {
                    "add": "Añadir condición",
                    "button": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "clearAll": "Borrar todo",
                    "condition": "Condición",
                    "conditions": {
                        "date": {
                            "after": "Despues",
                            "before": "Antes",
                            "between": "Entre",
                            "empty": "Vacío",
                            "equals": "Igual a",
                            "notBetween": "No entre",
                            "notEmpty": "No Vacio",
                            "not": "Diferente de"
                        },
                        "number": {
                            "between": "Entre",
                            "empty": "Vacio",
                            "equals": "Igual a",
                            "gt": "Mayor a",
                            "gte": "Mayor o igual a",
                            "lt": "Menor que",
                            "lte": "Menor o igual que",
                            "notBetween": "No entre",
                            "notEmpty": "No vacío",
                            "not": "Diferente de"
                        },
                        "string": {
                            "contains": "Contiene",
                            "empty": "Vacío",
                            "endsWith": "Termina en",
                            "equals": "Igual a",
                            "notEmpty": "No Vacio",
                            "startsWith": "Empieza con",
                            "not": "Diferente de",
                            "notContains": "No Contiene",
                            "notStarts": "No empieza con",
                            "notEnds": "No termina con"
                        },
                        "array": {
                            "not": "Diferente de",
                            "equals": "Igual",
                            "empty": "Vacío",
                            "contains": "Contiene",
                            "notEmpty": "No Vacío",
                            "without": "Sin"
                        }
                    },
                    "data": "Data",
                    "deleteTitle": "Eliminar regla de filtrado",
                    "leftTitle": "Criterios anulados",
                    "logicAnd": "Y",
                    "logicOr": "O",
                    "rightTitle": "Criterios de sangría",
                    "title": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "value": "Valor"
                },
                "searchPanes": {
                    "clearMessage": "Borrar todo",
                    "collapse": {
                        "0": "Paneles de búsqueda",
                        "_": "Paneles de búsqueda (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Sin paneles de búsqueda",
                    "loadMessage": "Cargando paneles de búsqueda",
                    "title": "Filtros Activos - %d",
                    "showMessage": "Mostrar Todo",
                    "collapseMessage": "Colapsar Todo"
                },
                "select": {
                    "cells": {
                        "1": "1 celda seleccionada",
                        "_": "%d celdas seleccionadas"
                    },
                    "columns": {
                        "1": "1 columna seleccionada",
                        "_": "%d columnas seleccionadas"
                    },
                    "rows": {
                        "1": "1 fila seleccionada",
                        "_": "%d filas seleccionadas"
                    }
                },
                "thousands": ".",
                "datetime": {
                    "previous": "Anterior",
                    "next": "Proximo",
                    "hours": "Horas",
                    "minutes": "Minutos",
                    "seconds": "Segundos",
                    "unknown": "-",
                    "amPm": [
                        "AM",
                        "PM"
                    ],
                    "months": {
                        "0": "Enero",
                        "1": "Febrero",
                        "10": "Noviembre",
                        "11": "Diciembre",
                        "2": "Marzo",
                        "3": "Abril",
                        "4": "Mayo",
                        "5": "Junio",
                        "6": "Julio",
                        "7": "Agosto",
                        "8": "Septiembre",
                        "9": "Octubre"
                    },
                    "weekdays": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mie",
                        "Jue",
                        "Vie",
                        "Sab"
                    ]
                },
                "editor": {
                    "close": "Cerrar",
                    "create": {
                        "button": "Nuevo",
                        "title": "Crear Nuevo Registro",
                        "submit": "Crear"
                    },
                    "edit": {
                        "button": "Editar",
                        "title": "Editar Registro",
                        "submit": "Actualizar"
                    },
                    "remove": {
                        "button": "Eliminar",
                        "title": "Eliminar Registro",
                        "submit": "Eliminar",
                        "confirm": {
                            "_": "¿Está seguro que desea eliminar %d filas?",
                            "1": "¿Está seguro que desea eliminar 1 fila?"
                        }
                    },
                    "error": {
                        "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                    },
                    "multi": {
                        "title": "Múltiples Valores",
                        "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                        "restore": "Deshacer Cambios",
                        "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                    }
                },
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "stateRestore": {
                    "creationModal": {
                        "button": "Crear",
                        "name": "Nombre:",
                        "order": "Clasificación",
                        "paging": "Paginación",
                        "search": "Busqueda",
                        "select": "Seleccionar",
                        "columns": {
                            "search": "Búsqueda de Columna",
                            "visible": "Visibilidad de Columna"
                        },
                        "title": "Crear Nuevo Estado",
                        "toggleLabel": "Incluir:"
                    },
                    "emptyError": "El nombre no puede estar vacio",
                    "removeConfirm": "¿Seguro que quiere eliminar este %s?",
                    "removeError": "Error al eliminar el registro",
                    "removeJoiner": "y",
                    "removeSubmit": "Eliminar",
                    "renameButton": "Cambiar Nombre",
                    "renameLabel": "Nuevo nombre para %s",
                    "duplicateError": "Ya existe un Estado con este nombre.",
                    "emptyStates": "No hay Estados guardados",
                    "removeTitle": "Remover Estado",
                    "renameTitle": "Cambiar Nombre Estado"
                }
            }
        });
        const button = document.getElementById('count');
        var notis = {!! json_encode($notifications->toArray()) !!};
        var i = notis.length;
        function notificaciones(i){
        if (i<=0) {
            button.hidden= true;
            document.getElementById("count").classList.add("count");
            document.getElementById("count").classList.remove("count2");
            document.getElementById("campana").classList.remove("campana2");
            document.getElementById("campanaa").classList.remove("campana2");
        }else{
            button.hidden= false;
            document.getElementById("count").innerHTML=i;
            document.getElementById("count").classList.remove("count");
            document.getElementById("count").classList.add("count2");
            document.getElementById("campana").classList.add("campana2");
            document.getElementById("campanaa").classList.add("campana2");
        }
        };
        notificaciones(i);
        function mark_as_read($id_notification){
            $.ajax({
                url: "{{ route('markNotification', ':id') }}".replace(':id', $id_notification),
                method: "POST",
                data: {
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
                    i--;
                    notificaciones(i);
                    
                },
                error: function (error) {
                }
            });
        };
        function mark_all_as_read($id_admin){
            $.ajax({
                url: "{{ route('markAllNotification', ':id') }}".replace(':id', $id_admin),
                method: "POST",
                data: {
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
                    $('div.alert').hide();
                    i=0;
                    notificaciones(i);
                },
                error: function (error) {
                }
            });
        };
    </script>
    <script>
        const labels_es_ES = {
            labelIdle: 'Arrastra y suelta tus archivos o <span class = "filepond--label-action"> Examinar <span>',
            labelInvalidField: "El campo contiene archivos inválidos",
            labelFileWaitingForSize: "Esperando tamaño",
            labelFileSizeNotAvailable: "Tamaño no disponible",
            labelFileLoading: "Cargando",
            labelFileLoadError: "Error durante la carga",
            labelFileProcessing: "Cargando",
            labelFileProcessingComplete: "Carga completa",
            labelFileProcessingAborted: "Carga cancelada",
            labelFileProcessingError: "Error durante la carga",
            labelFileProcessingRevertError: "Error durante la reversión",
            labelFileRemoveError: "Error durante la eliminación",
            labelTapToCancel: "toca para cancelar",
            labelTapToRetry: "tocar para volver a intentar",
            labelTapToUndo: "tocar para deshacer",
            labelButtonRemoveItem: "Eliminar",
            labelButtonAbortItemLoad: "Abortar",
            labelButtonRetryItemLoad: "Reintentar",
            labelButtonAbortItemProcessing: "Cancelar",
            labelButtonUndoItemProcessing: "Deshacer",
            labelButtonRetryItemProcessing: "Reintentar",
            labelButtonProcessItem: "Cargar",
            labelMaxFileSizeExceeded: "El archivo es demasiado grande",
            labelMaxFileSize: "El tamaño máximo del archivo es {filesize}",
            labelMaxTotalFileSizeExceeded: "Tamaño total máximo excedido",
            labelMaxTotalFileSize: "El tamaño total máximo del archivo es {filesize}",
            labelFileTypeNotAllowed: "Archivo de tipo no válido",
            fileValidateTypeLabelExpectedTypes: "Espera {allButLastType} o {lastType}",
            imageValidateSizeLabelFormatError: "Tipo de imagen no compatible",
            imageValidateSizeLabelImageSizeTooSmall: "La imagen es demasiado pequeña",
            imageValidateSizeLabelImageSizeTooBig: "La imagen es demasiado grande",
            imageValidateSizeLabelExpectedMinSize: "El tamaño mínimo es {minWidth} × {minHeight}",
            imageValidateSizeLabelExpectedMaxSize: "El tamaño máximo es {maxWidth} × {maxHeight}",
            imageValidateSizeLabelImageResolutionTooLow: "La resolución es demasiado baja",
            imageValidateSizeLabelImageResolutionTooHigh: "La resolución es demasiado alta",
            imageValidateSizeLabelExpectedMinResolution: "La resolución mínima es {minResolution}",
            imageValidateSizeLabelExpectedMaxResolution: "La resolución máxima es {maxResolution}",
        };

        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.setOptions(labels_es_ES);
        FilePond.parse(document.body);
    </script>
    <style>
        .count{
            border-radius: 50%;
            position: absolute;
            top: -10px;
            left: 18px;
        }
        .count2{
            border-radius: 50%;
            position: absolute;
            top: -10px;
            left: 18px;
            animation: wiggle 2s linear infinite;
        }
        .badge{
            font-weight: 450;
        }
        .btn-route:hover{
            background-color: rgb(18,19,23);
            border-color:black;
        }
        body.light .btn-route:hover{
            background-color: #cc3300;
        }
        .dataTables_filter input {
            color: white !important;
        }
        body.light .dataTables_filter input {
            color: black !important;
            border-color: black !important;
        }
        .dataTables_filter { /* Is for the search box top right */
            color: white !important;
        }
        body.light .dataTables_filter { /* Is for the search box top right */
            color: black !important;
        }
        .dataTables_length { /* Is for the top left box, show 10 entries etc.. */
            color: white !important;
        }
        body.light .dataTables_length { /* Is for the top left box, show 10 entries etc.. */
            color: black !important;
        }
        .dataTables_length select{ /* Is for the top left box, show 10 entries etc.. */
            color: white !important;
            background-color: rgb(18,19,23) !important;
        }
        body.light .dataTables_length select{ /* Is for the top left box, show 10 entries etc.. */
            color: white !important;
            background-color: white !important;
        }
        body.light .dataTables_length select{ /* Is for the top left box, show 10 entries etc.. */
            color: black !important;
        }
        .dataTables_info { /* Is for the table info on the bottom left */
            color: white !important;
        }
        body.light .dataTables_info { /* Is for the table info on the bottom left */
            color: black !important;
        }
        .select2-selection--multiple{
            overflow: hidden !important;
            height: auto !important;
        }
        .select2-selection{
            overflow: hidden !important;
            height: auto !important;
        }
        html, body{
            height: 100%;
            margin: 0;
            padding: 0;
            
        }
        #map{
            max-width: 100%;
            height: 500px;
        }
        .barra1 {
            background-color:rgb(26,28,35); 
            color:white;
        }
        body.light .barra1 {
            background: rgb(251,70,58);
            background: linear-gradient(180deg, rgba(251,70,58,1) 0%, rgba(246,92,34,1) 50%, rgba(240,105,16,1) 100%);
        }
        .botones{
            background: rgba(0, 0, 0, 0.0);
        }
        .logos{
            color:rgb(249,149,22);
        }
        body.light .logos {
            color:black;
        }
        .menu{
            background-color:rgb(26,28,35);
            color:white;
        }
        body.light .menu{
            background: rgb(251,70,58);
            background: linear-gradient(0deg, rgba(251,70,58,1) 0%, rgba(246,92,34,1) 50%, rgba(240,105,16,1) 100%);
            color: black;
        }
        .panel{
            background-color:rgb(18,19,23);
            color: white;
        }
        body.light .panel{
            background: rgb(247,232,221);
            background: radial-gradient(circle, rgba(247,232,221,1) 0%, rgba(243,170,76,1) 100%);
            color: black;
        }
        .datatables1{
            border-color: #ffffff; 
            background: #212529;
        }
        body.light .datatables1{
            border-color: black;
            background: #f06910 ;
            color: black;
        }
        .datatables2{
            border-color: #ffffff; 
            background: rgb(18,19,23);
        }
        body.light .datatables2{
            border-color: black;
            background: rgba(0, 0, 0, 0.0);
        }
        body.light .datatables3{
            border-color: black;
        }

        .switch {
        background: orange;
        border-radius: 1000px;
        border: none;
        position: relative;
        cursor: pointer;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        outline: none;
        }

        .switch::after {
        content: "";
        display: block;
        width: 30px;
        height: 30px;
        position: absolute;
        background: #F1F1F1;
        top: 0;
        left: 0;
        right: unset;
        border-radius: 100px;
        -webkit-transition: .3s ease all;
        transition: .3s ease all;
        -webkit-box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.2);
                box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.2);
        }

        .switch.active {
            background: #343D5B;
        color: #000;
        }

        .switch.active::after {
        right: 0;
        left: unset;
        }

        .switch span {
        width: 30px;
        height: 30px;
        line-height: 30px;
        display: block;
        background: none;
        color: #fff;
        }
        .swal2-popup {
        background: rgb(18,19,23) !important;
        color: white;
        }
        body.light .swal2-popup {
        background: white !important;
        color: black;
        }
        .campana {
            color:rgb(249,149,22); 
            width:35%; 
            height:35%;
        }
        .campana2 {
            animation: wiggle 2s linear infinite;
        }

/* Keyframes */
@keyframes wiggle {
  0%, 7% {
    transform: rotateZ(0);
  }
  15% {
    transform: rotateZ(-15deg);
  }
  20% {
    transform: rotateZ(10deg);
  }
  25% {
    transform: rotateZ(-10deg);
  }
  30% {
    transform: rotateZ(6deg);
  }
  35% {
    transform: rotateZ(-4deg);
  }
  40%, 100% {
    transform: rotateZ(0);
  }
}
        .user{
            color:rgb(249,149,22);
        }
        body.light .campana {
            color:black; 
        }
        body.light .user {
            color:black; 
        }
        body.light .campana:hover {
            color: red;
        }
        .campana:hover {
        color: red;
        cursor:pointer;
        }
        .user:hover{
        color: red;
        cursor:pointer;
        }
        body.light .user:hover {
            color: red;
        }
        .notis{
            background-color:rgb(18,19,23);
            border:solid;
            border-color: rgb(249,149,22);
        }
        body.light .notis{
            background-color:white;
            border:solid;
            border-color: black;
        }
        .nots{
            color:white;
        }
        body.light .nots{
            color:black;
        }
        
    </style>
    <main>
        @yield('js')
    </main>
</body>
</html>