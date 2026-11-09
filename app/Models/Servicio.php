<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicio';
    protected $primaryKey = 'id_servicio';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria',
        'precio_base',
        'unidad_cobro',
        'activo'
    ];

    public function muelles()
    {
        return $this->belongsToMany(Muelle::class, 'muelle_servicio', 'id_servicio', 'id_muelle')
            ->withPivot('precio', 'disponible');
    }
}
