<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'nombre',
    ];

    /**
     * Usuarios que tienen este rol (por negocio)
     */
    public function usuarios()
    {
        return $this->belongsToMany(
            Usuario::class,
            'negocio_usuario',
            'id_rol',
            'id_usuario'
        )->withPivot('id_negocio')
         ->withTimestamps();
    }

    /**
     * Negocios donde existe este rol
     */
    public function negocios()
    {
        return $this->belongsToMany(
            Negocio::class,
            'negocio_usuario',
            'id_rol',
            'id_negocio'
        )->withPivot('id_usuario')
         ->withTimestamps();
    }
}
