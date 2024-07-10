<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Notifications\DeleteUserNotification;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use App\Models\Local;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['users']=User::paginate();
        $datosrol['users'] = User::all();
        $notifications = auth()->user()->unreadNotifications;
        // return response()->json($datosrol);
        return view('users.index',compact('datos','datosrol','notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $datos = Role::get();
        $locales = Local::get();
        $notifications = auth()->user()->unreadNotifications;
        return view('users.create',compact('datos','notifications','locales'));
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
            'rut'=>'required|string|max:10|unique:users,rut',
            'name'=>'required|string|max:100',
            'password'=>'required|string|max:15',
            'email'=>'required|email|unique:users,email',
            'direccion'=>'required|string|max:150',
            'celular'=>'required|string|max:9',
            'telefono'=>'max:9',
            'imagen'=>'max:10000|mimes:jpeg,png,jpg',
            'rolName'=>'required|string|max:100',
        ];

        $mensaje=[
                'rut.required'=>'El Rut es requerido',
                'rut.unique'=>'El rut ingresado ya esta resgistrado',
                'name.required'=>'El nombre es requerido',
                'name.max'=>'El nombre no debe tener mas de 100 caracteres',
                'password.required'=>'La constraseña es requerida',
                'email.required'=>'El email es requerido',
                'email.email'=>'El email ingresado no es valido',
                'email.unique'=>'El correo ingresado ya esta resgistrado',
                'direccion.required'=>'La dirección es requerida',
                'direccion.max'=>'La dirección no debe tener mas de 150 caracteres',
                'celular.required'=>'El celular es requerido',
                'rolName.required'=>'El rol es requerido'
        ];


        $this->validate($request,$campos,$mensaje);

        //$datosUsers = request()->all();
        $datosUsers = request()->except('_token','rolName');
        $rolUser = $request->rolName;
        if($request->hasFile('imagen')){
            $datosUsers['imagen']=$request->file('imagen')->store('uploads', 'public');
        }
        $datosUsers['entrega']=$datosUsers['direccion'];
        $datosUsers['password']=Hash::make($datosUsers['password']);
        User::insert($datosUsers);
        User::where('rut',$datosUsers['rut'])->first()->assignRole($rolUser);
        // return response()->json($datosUsers);
        return redirect('users')->with('crear', 'ok');

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
        $users=User::where('id',$id)->first();
        $datos = Role::get();
        $notifications = auth()->user()->unreadNotifications;
        return view('users.edit', compact('users','datos','notifications'));
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
            'name'=>'required|string|max:100',
            'direccion'=>'required|string|max:150',
            'celular'=>'required|string|max:9',
            'telefono'=>'max:9',
            'imagen'=>'max:10000|mimes:jpeg,png,jpg,webp',
            'rolName'=>'required|string|max:100',
        ];

        $mensaje=[
                'name.required'=>'El nombre es requerido',
                'name.max'=>'El nombre no debe tener mas de 100 caracteres',
                'direccion.required'=>'La dirección es requerida',
                'direccion.max'=>'La dirección no debe tener mas de 150 caracteres',
                'celular.required'=>'El celular es requerido',
                'rolName.required'=>'El rol es requerido'
        ];


        $this->validate($request,$campos,$mensaje);
        //
        $datosUsers = request()->except('_token','_method','rolName');
        $datosUsers['entrega']=$datosUsers['direccion'];
        if($request->hasFile('imagen')){
            $users=User::findOrFail($id);
            Storage::delete('public/'.$users->imagen);
            $datosUsers['imagen']=$request->file('imagen')->store('uploads', 'public');
        }
        User::where('id','=',$id)->update($datosUsers);
        $user = User::where('id',$id)->first();
        $user->syncRoles($request['rolName']);
        //return view('users.edit', compact('users'));

        return redirect('users')->with('editar','ok');
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
        $users=User::findOrFail($id);
        $admins = User::role('administrador')->get();
        Notification::send($admins, new DeleteUserNotification($users));
        if(Storage::delete('public/'.$users->imagen)){
            User::destroy($id);
        }
            User::destroy($id);
        return redirect('users')->with('eliminar', 'ok');
    }
    public function registrarCliente(Request $request){
        $datosUsers = request()->except('_token');

        $campos=[
            'rut'=>'required|string|max:10|unique:users,rut',
            'name'=>'required|string|max:100',
            'password'=>'required|string|max:15',
            'email'=>'required|email|unique:users,email',
            'direccion'=>'required|string|max:150',
            'celular'=>'required|string|max:9',
            'telefono'=>'max:9',
            'imagen'=>'max:10000|mimes:jpeg,png,jpg',
        ];

        $mensaje=[
                'rut.required'=>'El Rut es requerido',
                'rut.unique'=>'El rut ingresado ya esta resgistrado',
                'name.required'=>'El nombre es requerido',
                'name.max'=>'El nombre no debe tener mas de 100 caracteres',
                'password.required'=>'La constraseña es requerida',
                'email.required'=>'El email es requerido',
                'email.email'=>'El email ingresado no es valido',
                'email.unique'=>'El correo ingresado ya esta resgistrado',
                'direccion.required'=>'La dirección es requerida',
                'direccion.max'=>'La dirección no debe tener mas de 150 caracteres',
                'celular.required'=>'El celular es requerido',
                'password.max'=>'La contraseña no debe tener mas de 15 caracteres',
        ];


        $this->validate($request,$campos,$mensaje);

        $datosUsers['password']=Hash::make($datosUsers['password']);
        $datosUsers['entrega']=$datosUsers['direccion'];
        User::insert($datosUsers);
        User::where('rut',$datosUsers['rut'])->first()->assignRole('cliente');

        // return response()->json($datosUsers);
        return redirect('logIn')->with('mensaje','Se ha registrado con éxito');
    }

    public function destroy_imagen(Request $request, $id)
    {
        $users=User::findOrFail($id);
        Storage::delete('public/'.$users->imagen);
        $datosUsers['imagen']=$request->NULL;
        User::where('id','=',$id)->update($datosUsers);
        
        return redirect('users')->with('eliminar', 'ok');

    }
}