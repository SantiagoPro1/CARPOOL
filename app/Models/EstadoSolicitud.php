<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoSolicitud extends Model
{
    use HasFactory;

    protected $table = 'EstadosSolicitud';
    protected $primaryKey = 'IdEstado';

    public $timestamps = false;

    protected $fillable = [
        'ClaveEstado',
    ];

    // Relationships

    public function solicitudes()
    {
        return $this->hasMany(SolicitudViaje::class, 'IdEstado', 'IdEstado');
    }
}
