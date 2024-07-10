<?php

namespace App\Http\Livewire;
  
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProductoModel;
use App\Models\Local;
use App\Models\Familia;
use App\Models\Ingrediente;
  
class Posts extends Component
{
    use WithPagination;
    public $id_local, $id_categorias, $id_ingredientes;
    private $pagination = 5;
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $locales = Local::all();
        $categorias = Familia::all();
        $ingredientes = Ingrediente::all();
        return view('landing.catalogo', compact('locales','categorias','ingredientes'))->extends('layouts.layout-landing')->section('content');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // private function resetInputFields(){
    //     $this->id_local = '';
    //     $this->id_categorias = '';
    //     $this->id_ingredientes = '';
    //     $this->buscador = '';
    // }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
}