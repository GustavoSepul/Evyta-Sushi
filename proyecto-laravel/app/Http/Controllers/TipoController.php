<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;
use App\Notifications\DeleteTipoNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class TipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['tipo']=Tipo::paginate();
        $notifications = auth()->user()->unreadNotifications;
        return view('tipo.index',compact('datos','notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notifications = auth()->user()->unreadNotifications;
        return view('tipo.create',compact('notifications'));
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

        $campos=[
        
            'nombre'=>'required|string|max:100',
            
            ]; 
            $mensaje=[
                'nombre.required'=>'El nombre es requerido',
                'nombre.max'=>'El nombre no debe tener mas de 100 caracteres',
            ];
            $this->validate($request,$campos,$mensaje);
        //$datosTipo = request()->all();
        $datosTipo = request()->except('_token');
        Tipo::insert($datosTipo);
        
        //return response()->json($datosTipo);
        return redirect('tipo')->with('crear','ok');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function show(tipo $tipo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $tipo=Tipo::findOrFail($id);
        $notifications = auth()->user()->unreadNotifications;
        return view('tipo.edit', compact('tipo','notifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $campos=[
        
            'nombre'=>'required|string|max:100',
            
            ]; 
            $mensaje=[
                'nombre.required'=>'El nombre es requerido',
                'nombre.max'=>'El nombre no debe tener mas de 100 caracteres',
            ];
            $this->validate($request,$campos,$mensaje);

        $datosTipo = request()->except(['_token','_method']);

        Tipo::where('id','=',$id)->update($datosTipo);
        $tipo=Tipo::findOrFail($id);
        //return view('tipo.edit', compact('tipo'));

        return redirect('tipo')->with('editar','ok');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tipo=Tipo::findOrFail($id);
        $admins = User::role('administrador')->get();
        Notification::send($admins, new DeleteTipoNotification($tipo));
        Tipo::destroy($id);
        return redirect('tipo')->with('eliminar', 'ok');

    }
}