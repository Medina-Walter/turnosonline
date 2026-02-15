<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'id_usuario',
        'id_suscripcion',
        'monto',
        'moneda',
        'proveedor',
        'referencia',
        'estado',
        'pagado_en'
    ];

    public function suscripcion()
    {
        return $this->belongsTo(Suscripcion::class, 'id_suscripcion');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
