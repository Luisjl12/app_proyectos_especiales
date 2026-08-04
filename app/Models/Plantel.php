<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plantel extends Model
{

    use HasFactory;

    protected $table = 'planteles'; 

    protected $fillable = [
        'cct',
        'numero_edificios',
        'nombre_escuela',
        'municipio_id',
        'localidades_id',
        'corde_id',
        'turno',
        'nivel_educativo',
        'sostenimiento',
        'domicilio_calle_numero',
        'domicilio_colonia',
        'domicilio_cp',
        'telefono_plantel',
        'correo_institucional',
        'accesibilidad_rampas',
        'accesibilidad_banos_adaptados',
        'accesibilidad_senaletica_braile',
        'accesibilidad_otros',
        'total_alumnos',
        'total_docentes',
        'total_administrativos',
        'latitud',
        'longitud',
        'estatus_plantel',
    ];

    protected function casts(): array
    {
        return [
            'accesibilidad_rampas' => 'boolean',
            'accesibilidad_banos_adaptados' => 'boolean',
            'accesibilidad_senaletica_braile' => 'boolean',
            'latitud' => 'decimal:8',
            'longitud' => 'decimal:8',
        ];
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }

    public function localidad(): BelongsTo
    {
        return $this->belongsTo(Localidad::class, 'localidades_id');
    }

    public function corde(): BelongsTo
    {
        return $this->belongsTo(Corde::class);
    }
}