<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Negocio extends Model
{
    protected $table = 'negocios';

    protected $fillable = [
        'id_usuario',
        'nombre',
        'slug',
        'telefono',
        'direccion',
        'rubro'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(
            Usuario::class,
            'negocio_usuario',
            'id_negocio',
            'id_usuario'
        )->withPivot('id_rol')->withTimestamps();
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'id_negocio');
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'id_negocio');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_negocio');
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'id_negocio');
    }

    public function dueno()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
