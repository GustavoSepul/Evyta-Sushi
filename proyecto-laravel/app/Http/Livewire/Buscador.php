<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductoModel;
use App\Models\Local;
use App\Models\Familia;
use App\Models\Ingrediente;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Buscador extends Component
{
    use WithPagination;

    public $buscador, $min_price, $max_price, $start_min, $start_max, $id_local, $id_categoria;
    public $selected = [];

    public function mount(){
        $this->min_price = DB::table('producto')->orderBy('precio','asc')->select('precio')->first()->precio;
        $this->max_price = DB::table('producto')->orderBy('precio','desc')->select('precio')->first()->precio;
        $this->start_min = $this->min_price;
        $this->start_max = $this->max_price;
        $this->id_local = 1;
        $this->id_categoria = 1;
        $ids = DB::table('ingrediente')->select('id')->get();
        foreach($ids as $id){
            array_push($this->selected, $id->id-1);
        }
        array_push($this->selected, count($this->selected));
    }

    public function render()
    {
        $busqueda = $this->buscador;
        $ids_productos = "";
        $ids = DB::select(DB::raw("SELECT DISTINCT producto.id FROM producto JOIN producto_ingrediente ON(producto.id = producto_ingrediente.id_producto) JOIN ingrediente ON(producto_ingrediente.id_ingrediente = ingrediente.id)  JOIN familia ON(producto.id_familia = familia.id) RIGHT JOIN producto_local ON(producto.id = producto_local.id_producto) RIGHT JOIN local ON(producto_local.id_local = local.id) WHERE disponibilidad = 1 AND precio >= ? AND precio <= ?  AND familia.id = ? AND local.id = ? AND INSTR(producto.nombre, '{$this->buscador}') > 0"),[$this->min_price, $this->max_price, $this->id_categoria, $this->id_local]);
        foreach($ids as $id){
            $ids_productos = $ids_productos.$id->id.",";
        }
        $ids_productos = substr($ids_productos,0,-1);
        if($ids_productos != ""){
            $productos = DB::select(DB::raw("SELECT * FROM producto WHERE id IN ($ids_productos)"));
        }else{
            $productos = [];
        }
        $locales = Local::all();
        $categorias = Familia::all();
        $ingredientes = Ingrediente::all();
        return view('livewire.buscador',compact('productos', 'locales', 'categorias', 'ingredientes'));
    }
}
