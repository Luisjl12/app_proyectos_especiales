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
            'cordes' => Corde::orderBy('id')->get(),
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
        $this->fill($plantel->only([
            'cct', 'nombre_escuela', 'nivel_educativo', 'turno',
            'sostenimiento', 'municipio_id', 'localidades_id', 'corde_id',
        ]));
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
            'plantelId', 'cct', 'nombre_escuela', 'nivel_educativo',
            'turno', 'sostenimiento', 'municipio_id', 'localidades_id', 'corde_id',
        ]);
        $this->resetValidation();
    }
}