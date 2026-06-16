<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KardexInscripcion extends Model
{
    protected $table = 'Kardex_Inscripciones';
    public $timestamps = false;

    // La clave primaria es BIGINT
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'alumno_id',
        'grupo_id',
        'tipo_evaluacion_id',
        'calificacion_final',
        'estatus_materia',
    ];

    protected $casts = [
        'calificacion_final' => 'decimal:2',
    ];

    // Una inscripción pertenece a un Alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    // Una inscripción pertenece a un Grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    // Una inscripción usa un Tipo de Evaluación
    public function tipoEvaluacion()
    {
        return $this->belongsTo(TipoEvaluacion::class, 'tipo_evaluacion_id');
    }
}
