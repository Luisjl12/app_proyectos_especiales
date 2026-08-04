<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login; 
use App\Livewire\Users\UserManager;
use App\Livewire\Planteles\PlantelManager; 

Route::get('/', function () {
    return view('welcome');
});

//Login
Route::get('/login', Login::class)->name('login'); 

//Dashboard 
Route::get('/dashboard', function(){
    return view('dashboard');
})->middleware('auth')->name('dashboard'); 

//Usuarios
Route::middleware('auth.custom')->group(function () {
    Route::get('/usuarios', UserManager::class)->name('usuarios.index');
});

//Planteles
Route::middleware('auth.custom')->group(function () {
    Route::get('/planteles', PlantelManager::class)->name('planteles.index');
});
