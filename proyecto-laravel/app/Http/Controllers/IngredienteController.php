<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ingrediente;
use App\Notifications\DeleteIngredienteNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;


class IngredienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingredientes = DB::table('ingrediente')->get();
        $notifications = auth()->user()->unreadNotifications;
        return view('ingrediente.index',compact(['ingredientes'],'notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notifications = auth()->user()->unreadNotifications;
        return view('ingrediente.create',compact('notifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //resive la informacion y la prepara para que se guarde (En tabla o accediendo a bd)
    {
        //$datosLocal = request()->all(); //obtiene toda la informacion que le envian
        /*
        $datosLocal = request()->except('_token');   //Recolecta toda la info excepto el token;
        Local::insert($datosLocal); //Agarra el modelo e inserta los datos de la variable $datosLocal
        
        return response()->json($datosLocal);   //responde y muestra en formato Json la info 
        */
        $campos=[
        
            'nombre'=>'required|string|max:100',
            
            ]; 
            $mensaje=[
                'nombre.required'=>'El nombre es requerido',
                'nombre.max'=>'El nombre no debe tener mas de 100 caracteres',
            ];
            $this->validate($request,$campos,$mensaje);
        $ingredientes = request()->except('_token');
        Ingrediente::insert($ingredientes);
        return redirect('ingrediente')->with('crear', 'ok');

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
        
        $ingrediente=Ingrediente::findOrFail($id);
        $notifications = auth()->user()->unreadNotifications;
        return view('ingrediente.edit',compact('ingrediente','notifications'));

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
            
            ]; 
            $mensaje=[
                'nombre.required'=>'El nombre es requerido',
                'nombre.max'=>'El nombre no debe tener mas de 100 caracteres',
            ];
            $this->validate($request,$campos,$mensaje);
        $ingredientes = $request->except(['_token','_method']);
        Ingrediente::where('id','=',$id)->update($ingredientes);
        return redirect('ingrediente')->with('editar', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ingrediente=Ingrediente::findOrFail($id);
        $admins = User::role('administrador')->get();
        Notification::send($admins, new DeleteIngredienteNotification($ingrediente));
        Ingrediente::destroy($id);
        return redirect('ingrediente')->with('eliminar', 'ok');

    }
}
