<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Compra;
use App\Models\Venta;
Use Carbon\Carbon;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $hoy=Carbon::now();
        $hoy=$hoy->format('Y-m-d');
        $ventahoy= DB::table('ventas')->where('fechaPedido','=',$hoy)->sum('total');
        $mes =substr($hoy,0,7);
        $ventames= DB::table('ventas')->where('fechaPedido','>=',$mes.'-01')->where('fechaPedido','<=',$mes.'-31')->sum('total');
        $anio=substr($hoy,0,4);
        $ventanual= DB::table('ventas')->where('fechaPedido','>=',$anio.'-01-01')->where('fechaPedido','<=',$anio.'-12-31')->sum('total');
        $ventas['Enero'] =  DB::table('ventas')-> where('fechaPedido','>=',$anio.'-01-01')->where('fechaPedido','<=',$anio.'-01-31')->sum('total');
        $ventas['Febrero'] =  DB::table('ventas')-> where('fechaPedido','>=',$anio.'-02-01')->where('fechaPedido','<=',$anio.'-02-28')->sum('total');
        $ventas['Marzo'] =  DB::table('ventas')-> where('fechaPedido','>=',$anio.'-03-01')->where('fechaPedido','<=',$anio.'-03-31')->sum('total');
        $ventas['Abril'] =  DB::table('ventas')-> where('fechaPedido','>=',$anio.'-04-01')->where('fechaPedido','<=',$anio.'-04-30')->sum('total');
        $ventas['Mayo'] =  DB::table('ventas')-> where('fechaPedido','>=',$anio.'-05-01')->where('fechaPedido','<=',$anio.'-05-31')->sum('total');
        $ventas['Junio'] =  DB::table('ventas')-> where('fechaPedido','>=',$anio.'-06-01')->where('fechaPedido','<=',$anio.'-06-30')->sum('total');
        $ventas['Julio'] =  DB::table('ventas')-> where('fechaPedido','>=',$anio.'-07-01')->where('fechaPedido','<=',$anio.'-07-31')->sum('total');
        $ventas['Agosto'] =  DB::table('ventas')-> where('fechaPedido','>=',$anio.'-08-01')->where('fechaPedido','<=',$anio.'-08-31')->sum('total');
        $ventas['Septiembre'] =  DB::table('ventas')-> where('fechaPedido',$anio.'>=','-09-01')->where('fechaPedido','<=',$anio.'-09-30')->sum('total');
        $ventas['Octubre'] =  DB::table('ventas')-> where('fechaPedido','>=',$anio.'-10-01')->where('fechaPedido','<=',$anio.'-10-31')->sum('total');
        $ventas['Noviembre'] =  DB::table('ventas')-> where('fechaPedido','>=',$anio.'-11-01')->where('fechaPedido','<=',$anio.'-11-30')->sum('total');
        $ventas['Diciembre'] =  DB::table('ventas')-> where('fechaPedido','>=',$anio.'-12-01')->where('fechaPedido','<=',$anio.'-12-31')->sum('total');

        $ordenes['totales'] = Compra::count();
        $ordenes['pagadas'] = Compra::where('estado', 'pagado')->count();
        $ordenes['reparto'] = Compra::where('estado', 'en_reparto')->count();
        $ordenes['finalizadas'] = Compra::where('estado', 'entregado')->count();

        $ventasTable = DB::table('ventas')->join('carrito','ventas.numeroPedido','=','carrito.id')->select('fechaPedido','ventas.direccionEntrega','tipoPago','ventas.total','carrito.estado')->get();
        $notifications = auth()->user()->unreadNotifications;
        
        return view('administrador.index',compact('ventahoy','ventas','ventames','ventanual', 'ordenes','ventasTable','notifications'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function markNotification($id)
    {  
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        $newnotifications = auth()->user()->unreadNotifications;
        return $newnotifications;
    }

    public function markAllNotification($id_admin)
    {
        $now = Carbon::now();
        $newTable = DB::table('notifications')->where('notifiable_id',$id_admin)->update(['read_at' => $now]);
        return $newTable;
    }
}
