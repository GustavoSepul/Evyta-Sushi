<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoModel;
use Illuminate\Support\Facades\Storage;
use App\Notifications\DeleteProductoNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = DB::table('producto')
        ->leftjoin('familia', 'producto.id_familia', '=', 'familia.id')
        ->select('producto.nombre as nombre_producto','familia.nombre as nombre_familia','disponibilidad','descripcion','precio', 'producto.id')
        ->get();
        $notifications = auth()->user()->unreadNotifications;
        return view('producto.index',compact(['productos'],'notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['familias'] = DB::table('familia')->get();
        $data['ingredientes'] = DB::table('ingrediente')->get();
        $data['locales'] = DB::table('local')->get();
        $notifications = auth()->user()->unreadNotifications;
        return view('producto.create',compact(['data'],'notifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campos=[
            'nombre'=>'required|string|max:100',
            'precio'=>'required|integer|max:1000000',
            'familia'=>'required|integer|max:1000000',
            'descripcion'=>'required|string|max:500',
        ];

        $mensaje=[
                'nombre.required'=>'El nombre es requerido',
                'nombre.max'=>'El nombre no debe tener mas de 100 caracteres',
                'precio.required'=>'El precio es requerido',
                'familia.required'=>'La familia es requerida',
                'descripcion.required'=>'La descripcion es requerida',
                'descripcion.max'=>'La descripcion no debe tener mas de 500 caracteres',
        ];
        $this->validate($request,$campos,$mensaje);

        $producto = request()-> except('_token','ingrediente','local');
        $producto['id_familia'] = $producto['familia'];
        unset($producto['familia']);
        
        if($request->hasFile('imagen')){
            $producto['imagen']=$request->file('imagen')->store('uploads', 'public');
        }else{
            $producto['imagen'] = "";
        }
        if($request->has('disponibilidad')){
            $producto['disponibilidad'] = 1;
        }else{
            $producto['disponibilidad'] = 0;
        }
        ProductoModel::insert($producto);
        $productoId = DB::SELECT('SELECT id FROM producto ORDER BY id DESC LIMIT 1');
        $ingredientesId = $request['ingrediente'];
        foreach ($ingredientesId as $ingredientes) {
            DB::insert('INSERT INTO producto_ingrediente VALUES ('.$productoId[0]->id.','.$ingredientes.')');
        }
        $localesId = $request['local'];
        foreach ($localesId as $local) {
            DB::insert('INSERT INTO producto_local VALUES ('.$productoId[0]->id.','.$local.')');
        }
        return redirect('producto')->with('crear', 'ok');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = DB::table('producto')
        ->leftjoin('familia', 'producto.id_familia', '=', 'familia.id')
        ->leftjoin('producto_ingrediente', 'producto.id', '=', 'producto_ingrediente.id_producto')
        ->leftjoin('familia_subfamilia', 'familia.id', '=', 'familia_subfamilia.id_familia')
        ->leftjoin('subfamilia', 'familia_subfamilia.id_subfamilia', '=', 'subfamilia.id')
        ->leftjoin('ingrediente', 'producto_ingrediente.id_ingrediente', '=', 'ingrediente.id')
        ->leftjoin('producto_local', 'producto.id', '=', 'producto_local.id_producto')
        ->leftjoin('local', 'producto_local.id_local', '=', 'local.id')
        ->leftjoin('familia_tipo', 'familia.id', '=', 'familia_tipo.id_familia')
        ->leftjoin('tipo', 'familia_tipo.id_tipo', '=', 'tipo.id')
        ->select('producto.nombre as nombre_producto','familia.nombre as nombre_familia','disponibilidad','descripcion','precio','imagen','producto.id','ingrediente.nombre as nombre_ingrediente','subfamilia.nombre as nombre_subfamilia','tipo.nombre as nombre_tipo','local.nombre as nombre_local')
        ->where('producto.id','=',$id)
        ->get();
        return json_encode(array('info'=>$info));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['familias'] = DB::table('familia')->get();
        $data['producto'] = DB::table('producto')->leftjoin('familia', 'producto.id_familia', '=', 'familia.id')->select('producto.nombre as nombre_producto','familia.nombre as nombre_familia','disponibilidad','descripcion','precio','imagen','producto.id','familia.id as id_familia')->where('producto.id','=',$id)->get();
        $allIngredientes = DB::table('ingrediente')->get();
        $ingredientes = DB::select('SELECT ingrediente.id, ingrediente.nombre FROM ingrediente JOIN producto_ingrediente ON(ingrediente.id = producto_ingrediente.id_ingrediente) WHERE '.$id.' = id_producto');
        $allLocales = DB::table('local')->get();
        $locales = DB::select('SELECT local.id, local.nombre FROM local JOIN producto_local ON(local.id = producto_local.id_local) WHERE '.$id.' = id_producto');
        $notifications = auth()->user()->unreadNotifications;
        return view('producto.edit',compact(['data'],'ingredientes','allIngredientes','allLocales', 'locales','notifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos=[
            'nombre'=>'required|string|max:100',
            'precio'=>'required|integer|max:1000000',
            'familia'=>'required|integer|max:1000000',
            'descripcion'=>'required|string|max:200',
        ];

        $mensaje=[
                'nombre.required'=>'El nombre es requerido',
                'nombre.max'=>'El nombre no debe tener mas de 100 caracteres',
                'precio.required'=>'El precio es requerido',
                'familia.required'=>'La familia es requerida',
                'descripcion.required'=>'La descripcion es requerida',
                'descripcion.max'=>'La descripcion no debe tener mas de 200 caracteres',
        ];
        $this->validate($request,$campos,$mensaje);
        $producto = request()-> except('_token','_method','ingredienteEdit','local');
        if($request->hasFile('imagen')){
            $imageProduct=ProductoModel::findOrFail($id);
            Storage::delete('public/'.$imageProduct->imagen);
            $producto['imagen']=$request->file('imagen')->store('uploads', 'public');
        }else{
            unset($producto['imagen']);
        }
        $producto['id_familia'] = $producto['familia'];
        unset($producto['familia']);    
        if($request->has('disponibilidad')){
            $producto['disponibilidad'] = 1;
        }else{
            $producto['disponibilidad'] = 0;
        }
        ProductoModel::where('id','=',$id)->update($producto);
        DB::delete('DELETE FROM producto_ingrediente WHERE id_producto='.$id.'');
        $ingredienteEdit = $request['ingredienteEdit'];
        foreach ($ingredienteEdit as $ingredientes) {
            DB::insert('INSERT INTO producto_ingrediente VALUES ('.$id.','.$ingredientes.')');
        }
        DB::delete('DELETE FROM producto_local WHERE id_producto='.$id.'');
        $locales = $request['local'];
        foreach ($locales as $local) {
            DB::insert('INSERT INTO producto_local VALUES ('.$id.','.$local.')');
        }
        return redirect('producto')->with('editar', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto=ProductoModel::findOrFail($id);
        $admins = User::role('administrador')->get();
        Notification::send($admins, new DeleteProductoNotification($producto));
        if(Storage::delete('public/'.$producto->imagen)){
            ProductoModel::destroy($id);
        }
        ProductoModel::destroy($id);
        DB::delete('DELETE FROM producto_ingrediente WHERE id_producto='.$id.'');
        return redirect('producto')->with('eliminar', 'ok');

    }
}
