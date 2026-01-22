<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\negocios;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function negocios()
    {
        return $this->belongsToMany(
            Negocio::class,
            'negocio_usuario',
            'id_usuario',
            'id_negocio'
        )->withPivot('id_rol')->withTimestamps();
    }


    public function esAdmin(Negocio $negocio): bool
    {
        return $this->negocios()
            ->where('id_negocio', $negocio->id)
            ->wherePivotIn('id_rol', [1, 2])
            ->exists();
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
}
