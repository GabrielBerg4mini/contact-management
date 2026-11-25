<?php

use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/contacts');


// Authenticate
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->middleware('throttle:5,1');
Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth')->name('logout');

// Contacts
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');

//Protect
Route::resource('contacts', ContactController::class)->except('index')->middleware('auth');
