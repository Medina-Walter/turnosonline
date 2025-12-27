<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = 'turnos';

    protected $fillable = [
        'id_negocio',
        'id_cliente',
        'id_servicio',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado'
    ];

    public function negocios()
    {
        return $this->belongsTo(Negocio::class, 'id_negocio');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }
}
