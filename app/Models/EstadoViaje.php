<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoViaje extends Model
{
    use HasFactory;

    protected $table = 'EstadosViaje';
    protected $primaryKey = 'IdEstado';

    public $timestamps = false;

    protected $fillable = [
        'NombreEstado',
    ];

    // Relationships

    public function viajes()
    {
        return $this->hasMany(Viaje::class, 'IdEstado', 'IdEstado');
    }
}
