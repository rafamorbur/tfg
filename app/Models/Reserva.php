<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reserva';
    protected $primaryKey = 'id_reserva';

    protected $fillable = [
        'codigo_reserva',
        'id_usuario',
        'id_embarcacion',
        'id_amarre',
        'fecha_entrada',
        'fecha_salida',
        'estado',
        'precio_total',
        'observaciones'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function embarcacion()
    {
        return $this->belongsTo(Embarcacion::class, 'id_embarcacion');
    }

    public function amarre()
    {
        return $this->belongsTo(Amarre::class, 'id_amarre');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'reserva_servicio', 'id_reserva', 'id_servicio')
            ->withPivot('cantidad', 'precio_unitario', 'subtotal');
    }
}
