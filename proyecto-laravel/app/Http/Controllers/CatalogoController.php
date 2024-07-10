<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Session;

class CatalogoController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $nombre = Session::all();
        return view('landing.catalogo', compact('nombre'));
    }

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



}
