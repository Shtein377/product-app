<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::livewire('/', 'pages::home')
    ->name('home');

Route::livewire('/register', 'pages::auth.register')
    ->name('register');


    Route::livewire('/dashboard', 'pages::dashboard')
    ->name('dashboard');


Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');