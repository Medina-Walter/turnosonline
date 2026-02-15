<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Negocio;


class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    protected $casts = [
        'is_superadmin' => 'boolean',
    ];


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

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'id_usuario');
    }

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

    public function esSuperAdmin(): bool
    {
        return (bool) $this->is_superadmin;
    }



    public function rolesPivot()
    {
        return $this->belongsToMany(
            Rol::class,
            'negocio_usuario',
            'id_usuario',
            'id_rol'
        )
            ->withPivot('id_negocio')
            ->withTimestamps();
    }

    public function rolEnNegocio(Negocio $negocio)
    {
        return $this->rolesPivot
            ->where('pivot.id_negocio', $negocio->id)
            ->first();
    }

    public function suscripcion()
    {
        return $this->hasOne(Suscripcion::class, 'id_usuario');
    }




    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
