<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $table = 'Rutas';
    protected $primaryKey = 'IdRuta';

    public $timestamps = false;

    protected $fillable = [
        'IdOrigen',
        'IdDestino',
        'DistanciaKm',
        'DuracionEstimada',
    ];

    // Relationships

    public function origen()
    {
        return $this->belongsTo(Ubicacion::class, 'IdOrigen', 'IdUbicacion');
    }

    public function destino()
    {
        return $this->belongsTo(Ubicacion::class, 'IdDestino', 'IdUbicacion');
    }

    public function viajes()
    {
        return $this->hasMany(Viaje::class, 'IdRuta', 'IdRuta');
    }
}
