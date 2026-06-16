<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'Docentes';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'numero_empleado',
        'nombres',
        'apellidos',
        'especialidad',
    ];

    // Un Docente pertenece a un Usuario del sistema
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Un Docente puede impartir muchos Grupos
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'docente_id');
    }
}
