<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'Ubicaciones';
    protected $primaryKey = 'IdUbicacion';

    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Direccion',
        'Ciudad',
    ];

    // Relationships

    public function rutasComoOrigen()
    {
        return $this->hasMany(Ruta::class, 'IdOrigen', 'IdUbicacion');
    }

    public function rutasComoDestino()
    {
        return $this->hasMany(Ruta::class, 'IdDestino', 'IdUbicacion');
    }
}
