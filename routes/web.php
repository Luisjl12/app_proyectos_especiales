<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', Login::class)->name('login'); 

Route::get('/dashboard', function(){
    return view('dashboard');
})->middleware('auth')->name('dashboard'); 
