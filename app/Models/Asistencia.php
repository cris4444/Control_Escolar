<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'Asistencias';
    public $timestamps = false;

    // La clave primaria es BIGINT
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'alumno_id',
        'grupo_id',
        'fecha',
        'estatus_asistencia',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    // Una Asistencia pertenece a un Alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    // Una Asistencia pertenece a un Grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}
