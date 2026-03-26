<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ParticipanteViaje extends Pivot
{
    protected $table = 'ParticipantesViaje';
    
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'IdViaje',
        'IdUsuario',
        'IdSolicitud',
        'FechaSalida',
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

    public function solicitud()
    {
        return $this->belongsTo(SolicitudViaje::class, 'IdSolicitud', 'IdSolicitud');
    }
}
