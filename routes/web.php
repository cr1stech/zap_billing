<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientAccountController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login/do', [AuthController::class, 'attempt'])->name('login.do');

// Rotas autenticadas
Route::middleware('auth:web')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Rotas Gestão de clientes
    Route::controller(ClientController::class)
        ->prefix('clientes')
        ->name('clients.')
        ->group(function () {
            Route::get('datatables', 'datatables')->name('datatables');
            Route::post('/enviar-mensagem', 'sendSMS')->name('sendSMS');
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('{id}', 'show')->name('show');
            Route::get('{id}/edit', 'edit')->name('edit');
            Route::put('{id}', 'update')->name('update');
            Route::get('{id}/pay', 'pay')->name('pay');
            Route::post('{id}/pay', 'processPayment')->name('processPayment');
            Route::delete('{id}', 'destroy')->name('destroy');
        });

    // Rotas gestão de contas
    Route::controller(ClientAccountController::class)
        ->prefix('conta-clientes')
        ->name('client-accounts.')
        ->group(function () {
            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('{id}', 'show')->name('show');
            Route::get('{id}/edit', 'edit')->name('edit');
            Route::put('{id}', 'update')->name('update');
            Route::delete('{id}', 'destroy')->name('destroy');
        });

    // Rota de logout verificada por middleware WEB
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::fallback(function () {
    return view('errors.404');
});
