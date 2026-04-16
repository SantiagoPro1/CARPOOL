<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitadoViaje extends Model
{
    use HasFactory;

    protected $table = 'invitados_viaje';
    protected $primaryKey = 'IdInvitacion';

    protected $fillable = [
        'IdViaje',
        'Correo'
    ];

    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'IdViaje', 'IdViaje');
    }
}
