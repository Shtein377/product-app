<?php

use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return view('welcome');
// });

Route::livewire('/', 'pages::home-page')->name('home');

// Позже вся эта группа получит middleware ['auth', 'verified'] (задача 1.1)
Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');
Route::livewire('/groups', 'pages::groups.index')->name('groups.index');
Route::livewire('/activity', 'pages::activity')->name('activity');
Route::livewire('/profile', 'pages::profile')->name('profile');

