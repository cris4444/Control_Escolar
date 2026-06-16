<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEvaluacion extends Model
{
    protected $table = 'Tipos_Evaluacion';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Un Tipo de Evaluación tiene muchas inscripciones en el Kardex
    public function kardexInscripciones()
    {
        return $this->hasMany(KardexInscripcion::class, 'tipo_evaluacion_id');
    }
}
