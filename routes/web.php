<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomMessagesController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/getContacts', [CustomMessagesController::class, 'getContacts'])->name('contacts.get');
Route::get('/chat/{id?}', [CustomMessagesController::class, 'index'])->name('chat');
