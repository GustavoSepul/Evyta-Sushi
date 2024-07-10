<?php

namespace App\Http\Controllers;

use App\Models\Subfamilia;
use Illuminate\Http\Request;
use App\Notifications\DeleteSubcategoriaNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class SubfamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['subfamilia']=Subfamilia::paginate();
        $notifications = auth()->user()->unreadNotifications;
        return view('subfamilia.index',compact('datos','notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notifications = auth()->user()->unreadNotifications;
        return view('subfamilia.create',compact('notifications'));
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
        //$datosSubfamilia = request()->all();
        $datosSubfamilia = request()->except('_token');
        Subfamilia::insert($datosSubfamilia);
        
        //return response()->json($datosSubfamilia);
        return redirect('subfamilia')->with('crear','ok');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subfamilia  $subfamilia
     * @return \Illuminate\Http\Response
     */
    public function show(subfamilia $subfamilia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subfamilia  $subfamilia
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $subfamilia=Subfamilia::findOrFail($id);
        $notifications = auth()->user()->unreadNotifications;
        return view('subfamilia.edit', compact('subfamilia','notifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subfamilia  $subfamilia
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

        $datosSubfamilia = request()->except(['_token','_method']);

        Subfamilia::where('id','=',$id)->update($datosSubfamilia);
        $subfamilia=Subfamilia::findOrFail($id);
        //return view('subfamilia.edit', compact('subfamilia'));

        return redirect('subfamilia')->with('editar','ok');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subfamilia  $subfamilia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $subfamilia=Subfamilia::findOrFail($id);
        $admins = User::role('administrador')->get();
        Notification::send($admins, new DeleteSubcategoriaNotification($subfamilia));
        Subfamilia::destroy($id);
        return redirect('subfamilia')->with('eliminar', 'ok');
    }
}