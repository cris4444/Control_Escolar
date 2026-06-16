<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 'Materias';
    public $timestamps = false;

    protected $fillable = [
        'carrera_id',
        'clave_materia',
        'nombre',
        'creditos',
        'semestre_sugerido',
    ];

    // Una Materia pertenece a una Carrera
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    // Una Materia puede tener muchos Grupos abiertos
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'materia_id');
    }
}
