<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Local;
use App\Notifications\DeleteLocalNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;


class LocalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locals = DB::table('local')->get();
        $notifications = auth()->user()->unreadNotifications;
        return view('local.index',compact(['locals'],'notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notifications = auth()->user()->unreadNotifications;
        return view('local.create',compact('notifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //resive la informacion y la prepara para que se guarde (En tabla o accediendo a bd)
    {
        $campos=[
            'nombre'=>'required|string|max:100',
            'direccion'=>'required|string|max:100',
            'celular'=>'required|string|max:9',
        ];

        $mensaje=[
                'nombre.required'=>'El nombre es requerido',
                'direccion.required'=>'La dirección es requerida',
                'celular.required'=>'El celular es requerido',
        ];


        $this->validate($request,$campos,$mensaje);

        $locals = request()->except('_token');
        if($request->has('abierto')){
            $locals['abierto'] = 1;
        }else{
            $locals['abierto'] = 0;
        }
        Local::insert($locals);
        return redirect('local')->with('crear', 'ok');

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
        
        $local=Local::findOrFail($id);
        $notifications = auth()->user()->unreadNotifications;
        return view('local.edit',compact('local','notifications'));

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
        $locals = $request->except(['_token','_method']);
        if($request->has('abierto')){
            $locals['abierto'] = 1;
        }else{
            $locals['abierto'] = 0;
        }
        Local::where('id','=',$id)->update($locals);
        return redirect('local')->with('editar', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $local=Local::findOrFail($id);
        $admins = User::role('administrador')->get();
        Notification::send($admins, new DeleteLocalNotification($local));
        Local::destroy($id);
        return redirect('local')->with('eliminar', 'ok');
    }
}
