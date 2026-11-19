<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::livewire('/', 'pages::home')
    ->name('home');

// Вход
Route::livewire('/login', 'pages::auth.login')
    ->name('login');
// Регистрация
Route::livewire('/register', 'pages::auth.register')
    ->name('register');

Route::livewire('/forgot-password', 'pages::auth.forgot-password')
    ->middleware('guest')
    ->name('password.request');

// Личный кабинет — только для авторизованных
Route::livewire('/dashboard', 'pages::dashboard')
    ->middleware('auth')
    ->name('dashboard');


// Выход
Route::post('/logout', [LogoutController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
