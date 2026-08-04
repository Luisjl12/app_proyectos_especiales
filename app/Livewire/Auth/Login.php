<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth; 

#[Layout('components.layouts.guest')]
class Login extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            session(['id' => Auth::id()]); // 👈 agregado

            return redirect()->intended('/dashboard');
        }

        $this->addError('email', 'Credenciales incorrectas.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}