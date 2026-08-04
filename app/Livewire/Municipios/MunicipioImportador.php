<?php

namespace App\Livewire\Municipios;

use App\Imports\MunicipiosImport;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.app')]
class MunicipioImportador extends Component
{

    use WithFileUploads; 

    public $archivo; 
    public bool $procesando=false;  
    public ?array $resultado=null;  

    protected function rules():array
    {
        return [
            'archivo'=> 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]; 
    }

    public function importar(): void
    {
        $this->validate();
        $this->procesando = true;
        $this->resultado = null;

        $import = new MunicipiosImport();
        Excel::import($import, $this->archivo);

        $this->resultado = [
            'creados' => $import->creados,
            'duplicados' => $import->duplicados,
            'errores' => $import->errores,
            'mensajesError' => $import->mensajesError,
        ];

        $this->procesando = false;
        $this->reset('archivo');
    }

    public function render()
    {
        return view('livewire.municipios.municipio-importador');
    }
}
