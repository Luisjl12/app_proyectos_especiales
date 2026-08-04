<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login; 
use App\Livewire\Users\UserManager;
use App\Livewire\Planteles\PlantelManager; 
use App\Livewire\Municipios\MunicipioManager;
use App\Livewire\Municipios\MunicipioImportador; 

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

//Municipios
Route::middleware('auth.custom')->group(function () {
    Route::get('/municipios', MunicipioManager::class)->name('municipios.index');
});

Route::middleware('auth.custom')->group(function () {
    Route::get('/municipios/importar', MunicipioImportador::class)->name('municipios.importar');
});
