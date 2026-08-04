<?php

namespace App\Livewire\Municipios;

use App\Models\Municipio;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class MunicipioManager extends Component
{
    use WithPagination;

    public bool $showModal = false;
    public ?int $municipioId = null;
    public string $search = '';

    public string $nombre_municipio = '';

    protected function rules(): array
    {
        return [
            'nombre_municipio' => 'required|string|max:255|unique:municipios,nombre_municipio,' . $this->municipioId,
        ];
    }

    public function render()
    {
        return view('livewire.municipios.municipio-manager', [
            'municipios' => Municipio::withCount('localidades')
                ->where('nombre_municipio', 'like', "%{$this->search}%")
                ->orderBy('nombre_municipio')
                ->paginate(10),
        ]);
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $municipio = Municipio::findOrFail($id);
        $this->municipioId = $municipio->id;
        $this->nombre_municipio = $municipio->nombre_municipio;
        $this->showModal = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        Municipio::updateOrCreate(['id' => $this->municipioId], $data);

        $this->showModal = false;
        $this->resetForm();
        session()->flash('message', $this->municipioId ? 'Municipio actualizado.' : 'Municipio creado.');
    }

    public function delete(int $id): void
    {
        $municipio = Municipio::withCount('localidades')->findOrFail($id);

        if ($municipio->localidades_count > 0) {
            session()->flash('error', 'No se puede eliminar: este municipio tiene localidades asociadas.');
            return;
        }

        $municipio->delete();
        session()->flash('message', 'Municipio eliminado.');
    }

    public function resetForm(): void
    {
        $this->reset(['municipioId', 'nombre_municipio']);
        $this->resetValidation();
    }
}