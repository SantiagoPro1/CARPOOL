<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends Model
{
    use HasFactory;

    protected $table = 'PerfilesUsuario';
    protected $primaryKey = 'IdUsuario';
    
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'IdUsuario',
        'Bio',
        'AvatarUrl',
        'FechaNacimiento',
        'Texto',
    ];

    // Relationships

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'IdUsuario', 'IdUsuario');
    }
}
