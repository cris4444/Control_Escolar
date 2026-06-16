<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $table = 'Aulas';
    public $timestamps = false;

    protected $fillable = [
        'edificio',
        'numero_identificador',
        'capacidad_maxima',
        'tipo_aula',
        'estatus',
    ];

    // Un Aula puede tener muchos Grupos asignados
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'aula_id');
    }
}
