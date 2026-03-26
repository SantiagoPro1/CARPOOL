<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'Calificaciones';
    protected $primaryKey = 'IdCalificacion';

    const CREATED_AT = 'FechaCreacion';
    const UPDATED_AT = null;

    protected $fillable = [
        'IdViaje',
        'IdUsuario',
        'IdEmisor',
        'Estrellas',
        'Comentario',
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

    public function emisor()
    {
        return $this->belongsTo(Usuario::class, 'IdEmisor', 'IdUsuario');
    }
}
