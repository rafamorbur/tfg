<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Muelle extends Model
{
    protected $table = 'muelle';
    protected $primaryKey = 'id_muelle';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'direccion',
        'localidad',
        'provincia',
        'codigo_postal',
        'latitud',
        'longitud',
        'telefono',
        'email',
        'horario',
        'activo'
    ];

    public function amarres()
    {
        return $this->hasMany(Amarre::class, 'id_muelle');
    }

    public function empleados()
    {
        return $this->hasMany(User::class, 'id_muelle');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'muelle_servicio', 'id_muelle', 'id_servicio')
            ->withPivot('precio', 'disponible', 'observaciones');
    }
}
