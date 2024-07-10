<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Permiso;
use App\Notifications\DeletePermisoNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permisos = Permission::get();
        $notifications = auth()->user()->unreadNotifications;
        return view('permiso.index',compact(['permisos'],'notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notifications = auth()->user()->unreadNotifications;
        return view('permiso.create',compact('notifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   $campos=[
        
        'name'=>'required|string|max:100',
        
        ]; 
        $mensaje=[
            'nombre.required'=>'El nombre es requerido',
            'nombre.max'=>'El nombre no debe tener mas de 100 caracteres',
        ];
        $this->validate($request,$campos,$mensaje);
        $permisos = request()->except('_token');
        Permission::insert($permisos);
        return redirect('permiso')->with('crear', 'ok');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permisos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permiso=Permission::where('id',$id)->first();    
        $notifications = auth()->user()->unreadNotifications;
        return view('permiso.edit',compact('permiso','notifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   $campos=[
        
        'name'=>'required|string|max:100',
        
        ]; 
        $mensaje=[
            'nombre.required'=>'El nombre es requerido',
            'nombre.max'=>'El nombre no debe tener mas de 100 caracteres',
        ];
        $this->validate($request,$campos,$mensaje);
        $permisos = $request->except(['_token','_method']);
        Permission::where('id','=',$id)->update($permisos);
        return redirect('permiso')->with('editar', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permiso=Permission::findOrFail($id);
        $admins = User::role('administrador')->get();
        Notification::send($admins, new DeletePermisoNotification($permiso));
        Permission::destroy($id);
        return redirect('permiso')->with('eliminar', 'ok');
    }
}
