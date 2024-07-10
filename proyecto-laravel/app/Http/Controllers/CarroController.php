<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Compra;
use App\Models\Cupon;
use App\Models\Local;
use App\Models\User;
use App\Models\ProductoModel;
use Carbon\Carbon;

class CarroController extends Controller
{
    public function carrito_personal(){
        $productos=DB::table('carrito')
        ->join('producto_carrito','carrito.id','=','producto_carrito.id_carrito')
        ->join('producto','producto_carrito.id_producto','=','producto.id')
        ->where('carrito.id_usuario','=',auth()->user()->id)
        ->where('carrito.estado','=','por_pagar')
        ->get();
        $locales=Local::all();
        if(count($productos)>0){
            return view('carrito.index',compact('productos','locales'));
        }else{
            return redirect('/');
        }
        
    }

    public function cantidad_productos(){
        if(isset(auth()->user()->id)){
            $productos=DB::table('carrito')
            ->join('producto_carrito','carrito.id','=','producto_carrito.id_carrito')
            ->join('producto','producto_carrito.id_producto','=','producto.id')
            ->where('carrito.estado','=','por_pagar')
            ->where('carrito.id_usuario','=',auth()->user()->id)
            ->get();
            return $productos;
        }else{
            return 0;
        }

    }
    public function selecciondepago(Request $request){
        $hora=strtotime(date('H:i:s'));
        $productos=DB::table('carrito')
        ->join('producto_carrito','carrito.id','=','producto_carrito.id_carrito')
        ->join('producto','producto_carrito.id_producto','=','producto.id')
        ->leftjoin('cupon','carrito.id_cupon','=','cupon.id')
        ->where('carrito.id_usuario','=',auth()->user()->id)
        ->where('carrito.estado','=','por_pagar')
        ->select('producto.imagen','producto.nombre','producto.descripcion','producto_carrito.cantidad','producto.precio','carrito.subtotal','carrito.id_cupon','carrito.total','cupon.descuento')
        ->get();
        $usuario = User::where('id', auth()->user()->id)->first();
        $ubicacion_reparto = Compra::where('id_usuario',auth()->user()->id)->where('estado','por_pagar')->first();
        $local = Local::where('id', $request->local)->first();
        $hora_c= strtotime($local->horario_c);
        $hora_a= strtotime($local->horario_a);
        $ubicacion_reparto->local_origen=$request->local;
        $ubicacion_reparto->destino = $request->formaretiro;
        $ubicacion_reparto->save();
        if($request->formaretiro == 'retirolocal'){
            $usuario->coordenadas = $local->latitud.",".$local->longitud;
        }else if($request->formaretiro == 'adomicilio'){
            $usuario->coordenadas = $request->direccionEntrega;
            $usuario->entrega = $request->entrega;
        }
        $usuario->save();
        if ($hora < $hora_c and  $hora > $hora_a and $local->abierto == true) {
            return view('carrito.selecciondepago',compact('productos','hora','hora_c','hora_a'));
        }else{
            return redirect('/')->with('horario', 'no');
        }
        
    }

