<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Embarcacion extends Model
{
    protected $table = 'embarcacion';
    protected $primaryKey = 'id_embarcacion';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'matricula',
        'tipo',
        'eslora',
        'manga',
        'calado',
        'bandera',
        'numero_poliza_seguro',
        'vencimiento_seguro',
        'mmsi',
        'capacidad'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'usuario_embarcacion', 'id_embarcacion', 'id_usuario')
            ->withPivot('rol', 'fecha_asociacion');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_embarcacion');
    }
}
