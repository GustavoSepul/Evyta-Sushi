<?php

namespace App\Http\Controllers;

use App\Models\Familia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\DeleteCategoriaNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class FamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['familia']=Familia::paginate();
        $notifications = auth()->user()->unreadNotifications;
        return view('familia.index',compact('datos','notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['subfamilias'] = DB::table('subfamilia')->get();
        $data['tipos'] = DB::table('tipo')->get();
        $notifications = auth()->user()->unreadNotifications;
        return view('familia.create',compact('data','notifications'));
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
        $datosFamilia = request()->except('_token','subcategoria','tipo');
        Familia::insert($datosFamilia);
        $familiaId = DB::SELECT('SELECT id FROM familia ORDER BY id DESC LIMIT 1');
        $subfamilias = $request['subcategoria'];
        foreach ($subfamilias as $subfamilia) {
            DB::insert('INSERT INTO familia_subfamilia VALUES ('.$familiaId[0]->id.','.$subfamilia.')');
        }
        $tipos = $request['tipo'];
        foreach ($tipos as $tipo) {
            DB::insert('INSERT INTO familia_tipo VALUES ('.$familiaId[0]->id.','.$tipo.')');
        }
        return redirect('familia')->with('crear','ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\familia  $familia
     * @return \Illuminate\Http\Response
     */
    public function show(familia $familia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\familia  $familia
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $familia=Familia::findOrFail($id);
        $allSubfamilias = DB::table('subfamilia')->get();
        $subfamilias = DB::select('SELECT subfamilia.id, subfamilia.nombre FROM subfamilia JOIN familia_subfamilia ON(subfamilia.id = familia_subfamilia.id_subfamilia) WHERE '.$id.' = id_familia');
        $allTipos = DB::table('tipo')->get();
        $tipos = DB::select('SELECT tipo.id, tipo.nombre FROM tipo JOIN familia_tipo ON(tipo.id = familia_tipo.id_tipo) WHERE '.$id.' = id_familia');
        $notifications = auth()->user()->unreadNotifications;
        return view('familia.edit', compact('familia','allSubfamilias','subfamilias','allTipos','tipos','notifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\familia  $familia
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

        $datosFamilia = request()->except(['_token','_method','subcategoria','tipo']);

        Familia::where('id','=',$id)->update($datosFamilia);
        $familia=Familia::findOrFail($id);
        DB::delete('DELETE FROM familia_subfamilia WHERE id_familia='.$id.'');
        $subcategoriaEdit = $request['subcategoria'];
        foreach ($subcategoriaEdit as $subcategorias) {
            DB::insert('INSERT INTO familia_subfamilia VALUES ('.$id.','.$subcategorias.')');
        }
        DB::delete('DELETE FROM familia_tipo WHERE id_familia='.$id.'');
        $tipoEdit = $request['tipo'];
        foreach ($tipoEdit as $tipo) {
            DB::insert('INSERT INTO familia_tipo VALUES ('.$id.','.$tipo.')');
        }
        return redirect('familia')->with('editar','ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\familia  $familia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $familia=Familia::findOrFail($id);
        $admins = User::role('administrador')->get();
        Notification::send($admins, new DeleteCategoriaNotification($familia));
        Familia::destroy($id);
        DB::delete('DELETE FROM familia_subfamilia WHERE id_familia='.$id.'');
        DB::delete('DELETE FROM familia_tipo WHERE id_familia='.$id.'');
        return redirect('familia')->with('eliminar', 'ok');
    }
}
