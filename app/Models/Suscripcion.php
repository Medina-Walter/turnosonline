<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    protected $table = 'suscripciones';

    protected $fillable = [
        'id_usuario',
        'id_plan',
        'estado',
        'inicia_en',
        'vence_en',
        'trial_hasta',
        'renovacion_automatica',
        'mp_id',
        'mp_status',
    ];


    public function plan()
    {
        return $this->belongsTo(Plan::class, 'id_plan');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_suscripcion');
    }
}
