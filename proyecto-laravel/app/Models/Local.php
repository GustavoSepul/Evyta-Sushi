<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;
    protected $table ='local';
    protected $fillable=['nombre' , 'direccion' , 'celular', 'abierto', 'horario_a', 'horario_c', 'latitud', 'longitud'];

}