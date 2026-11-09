<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amarre extends Model
{
    protected $table = 'amarre';
    protected $primaryKey = 'id_amarre';
    public $timestamps = false;

    protected $fillable = [
        'id_muelle',
        'numero',
        'eslora_max',
        'manga_max',
        'calado_max',
        'estado',
        'tarifa_base',
        'observaciones',
        'activo'
    ];

    public function muelle()
    {
        return $this->belongsTo(Muelle::class, 'id_muelle');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_amarre');
    }
}
