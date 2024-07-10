<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LocalController; //referencia a la ubicacion del controlador
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CuponController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\CarroController;
/*
Web.php lo que hace es canalizar lo que hace el usuario, si el usuario entra a una ruta (URL)
le decimos que muestre la vista (Carpeta views)
*/



Route::get('/',[\App\Http\Controllers\LandingController::class, 'index'])->name('index');
/*
Route::get('/local/create',[LocalController::class,'create']);  //enlaza ruta create local
Route::resource('/local',LocalController::class);   //enlaza toas las rutas de local
*/


Route::get('/users', function () {
    return view('users.index');
});

Route::get('/familia', function () {
    return view('familia.index');
});

Route::get('/subfamilia', function () {
    return view('subfamilia.index');
});

Route::get('/comentarios', function () {
    return view('comentarios');
});

Route::get('/reseñas', function () {
    return view('reseñas');
});

Route::get('/entrega', function () {
    return view('entrega');
});

Route::get('/maps', function () {
    return view('maps');
});

Route::get('mapas', [GoogleController::class, 'index']);
Auth::routes();


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::middleware(['adminmiddleware'])->group(function () {
        Route::resource('local',LocalController::class);
        Route::resource('ingrediente',IngredienteController::class);
        Route::resource('tipo',TipoController::class);
        Route::resource('administrador', App\Http\Controllers\AdministradorController::class);
        Route::resource('producto',App\Http\Controllers\ProductoController::class);
        Route::resource('cupon',CuponController::class);
        Route::resource('rol',RolController::class);
        Route::resource('permiso',PermisoController::class);
        Route::get('/administrador', [App\Http\Controllers\AdministradorController::class, 'index'])->name('administrador');
        Route::resource('users',App\Http\Controllers\UsersController::class);
        Route::resource('familia',App\Http\Controllers\FamiliaController::class);
        Route::resource('subfamilia',App\Http\Controllers\SubfamiliaController::class);
        Route::post('mark-as-read/{id_notification}', 'App\Http\Controllers\AdministradorController@markNotification')->name('markNotification');
        Route::post('mark-all-as-read/{id_admin}', 'App\Http\Controllers\AdministradorController@markAllNotification')->name('markAllNotification');
        Route::get('/descargarCupon', [App\Http\Controllers\CuponController::class, 'descargarCupon'])->name('descargarCupon');
        Route::post('/importarCupon', [App\Http\Controllers\CuponController::class, 'importarCupon'])->name('importarCupon');
        Route::get('/exportarCupon', [App\Http\Controllers\CuponController::class, 'exportarCupon'])->name('exportarCupon');
        Route::get('pedidos', [App\Http\Controllers\VentaController::class, 'pedidosindex'])->name('pedidos');
        
        Route::get('marcarentregado/{id}', [App\Http\Controllers\VentaController::class, 'marcarentregado'])->name('marcarentregado');
    });

// Route::resource('catalogo', CatalogoController::class);
Route::get('/catalogo', App\Http\Livewire\Posts::class)->name('catalogo');
// Route::resource('/inicio', App\Http\Controllers\LandingController::class);
Route::post('/registrarCliente', 'App\Http\Controllers\UsersController@registrarCliente');
Route::get('/agregaralcarrito/{id}/{cantidad}', 'App\Http\Controllers\VentaController@agregaralcarrito');
Route::get('/verperfil/{id}', 'App\Http\Controllers\LandingController@show');
Route::get('/mispedidos/{id}', 'App\Http\Controllers\LandingController@mispedidos');
Route::get('/editarperfil/{id}', 'App\Http\Controllers\LandingController@edit');
Route::get('/getRoles','App\Http\Controllers\RolController@getRoles');
Route::get('/logIn', 'App\Http\Controllers\LoginController@index')->name('ingresar');
Route::delete('/users/destroy_imagen/{id}', 'App\Http\Controllers\UsersController@destroy_imagen');
Route::get('send-mail', [MailController::class, 'index']);
Route::resource('venta',App\Http\Controllers\VentaController::class);
Route::get('iniciar_venta', [VentaController::class, 'iniciar_venta']);
Route::get('confirmar_pago', [VentaController::class, 'confirmar_pago'])->name('confirmar_pago');
Route::get('/maps_maker/{id}',[GoogleController::class, 'reparto']);
Route::get('/carrito', 'App\Http\Controllers\CarroController@carrito_personal')->name('carrito');
Route::post('/selecciondepago', 'App\Http\Controllers\CarroController@selecciondepago')->name('selecciondepago');
Route::post('/ingresadireccion', 'App\Http\Controllers\CarroController@ingresadireccion')->name('ingresadireccion');
Route::post('/cambiardireccion', 'App\Http\Controllers\CarroController@cambiardireccion')->name('cambiardireccion');
Route::get('datoscarrito/{id}', [CarroController::class, 'datoscarrito']);
Route::get('eliminardelcarrito/{id}/{cantidad}', [CarroController::class, 'eliminardelcarrito']);
Route::get('ingresocupon/{codigo}', [CarroController::class, 'ingresocupon']);
Route::get('/cantidad_productos', 'App\Http\Controllers\CarroController@cantidad_productos')->name('cantidad_productos');
Route::get('/verdetalles/{id}', 'App\Http\Controllers\CarroController@verdetalles')->name('verdetalles');
Route::patch('/guardarperfil/{id}', 'App\Http\Controllers\LandingController@update')->name('guardarperfil');
Route::get('detallespedido/{id}', [App\Http\Controllers\VentaController::class, 'detallespedido'])->name('detallespedido');
Route::get('/menu', 'App\Http\Controllers\LandingController@menu')->name('menu');