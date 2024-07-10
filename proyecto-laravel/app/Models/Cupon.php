<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    use HasFactory;
    protected $table ='cupon';
    protected $fillable=['id_usuario','nombre','codigo','descuento','descripcion','fecha_inicio','fecha_final'];
}
