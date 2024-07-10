<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rol;
use App\Notifications\DeleteRolNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        {   $rols = Role::get();
            $notifications = auth()->user()->unreadNotifications;
            return view('rol.index',compact(['rols'],'notifications'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['permisos'] = Permission::get();
        $notifications = auth()->user()->unreadNotifications;
        return view('rol.create',compact('data','notifications'));
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
            'name'=>'required|string|max:100',
        ]; 
        $mensaje=[
            'nombre.required'=>'El nombre es requerido',
            'nombre.max'=>'El nombre no debe tener mas de 100 caracteres',
        ];
        $this->validate($request,$campos,$mensaje);
        $rol = request()->except('_token','rol');
        $permisos = request()->except('_token','name','guard_name');
        Role::insert($rol);
        Role::where('name',$rol['name'])->first()->syncPermissions($permisos);
        return redirect('rol')->with('crear', 'ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function show(Rol $rol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rol=Role::where('id',$id)->first();
        $permisos = Role::findByName($rol['name'])->permissions;
        $allPermisos = Permission::get();
        $notifications = auth()->user()->unreadNotifications;
        return view('rol.edit',compact('rol','permisos','allPermisos','notifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rol  $rol
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
        $rol = $request->except(['_token','_method','rolEdit']);
        $permissions = $request->except(['_token','_method','name']);
        Role::where('id',$id)->update($rol);
        Role::where('name',$rol['name'])->first()->syncPermissions($permissions);
        return redirect('rol')->with('editar', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rol=Role::where('id',$id)->first();
        $admins = User::role('administrador')->get();
        Notification::send($admins, new DeleteRolNotification($rol));
        Role::destroy($id);
        return redirect('rol')->with('eliminar', 'ok');
    }

    public function getRoles(){
        $roles = Role::get();
        return $roles;
    }
}
