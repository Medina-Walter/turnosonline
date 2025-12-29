<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'id_negocio',
        'dia',
        'hora_apertuna',
        'hora_cierre'
    ];

    public function negocios()
    {
        return $this->belongsTo(Negocio::class, 'id_negocio');
    }
}
