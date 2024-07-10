<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Venta;
use App\Models\ProductoModel;
use Illuminate\Support\Facades\Storage;
use Session;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nombre = Session::all();
        $promociones = ProductoModel::where('id_familia', 11)->where('disponibilidad', 1)->take(4)->get();
        $pizzas = ProductoModel::where('id_familia', 10)->where('disponibilidad', 1)->take(4)->get();
        $sushis = ProductoModel::where('id_familia', 5)->where('disponibilidad', 1)->take(4)->get();
        return view('landing.index', compact('nombre','promociones','pizzas','sushis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users=User::findOrFail($id);
        return view('landing.show', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users=User::findOrFail($id);
        return view('landing.edit',compact('users'));
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
            'name'=>'required|string|max:100',
            'direccion'=>'required|string|max:150',
            'celular'=>'required|string|max:9',
            'telefono'=>'max:9',
            'imagen'=>'max:10000|mimes:jpeg,png,jpg',
        ];

        $mensaje=[
                'name.required'=>'El nombre es requerido',
                'name.max'=>'El nombre no debe tener mas de 100 caracteres',
                'direccion.required'=>'La dirección es requerida',
                'direccion.max'=>'La dirección no debe tener mas de 150 caracteres',
                'celular.required'=>'El celular es requerido',
        ];


        $this->validate($request,$campos,$mensaje);
        //
        $datosUsers = request()->except(['_token','_method']);

        if($request->hasFile('imagen')){
            $users=User::findOrFail($id);
            Storage::delete('public/'.$users->imagen);
            $datosUsers['imagen']=$request->file('imagen')->store('uploads', 'public');
        }

        User::where('id','=',$id)->update($datosUsers);
        $users=User::findOrFail($id);
        //return view('users.edit', compact('users'));

        return redirect('verperfil/'.$id)->with('editar','ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function menu()
    {
        $nombre = Session::all();
        return view('landing.menu',compact('nombre'));
    }

    public function mispedidos()
    {
        $pedidos = DB::table('ventas')
        ->join('carrito','ventas.numeroPedido','=','carrito.id')
        ->join('users','carrito.id_usuario','=','users.id')
        ->join('local','ventas.local_origen','=','local.id')
        ->select('fechaPedido','users.name','direccionEntrega','ventas.coordenadas','carrito.id', 'ventas.destino', 'local.nombre as local', 'ventas.total')
        ->where('users.id','=',auth()->user()->id)
        ->where('carrito.estado','=','entregado')
        ->get();
        $pedidos2 = DB::table('ventas')
        ->join('carrito','ventas.numeroPedido','=','carrito.id')
        ->join('users','carrito.id_usuario','=','users.id')
        ->join('local','ventas.local_origen','=','local.id')
        ->select('fechaPedido','users.name','direccionEntrega','ventas.coordenadas','carrito.id', 'ventas.destino', 'local.nombre as local', 'ventas.total')
        ->where('users.id','=',auth()->user()->id)
        ->where('carrito.estado','=','pagado')
        ->get();
        return view('landing.mispedidos', compact('pedidos','pedidos2'));
    }


}
