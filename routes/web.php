<?php

use App\Http\Controllers\EventosController;
use Illuminate\Support\Facades\Route;

// Para visualizar as páginas
Route::get('/', [EventosController::class, 'MostraHome'])->name('home-adm');

Route::get('/cadastro-evento', [EventosController::class, 'MostrarCadastroEvento'])->name('show-cadastro-evento');

Route::get('/lista-evento', [EventosController::class, 'MostrarEventoNome'])->name('lista-evento');

Route::get('/altera-evento', [EventosController::class, 'MostrarEventoCodigo'])->name('show-altera-evento');


// Para cadastrar
Route::post('/cadastro-evento', [EventosController::class, 'CadastrarEventos'])->name('cadastra-evento');

// Para deletar
Route::delete('/apaga-evento', [EventosController::class, 'destroy'])->name('apaga-evento');

// Para alterar
Route::put('/altera-evento', [EventosController::class, 'Update'])->name('altera-evento');
