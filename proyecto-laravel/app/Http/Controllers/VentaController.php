<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;
use Illuminate\Support\Facades\DB;
use App\Models\Compra;
use App\Models\ProductoModel;
use App\Models\Cupon;
use App\Models\Local;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VentaController extends Controller
{
    public function _construct(){
        // Descomentar cuando tengamos credenciales de tranbank y borrar lo de a continuacion
        // WebpayPlus::configureForProduction(
        //     env('webpay_plus_cc'),
        //     env('webpay_plus_api_key')
        // );
        WebpayPlus::configureForTesting();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function pedidosindex(){
        $notifications = auth()->user()->unreadNotifications;
        $pedidos = DB::table('ventas')
        ->join('carrito','ventas.numeroPedido','=','carrito.id')
        ->join('users','carrito.id_usuario','=','users.id')
        ->join('local_users', 'users.id', '=', 'local_users.id_users')
        ->join('local', 'local_users.id_local', '=', 'local.id')
        ->select('fechaPedido','users.name','direccionEntrega','ventas.coordenadas','carrito.id', 'ventas.destino', 'ventas.local_origen', 'local.id AS id_local')
        ->where('estado','=','pagado')
        ->where('id_local', '=', 'ventas.local_origen')
        ->get();
        return view('pedidos.index', compact('notifications','pedidos'));
    }

    public function detallespedido($id){
        $pedidos = DB::table('carrito')
        ->join('producto_carrito','carrito.id','=','producto_carrito.id_carrito')
        ->join('producto','producto_carrito.id_producto','=','producto.id')
        ->where('carrito.id','=',$id)
        ->get();
        return $pedidos;
    }

    public function marcarentregado($id){
        $carrito = Compra::where('id',$id)->where('estado','pagado')->first();
        $carrito->estado = 'entregado';
        $carrito->save();
    }

    public function agregaralcarrito($id, $cantidad){
        $carrito = Compra::where('id_usuario',auth()->user()->id)->where('estado','por_pagar')->first();
        $producto = ProductoModel::where('id',$id)->first();
        if($carrito == ""){
            $carro = new Compra;
            $carro->subtotal = $producto->precio*$cantidad;
            $carro->total = $producto->precio*$cantidad;
            $carro->id_usuario = auth()->user()->id;
            $carro->save();
            DB::table('producto_carrito')->insert([
                'id_producto' => $producto->id,
                'id_carrito' => $carro->id,
                'cantidad' => $cantidad
            ]);
        }else{
            $carrito->subtotal += $producto->precio*$cantidad;
            if($carrito->id_cupon == null){
                $carrito->total += $producto->precio*$cantidad;
            }else{
                $cupon = Cupon::where('id',$carrito->id_cupon)->first();
                $carrito->total = $carrito->subtotal + $producto->precio*$cantidad*$cupon->descuento/100;
            }
            $carrito->save();
            $productocarrito = DB::table('producto_carrito')->where('id_producto',$producto->id)->where('id_carrito',$carrito->id)->first();
            if($productocarrito == ""){
                DB::table('producto_carrito')->insert([
                    'id_producto' => $producto->id,
                    'id_carrito' => $carrito->id,
                    'cantidad' => $cantidad
                ]);
            }else{
                DB::table('producto_carrito')->where('id_producto',$producto->id)->where('id_carrito',$carrito->id)->update([
                    'cantidad' => $productocarrito->cantidad + $cantidad
                ]);
            }
        }
        return true;
    }

    public function iniciar_venta(Request $request){
        // $nueva_compra = new Compra();
        // $nueva_compra->id_cupon = 2; // null, 1, 2, 3, ...
        // $cupon_compra = Cupon::where('id',$nueva_compra->id_cupon)->first();
        // $nueva_compra->subtotal = 8000;
        // if($nueva_compra->id_cupon != null){
        //     $nueva_compra->total = round($nueva_compra->subtotal*(100-$cupon_compra->descuento)/100);
        // }else{
        //     $nueva_compra->total = $nueva_compra->subtotal;
        // }
        // $nueva_compra->id_usuario = Auth::user()->id;
        // $nueva_compra->save();
        $nueva_compra = Compra::where('id_usuario',auth()->user()->id)->where('estado','por_pagar')->first();
        $url_to_pay = self::start_web_pay_plus_transaction($nueva_compra);
        // return $url_to_pay;
        return redirect($url_to_pay);
    }

    public function start_web_pay_plus_transaction($nueva_compra){
        $transaccion = (new Transaction)->create(
            $nueva_compra->id, //buy_order
            $nueva_compra->id_usuario, // session_id
            $nueva_compra->total, // amount
            route('confirmar_pago')
        );
        $url = $transaccion->getUrl().'?token_ws='.$transaccion->getToken();
        return $url;
    }

    public function confirmar_pago(Request $request){
        $confirmacion = (new Transaction)->commit($request->get('token_ws'));
        $compra = Compra::where('id', $confirmacion->buyOrder)->first();
        $local = Local::where('id', $compra->local_origen)->first();
        if($confirmacion->isApproved()){
            $venta = new Venta();
            $venta->numeroPedido = $compra->id;
            if($confirmacion->paymentTypeCode == 'VD'){
                $venta->tipoPago = 'debito';
            }else if($confirmacion->paymentTypeCode == 'VN'){
                $venta->tipoPago = 'credito';
            }else if($confirmacion->paymentTypeCode == 'VP'){
                $venta->tipoPago = 'prepago';
            }
            $venta->tarjeta = $confirmacion->cardNumber;
            $venta->subtotal = $compra->subtotal;
            $venta->id_cupon = $compra->id_cupon;
            $venta->id_usuario = Auth::user()->id;
            $venta->total = $compra->total;
            $venta->local_origen = $compra->local_origen;
            $compra->estado = 'pagado';
            $compra->update();
            if($compra->id_cupon != null){
                $cupon_compra = Cupon::where('id',$compra->id_cupon)->first();
            }else{
                $cupon_compra = new Cupon;
            }
            $direccion = User::where('id',Auth::user()->id)->first();
            $venta->coordenadas=$direccion->coordenadas;
            if($compra->destino == 'retirolocal'){
                $venta->direccionEntrega = $local->nombre;
            }else if($compra->destino == 'adomicilio'){
                $venta->direccionEntrega = $direccion->entrega;
            }
            $venta->destino = $compra->destino;
            $confirmacion->transactionDate = Carbon::parse($confirmacion->transactionDate)->sub('4 hours');
            $fecha_pago = $confirmacion->transactionDate;
            $fecha_pago = substr($fecha_pago, 0, 10);
            $venta->fechaPedido = $fecha_pago;
            $fecha_pago = Carbon::parse($fecha_pago)->format('d/m/Y');
            $hora_pago = $compra->updated_at;
            $hora_pago = substr($hora_pago, 11, 8);
            $fecha_pago = $fecha_pago." ".$hora_pago;
            $venta->destino = $compra->destino;
            $ventaDuplicada = Venta::where('numeroPedido', $compra->id)->first();
            if($ventaDuplicada == null){
                $venta->save();
            }
            return view('venta.aceptada', compact('confirmacion','compra','fecha_pago','local','cupon_compra','venta'));
            // return redirect(env('URL_FRONTEND_AFTER_PAYMENT')."?compra_id={$compra->id}");
        }else{
            return redirect('/');
            // return "Compra rechazada"; // Reenviar al carrito con mensaje de error
            // return redirect(env('URL_FRONTEND_AFTER_PAYMENT')."?compra_id={$compra->id}");
        }
    }
}
