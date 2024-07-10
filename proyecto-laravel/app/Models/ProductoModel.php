<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ProductoModelFactory;

class ProductoModel extends Model
{
    use HasFactory;
    protected $table = 'producto';
    protected $fillable = [
        'nombre',
        'disponibilidad',
        'descripcion',
        'precio',
        'imagen',
        'id_familia'
    ];
}
