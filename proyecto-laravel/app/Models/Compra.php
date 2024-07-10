<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table ='carrito';

    protected $fillable = [
        'subtotal',
        'total',
        'id_cupon',
        'id_usuario'
    ];

    protected $attributes = [
        'estado' => 'por_pagar',
    ];
}
