<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'planes';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'precio',
        'features',
        'activo',
    ];

    protected $casts = [
        'features' => 'array',
        'activo' => 'boolean',
    ];
}
