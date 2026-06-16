<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'Roles';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Un Rol puede pertenecer a muchos Usuarios
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'rol_id');
    }
}
