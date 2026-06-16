<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'Grupos';
    public $timestamps = false;

    protected $fillable = [
        'periodo_id',
        'materia_id',
        'docente_id',
        'aula_id',
        'cupo_maximo',
    ];

    // Un Grupo pertenece a un Periodo escolar
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    // Un Grupo corresponde a una Materia
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    // Un Grupo es impartido por un Docente
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    // Un Grupo se imparte en un Aula
    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_id');
    }

    // Un Grupo tiene muchos Horarios definidos
    public function horariosGrupo()
    {
        return $this->hasMany(HorarioGrupo::class, 'grupo_id');
    }

    // Un Grupo tiene muchos alumnos inscritos (Kardex)
    public function kardexInscripciones()
    {
        return $this->hasMany(KardexInscripcion::class, 'grupo_id');
    }

    // Un Grupo tiene muchos registros de Asistencia
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'grupo_id');
    }
}
