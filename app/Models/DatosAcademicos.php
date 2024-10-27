<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosAcademicos extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'DatosAcademicos';

    // Definir los campos que se pueden asignar de forma masiva (mass assignment)
    protected $fillable = [
        'fac',
        'nombre_facultad',
        'carre',
        'nombre_carrera',
        'period',
        'localidad',
        'modalidad',
        'ins',
        't_nue',
        't_ant',
        'mat_ins',
        'sin_not',
        'snot_perc',
        'aprobados',
        'apro_perc',
        'reprobados',
        'repr_perc',
        'r_con_0',
        'rep0_perc',
        'moras',
        'mora_perc',
        'retir',
        'ppa',
        'pps',
        'ppa1',
        'ppac',
        'egre',
        'tit',
        'periodo'
    ];

    // Deshabilitar timestamps si no tienes columnas created_at y updated_at
    public $timestamps = false;

    // Convertir estos campos a tipos de datos específicos
    protected $casts = [
        'period' => 'date',
        'snot_perc' => 'decimal:2',
        'apro_perc' => 'decimal:2',
        'repr_perc' => 'decimal:2',
        'rep0_perc' => 'decimal:2',
        'mora_perc' => 'decimal:2',
        'ppa' => 'decimal:2',
        'pps' => 'decimal:2',
        'ppa1' => 'decimal:2',
        'ppac' => 'decimal:2',
    ];
}
