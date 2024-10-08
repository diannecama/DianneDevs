<?php

use App\livewire\Auth\AuthLogin;
use App\livewire\Auth\AuthRegister;
use App\livewire\Auth\AuthDashboard;
use App\Livewire\Auth\AuthHomepage;
use App\Livewire\Auth\AuthEvents;
use App\Livewire\Auth\AuthCalendar;
use App\Livewire\Auth\AuthVenues;
use App\Livewire\Auth\AuthForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', AuthLogin::class)->name('login');
Route::get('/register', AuthRegister::class)->name('register');
Route::get('/dashboard', AuthDashboard::class)->name('dashboard');
Route::get('/homepage', AuthHomepage::class)->name('homepage');
Route::get('/events', AuthEvents::class)->name('events');
Route::get('/calendar', AuthCalendar::class)->name('calendar');
Route::get('/venues', AuthVenues::class)->name('venues');
Route::get('/form', AuthForm::class)->name('form');