<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'Vehiculos';
    protected $primaryKey = 'IdVehiculo';

    public $timestamps = false;

    protected $fillable = [
        'IdUsuario',
        'Modelo',
        'Placas',
        'Color',
        'Capacidad',
        'Activo',
        'FotoUrl',
    ];

    // Relationships

    public function propietario()
    {
        return $this->belongsTo(Usuario::class, 'IdUsuario', 'IdUsuario');
    }

    public function viajes()
    {
        return $this->hasMany(Viaje::class, 'IdVehiculo', 'IdVehiculo');
    }
}
