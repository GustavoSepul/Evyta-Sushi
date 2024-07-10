<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Local;

class GoogleController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $locals = DB::table('local')->get();
        return view('googleAutocomplete',compact(['locals']));
    }


    public function reparto($id)
    {
        $local=Local::findOrFail($id);
        return view('local.maps_maker',compact(['local']));
    }
    
}