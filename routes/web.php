<?php

use App\Http\Controllers\Auth\CadastroController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\PainelController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro');
    Route::post('/cadastro', [CadastroController::class, 'store'])->name('cadastro.store');

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/painel', [PainelController::class, 'index'])->name('painel');
    Route::get('/painel-psicologo', [\App\Http\Controllers\PainelPsicologoController::class, 'index'])->name('painel.psicologo');

    Route::get('/consultas', [ConsultaController::class, 'index'])->name('consultas.index');
    Route::post('/consultas', [ConsultaController::class, 'store'])->name('consultas.store');

    Route::get('/chat/mensagens', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/mensagens', [ChatController::class, 'store'])->name('chat.store');
});
