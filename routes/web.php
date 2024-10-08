<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::get('/docs', function () {
    return redirect('/apidoc/index.html');
});

Route::resource('customers', CustomerController::class, [
    'only' => ['index', 'edit', 'create']
]);
