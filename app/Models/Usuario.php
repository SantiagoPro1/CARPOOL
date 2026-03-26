<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Usuarios';
    protected $primaryKey = 'IdUsuario';

    const CREATED_AT = 'FechaCreacion';
    const UPDATED_AT = 'FechaActualizacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Correo',
        'Contrasena',
        'NombreCompleto',
        'Telefono',
        'Activo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'Contrasena',
    ];

    /**
     * Override default password field name for Laravel Auth.
     */
    public function getAuthPassword()
    {
        return $this->Contrasena;
    }

    // Relationships

    public function perfil()
    {
        return $this->hasOne(PerfilUsuario::class, 'IdUsuario', 'IdUsuario');
    }

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'IdUsuario', 'IdUsuario');
    }

    public function viajesComoConductor()
    {
        return $this->hasMany(Viaje::class, 'IdConductor', 'IdUsuario');
    }

    public function calificacionesRecibidas()
    {
        return $this->hasMany(Calificacion::class, 'IdUsuario', 'IdUsuario');
    }

    public function calificacionesEmitidas()
    {
        return $this->hasMany(Calificacion::class, 'IdEmisor', 'IdUsuario');
    }

    public function solicitudesDeViaje()
    {
        return $this->hasMany(SolicitudViaje::class, 'IdUsuario', 'IdUsuario');
    }

    public function viajesComoPasajero()
    {
        return $this->belongsToMany(Viaje::class, 'ParticipantesViaje', 'IdUsuario', 'IdViaje')
                    ->withPivot(['IdSolicitud', 'FechaSalida']);
    }
}
