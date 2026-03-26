<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudViaje extends Model
{
    use HasFactory;

    protected $table = 'SolicitudesViaje';
    protected $primaryKey = 'IdSolicitud';

    const CREATED_AT = 'FechaCreacion';
    const UPDATED_AT = null;

    protected $fillable = [
        'IdViaje',
        'IdUsuario',
        'AsientosSolicitados',
        'IdEstado',
        'FechaRespuesta',
    ];

    // Relationships

    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'IdViaje', 'IdViaje');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'IdUsuario', 'IdUsuario');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoSolicitud::class, 'IdEstado', 'IdEstado');
    }
}
