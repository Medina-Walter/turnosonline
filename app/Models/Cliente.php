<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'id_negocio',
        'nombre',
        'telefono',
        'email'
    ];

    public function negocio()
    {
        return $this->BelongsTo(Negocio::class, 'id_negocio');
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'id_cliente');
    }
}
