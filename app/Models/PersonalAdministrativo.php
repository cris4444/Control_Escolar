<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalAdministrativo extends Model
{
    protected $table = 'Personal_Administrativo';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'numero_empleado',
        'nombres',
        'apellidos',
        'puesto',
        'departamento',
    ];

    // El Personal Administrativo pertenece a un Usuario del sistema
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