    public function ingresadireccion(Request $request){
        $hora=strtotime(date('H:i:s'));
        $productos=DB::table('carrito')
        ->join('producto_carrito','carrito.id','=','producto_carrito.id_carrito')
        ->join('producto','producto_carrito.id_producto','=','producto.id')
        ->leftjoin('cupon','carrito.id_cupon','=','cupon.id')
        ->where('carrito.id_usuario','=',auth()->user()->id)
        ->where('carrito.estado','=','por_pagar')
        ->select('producto.imagen','producto.nombre','producto.descripcion','producto_carrito.cantidad','producto.precio','carrito.subtotal','carrito.id_cupon','carrito.total','cupon.descuento', 'producto.id')
        ->get();
        $local=Local::where('id',$request->local)->first();
        $hora_c= strtotime($local->horario_c);
        $hora_a= strtotime($local->horario_a);
        $ubicacion_reparto = Compra::where('id_usuario',auth()->user()->id)->where('estado','por_pagar')->first();
        $ubicacion_reparto->local_origen=$request->local;
        $ubicacion_reparto->destino = 'domicilio';
        $ubicacion_reparto->save();
        if ($hora < $hora_c and  $hora > $hora_a and $local->abierto == true) {
            return view('carrito.ingresadireccion',compact('productos','local','hora','hora_c','hora_a'));
        }else{
            return redirect('/')->with('horario', 'no');
        }
        
       
    }
    public function datoscarrito($id){
        $productos=DB::table('carrito')
        ->join('producto_carrito','carrito.id','=','producto_carrito.id_carrito')
        ->join('producto','producto_carrito.id_producto','=','producto.id')
        ->where('carrito.id_usuario','=',$id)
        ->where('carrito.estado','=','por_pagar')
        ->get();
        return $productos;

    }
    public function eliminardelcarrito($id,$cantidad){
        if($cantidad < 1){
            return false;
        }
        $carrito=Compra::where('id_usuario',auth()->user()->id)->where('estado','por_pagar')->first();
        $producto=ProductoModel::where('id',$id)->first();
        $productocarrito=DB::table('producto_carrito')->where('id_producto',$producto->id)->where('id_carrito',$carrito->id)->first();
        
        if($productocarrito->cantidad > $cantidad){
            DB::table('producto_carrito')->where('id_producto',$producto->id)->where('id_carrito',$carrito->id)
            ->update(['cantidad'=>$productocarrito->cantidad-$cantidad]);
            if($carrito->id_cupon==NULL){
                $carrito->subtotal=$carrito->subtotal-$producto->precio*$cantidad;
                $carrito->total=$carrito->subtotal;
                $carrito->save();
            }else{
                $cupon=Cupon::where('id',$carrito->id_cupon)->first();
                $carrito->subtotal=$carrito->subtotal-$producto->precio*$cantidad;
                $carrito->total= $carrito->subtotal*$cupon->descuento/100;
                $carrito->save();
            }
        }else{
            
            if($carrito->id_cupon==NULL){
                $carrito->subtotal=$carrito->subtotal-$producto->precio*$productocarrito->cantidad;
                $carrito->total=$carrito->subtotal;
                $carrito->save();
            }else{
                
                $cupon=Cupon::where('id',$carrito->id_cupon)->first();
                $carrito->subtotal=$carrito->subtotal-$producto->precio*$productocarrito->cantidad;
                $carrito->total= $carrito->subtotal*$cupon->descuento/100;
                $carrito->save();
            }
            DB::table('producto_carrito')->where('id_producto',$producto->id)->where('id_carrito',$carrito->id)
            ->delete();
        }
        if($carrito->subtotal==0){
            $carrito->delete();
        }return true;
    }
    public function ingresocupon($codigo){
        $cupon = Cupon::where('codigo',$codigo)->first();
        $carrito=Compra::where('id_usuario',auth()->user()->id)->first();
        if($cupon != ''){
            $now = Carbon::now()->toDateString();
           if($now < $cupon->fecha_final && $now > $cupon->fecha_inicio){
                $carrito->total= $carrito->subtotal*(100-$cupon->descuento)/100;
                $carrito->id_cupon=$cupon->id;
                $carrito->save();
                return $cupon;
           }else{
                return false;
           }
        }else{
            return false;
        }
    }    
    public function verdetalles($id){
        $info = DB::table('producto')
        ->leftjoin('familia', 'producto.id_familia', '=', 'familia.id')
        ->leftjoin('familia_subfamilia', 'familia.id', '=', 'familia_subfamilia.id_familia')
        ->leftjoin('subfamilia', 'familia_subfamilia.id_subfamilia', '=', 'subfamilia.id')
        ->leftjoin('producto_ingrediente', 'producto.id', '=', 'producto_ingrediente.id_producto')
        ->leftjoin('ingrediente', 'producto_ingrediente.id_ingrediente', '=', 'ingrediente.id')
        ->leftjoin('producto_local', 'producto.id', '=', 'producto_local.id_producto')
        ->leftjoin('local', 'producto_local.id_local', '=', 'local.id')
        ->leftjoin('familia_tipo', 'familia.id', '=', 'familia_tipo.id_familia')
        ->leftjoin('tipo', 'familia_tipo.id_tipo', '=', 'tipo.id')
        ->where('producto.id','=',$id)
        ->select('producto.nombre as nombre_producto','familia.nombre as nombre_familia','disponibilidad','descripcion','precio','imagen','producto.id','ingrediente.nombre as nombre_ingrediente','subfamilia.nombre as nombre_subfamilia','tipo.nombre as nombre_tipo','local.nombre as nombre_local')
        ->get();
        return json_encode(array('info'=>$info));
    }

    public function cambiardireccion(Request $request){
        $productos=DB::table('carrito')
        ->join('producto_carrito','carrito.id','=','producto_carrito.id_carrito')
        ->join('producto','producto_carrito.id_producto','=','producto.id')
        ->leftjoin('cupon','carrito.id_cupon','=','cupon.id')
        ->where('carrito.id_usuario','=',auth()->user()->id)
        ->where('carrito.estado','=','por_pagar')
        ->select('producto.imagen','producto.nombre','producto.descripcion','producto_carrito.cantidad','producto.precio','carrito.subtotal','carrito.id_cupon','carrito.total','cupon.descuento', 'producto.id')
        ->get();
       
        $local=Local::where('id',$request->local)->first();
        return view('carrito.cambiardireccion',compact('productos','local'));
        
    }
}
