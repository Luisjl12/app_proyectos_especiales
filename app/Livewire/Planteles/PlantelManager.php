<?php

namespace App\Livewire\Planteles;

use App\Models\Corde;
use App\Models\Localidad;
use App\Models\Municipio;
use App\Models\Plantel;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class PlantelManager extends Component
{
    use WithPagination;

    public bool $showModal = false;
    public ?int $plantelId = null;
    public string $search = '';

    // Datos de identificación
    public string $cct = '';
    public string $nombre_escuela = '';
    public string $nivel_educativo = '';
    public string $turno = '';
    public string $sostenimiento = '';
    public ?int $municipio_id = null;
    public ?int $localidades_id = null;
    public ?int $corde_id = null;

    // Domicilio y contacto
    public ?int $numero_edificios = null;
    public string $domicilio_calle_numero = '';
    public string $domicilio_colonia = '';
    public string $domicilio_cp = '';
    public string $telefono_plantel = '';
    public string $correo_institucional = '';

    // Cifras
    public ?int $total_alumnos = null;
    public ?int $total_docentes = null;
    public ?int $total_administrativos = null;

    // Accesibilidad
    public bool $accesibilidad_rampas = false;
    public bool $accesibilidad_banos_adaptados = false;
    public bool $accesibilidad_senaletica_braile = false;
    public string $accesibilidad_otros = '';

    // Ubicación geográfica y estatus
    public ?float $latitud = null;
    public ?float $longitud = null;
    public string $estatus_plantel = 'En revision';

    protected function rules(): array
    {
        return [
            'cct' => 'required|string|max:255|unique:planteles,cct,' . $this->plantelId,
            'nombre_escuela' => 'required|string|max:255',
            'nivel_educativo' => 'nullable|string|max:255',
            'turno' => 'nullable|string|max:255',
            'sostenimiento' => 'nullable|string|max:255',
            'municipio_id' => 'required|exists:municipios,id',
            'localidades_id' => 'required|exists:localidades,id',
            'corde_id' => 'nullable|exists:cordes,id',

            'numero_edificios' => 'nullable|integer|min:0',
            'domicilio_calle_numero' => 'nullable|string|max:255',
            'domicilio_colonia' => 'nullable|string|max:255',
            'domicilio_cp' => 'nullable|string|max:255',
            'telefono_plantel' => 'nullable|string|max:255',
            'correo_institucional' => 'nullable|email|max:255',

            'total_alumnos' => 'nullable|integer|min:0',
            'total_docentes' => 'nullable|integer|min:0',
            'total_administrativos' => 'nullable|integer|min:0',

            'accesibilidad_rampas' => 'boolean',
            'accesibilidad_banos_adaptados' => 'boolean',
            'accesibilidad_senaletica_braile' => 'boolean',
            'accesibilidad_otros' => 'nullable|string',

            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'estatus_plantel' => 'required|in:Activo,Inactivo,En revision',
        ];
    }

    public function render()
    {
        return view('livewire.planteles.plantel-manager', [
            'planteles' => Plantel::with(['municipio', 'localidad'])
                ->where('nombre_escuela', 'like', "%{$this->search}%")
                ->orWhere('cct', 'like', "%{$this->search}%")
                ->latest()
                ->paginate(10),
            'municipios' => Municipio::orderBy('nombre_municipio')->get(),
            'localidades' => $this->municipio_id
                ? Localidad::where('municipio_id', $this->municipio_id)->orderBy('nombre_localidad')->get()
                : collect(),
            'cordes' => Corde::orderBy('nombre_corde')->get(),
        ]);
    }

    public function updatedMunicipioId(): void
    {
        $this->localidades_id = null;
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $plantel = Plantel::findOrFail($id);
        $this->plantelId = $plantel->id;

        $data = $plantel->only([
            'cct', 'nombre_escuela', 'nivel_educativo', 'turno', 'sostenimiento',
            'municipio_id', 'localidades_id', 'corde_id',
            'numero_edificios', 'domicilio_calle_numero', 'domicilio_colonia',
            'domicilio_cp', 'telefono_plantel', 'correo_institucional',
            'total_alumnos', 'total_docentes', 'total_administrativos',
            'accesibilidad_rampas', 'accesibilidad_banos_adaptados',
            'accesibilidad_senaletica_braile', 'accesibilidad_otros',
            'latitud', 'longitud', 'estatus_plantel',
        ]);

        // Los campos de tipo string no admiten null en las propiedades del componente
        foreach (['nivel_educativo', 'turno', 'sostenimiento', 'domicilio_calle_numero',
                'domicilio_colonia', 'domicilio_cp', 'telefono_plantel',
                'correo_institucional', 'accesibilidad_otros'] as $campo) {
            $data[$campo] = $data[$campo] ?? '';
        }

        $this->fill($data);
        $this->showModal = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        Plantel::updateOrCreate(['id' => $this->plantelId], $data);

        $this->showModal = false;
        $this->resetForm();
        session()->flash('message', $this->plantelId ? 'Plantel actualizado.' : 'Plantel creado.');
    }

    public function delete(int $id): void
    {
        Plantel::findOrFail($id)->delete();
        session()->flash('message', 'Plantel eliminado.');
    }

    public function resetForm(): void
    {
        $this->reset([
            'plantelId', 'cct', 'nombre_escuela', 'nivel_educativo', 'turno', 'sostenimiento',
            'municipio_id', 'localidades_id', 'corde_id',
            'numero_edificios', 'domicilio_calle_numero', 'domicilio_colonia',
            'domicilio_cp', 'telefono_plantel', 'correo_institucional',
            'total_alumnos', 'total_docentes', 'total_administrativos',
            'accesibilidad_rampas', 'accesibilidad_banos_adaptados',
            'accesibilidad_senaletica_braile', 'accesibilidad_otros',
            'latitud', 'longitud',
        ]);
        $this->estatus_plantel = 'En revision';
        $this->resetValidation();
    }
}