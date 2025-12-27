<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'id_negocio',
        'nombre',
        'duracion',
        'precio'
    ];

    public function negocio()
    {
        return $this->belongsTo(Negocio::class, 'id_negocio');
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'id_servicio');
    }
}
