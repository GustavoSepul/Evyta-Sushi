<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table ='ventas';

    protected $fillable = [
        'numeroPedido',
        'fechaPedido',
        'direccionEntrega',
        'tipoPago',
        'tarjeta',
        'subtotal',
        'id_cupon',
        'total',
        'id_usuario'
    ];
}
