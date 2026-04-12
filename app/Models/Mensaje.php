<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'Mensajes';
    protected $primaryKey = 'IdMensaje';

    const CREATED_AT = 'FechaEnvio';
    const UPDATED_AT = null;

    protected $fillable = [
        'IdViaje',
        'IdRemitente',
        'Contenido',
    ];

    // Relationships

    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'IdViaje', 'IdViaje');
    }

    public function remitente()
    {
        return $this->belongsTo(Usuario::class, 'IdRemitente', 'IdUsuario');
    }
}
