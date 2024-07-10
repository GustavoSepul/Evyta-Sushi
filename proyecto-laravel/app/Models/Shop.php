<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Shop
 *
 * @property $id
 * @property $name
 * @property $address
 * @property $horario
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Shop extends Model
{
    
    static $rules = [
		'name' => 'required',
		'address' => 'required',
		'horario' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','address','horario'];



}
