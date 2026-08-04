<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public bool $showModal = false;
    public ?int $userId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|min:8')]
    public string $password = '';

    public string $search = '';

    protected function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'password' => $this->userId ? 'nullable|string|min:8' : 'required|string|min:8',
        ];
    }

    public function render()
    {
        return view('livewire.users.user-manager', [
            'users' => User::where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->latest()
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
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->showModal = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        User::updateOrCreate(['id' => $this->userId], $data);

        $this->showModal = false;
        $this->resetForm();
        session()->flash('message', $this->userId ? 'Usuario actualizado.' : 'Usuario creado.');
    }

    public function delete(int $id): void
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Usuario eliminado.');
    }

    public function resetForm(): void
    {
        $this->reset(['userId', 'name', 'email', 'password']);
        $this->resetValidation();
    }
}
