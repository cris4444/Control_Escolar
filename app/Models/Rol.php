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
        'activo',
    ];

    // Un Rol puede pertenecer a muchos Usuarios
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'rol_id');
    }
    // NUEVO: permisos asignados a este rol
public function permisos()
{
    return $this->belongsToMany(Permiso::class, 'rol_permiso', 'rol_id', 'permiso_id');
}

// NUEVO: helper para checar si el rol tiene un permiso por su clave
public function tienePermiso(string $clave): bool
{
    return $this->permisos()->where('clave', $clave)->exists();
}
}
