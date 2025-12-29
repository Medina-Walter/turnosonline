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
        'email',
        'direccion'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
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

}    

