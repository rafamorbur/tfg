<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // --- LÍNEAS AÑADIDAS PARA CONECTAR CON TU TABLA ---
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    // --------------------------------------------------

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'password',
        'telefono',
        'documento_tipo',
        'numero_documento',
        'direccion',
        'activo',
        'id_rol',
        'id_muelle'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELACIONES ---
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function muelle()
    {
        return $this->belongsTo(Muelle::class, 'id_muelle');
    }

    public function embarcaciones()
    {
        return $this->belongsToMany(Embarcacion::class, 'usuario_embarcacion', 'id_usuario', 'id_embarcacion')
            ->withPivot('rol', 'fecha_asociacion');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_usuario');
    }
}
