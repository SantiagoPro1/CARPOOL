<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    use HasFactory;

    protected $table = 'Viajes';
    protected $primaryKey = 'IdViaje';

    const CREATED_AT = 'FechaPublicacion';
    const UPDATED_AT = null;

    protected $fillable = [
        'IdRuta',
        'IdConductor',
        'IdVehiculo',
        'FechaSalida',
        'LlegadaEstimada',
        'AsientosTotales',
        'AsientosDisponibles',
        'PrecioPorPasajero',
        'Notas',
        'IdEstado',
    ];

    // Relationships

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'IdRuta', 'IdRuta');
    }

    public function conductor()
    {
        return $this->belongsTo(Usuario::class, 'IdConductor', 'IdUsuario');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'IdVehiculo', 'IdVehiculo');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoViaje::class, 'IdEstado', 'IdEstado');
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'IdViaje', 'IdViaje');
    }

    public function solicitudes()
    {
        return $this->hasMany(SolicitudViaje::class, 'IdViaje', 'IdViaje');
    }

    public function pasajeros()
    {
        return $this->belongsToMany(Usuario::class, 'ParticipantesViaje', 'IdViaje', 'IdUsuario')
                    ->withPivot(['IdSolicitud', 'FechaSalida']);
    }
}
