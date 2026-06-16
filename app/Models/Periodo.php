<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'Periodos';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'fecha_inicio',
        'fecha_fin',
    ];

    // Un Periodo contiene muchos Grupos
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'periodo_id');
    }
}
