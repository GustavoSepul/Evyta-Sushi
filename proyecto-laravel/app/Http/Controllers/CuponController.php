<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cupon;
Use Session;
Use Redirect;
Use Carbon\Carbon;
use App\Notifications\DeleteCuponNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Exports\CuponExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Imports\CuponImport;
//use Illuminate\Foundation\Auth;


class CuponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {   $cupons = DB::table('cupon')->get();
        $notifications = auth()->user()->unreadNotifications;
        return view('cupon.index',compact(['cupons'],'notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        
        $carbon=Carbon::now();
        $carbon=$carbon->format('Y-m-d');
        $notifications = auth()->user()->unreadNotifications;
        return view('cupon.create',compact('carbon','notifications'));
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
        'codigo'=>'required|string|max:15',
        'descripcion'=>'required|string|max:100',
        'descuento'=>'required|integer|',
        'fecha_inicio'=>'required|date',
        'fecha_final'=>'required|date',
        
        ];
        $mensaje=[
            'nombre.required'=>'El nombre es requerido',
            'nombre.max'=>'El nombre no debe tener mas de 100 caracteres',
            'codigo.required'=>'El codigo es requerido',
            'codigo.max'=>'El codigo no debe tener mas de 15 caracteres',
            'descripcion.required'=>'La descripción es requerida',
            'descuento.required'=>'El descuento es requerido',
        ];
    
        $this->validate($request,$campos,$mensaje);
        $cupons = request()->except('_token');
        $user = auth()->user();
        
        $cupons['id_usuario']=$user->id; 
      
        if( $cupons['fecha_inicio']>$cupons['fecha_final']){
            
            return redirect('cupon')->with('mensaje','¡FECHA MAL INGRESADA!   ¡Ingrese la Fecha de inicio a antes de la fecha final');
        }
        //return response()->json($cupons);
        Cupon::insert($cupons);
        return redirect('cupon')->with('crear', 'ok');
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
        $cupon=Cupon::findOrFail($id);   
        $notifications = auth()->user()->unreadNotifications;
        return view('cupon.edit',compact('cupon','notifications'));
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {   
        $campos=[
        
            'nombre'=>'required|string|max:100',
            'codigo'=>'required|string|max:15',
            'descripcion'=>'required|string',
            'descuento'=>'required|integer|',   
            'fecha_inicio'=>'required|date',
            'fecha_final'=>'required|date',
            
            ];  

        $mensaje=[
                'nombre.required'=>'El nombre es requerido',
                'nombre.max'=>'El nombre no debe tener mas de 100 caracteres',
                'codigo.required'=>'El codigo es requerido',
                'codigo.max'=>'El codigo no debe tener mas de 15 caracteres',
                'descripcion.required'=>'La descripción es requerida',
                'descuento.required'=>'El descuento es requerido',
        ];
        
        $this->validate($request,$campos,$mensaje);
        $cupon = $request->except(['_token','_method']);

        if( $cupon['fecha_inicio']>$cupon['fecha_final']){
            
            return redirect('cupon')->with('mensaje','¡CUPÓN NO EDITADO! ¡FECHA MAL INGRESADA!   ¡Ingrese la Fecha de inicio a antes de la fecha final');
        }
        Cupon::where('id','=',$id)->update($cupon);
        return redirect('cupon')->with('editar', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cupon=Cupon::findOrFail($id);
        $admins = User::role('administrador')->get();
        Notification::send($admins, new DeleteCuponNotification($cupon));
        Cupon::destroy($id);
        return redirect('cupon')->with('eliminar', 'ok');
    }

    public function descargarCupon(){
        return Storage::disk('public')->download('PlantillaCupon.xlsx');
    }

    public function importarCupon(Request $request){
        // Excel::import(new CuponImport, $request->file('plantillaCupon'));
        if ($request->hasFile('plantillaCupon')) {
            $file = $request->file('plantillaCupon');
            $import = new CuponImport;
            $import->import($file);
            return $request;
        }
        return $request;
    }

    public function exportarCupon(){
        return Excel::download(new CuponExport, 'cupones.xlsx');
    }
}
