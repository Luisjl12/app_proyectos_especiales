<?php

namespace App\Imports;

use App\Models\Municipio; 
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MunicipiosImport implements ToCollection, WithHeadingRow
{
    public int $creados = 0;
    public int $duplicados = 0;
    public int $errores = 0;
    public array $mensajesError = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $nombre = trim($row['nombre_municipio'] ?? '');

            if (empty($nombre)) {
                $this->errores++;
                $this->mensajesError[] = 'Fila ' . ($index + 2) . ': la columna nombre_municipio está vacía.';
                continue;
            }

            $existe = Municipio::whereRaw('LOWER(nombre_municipio) = ?', [strtolower($nombre)])->exists();

            if ($existe) {
                $this->duplicados++;
                continue;
            }

            Municipio::create(['nombre_municipio' => $nombre]);
            $this->creados++;
        }
    }
}
