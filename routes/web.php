<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumidorController;
use App\Http\Controllers\ConfiguracaoTaxaController;
use App\Http\Controllers\LeituraController;
use App\Http\Controllers\FaturaController;

Route::get('/', function () {
    return redirect()->route('consumidores.index');
});

Route::resource('consumidores', ConsumidorController::class);

Route::get('/configuracao-taxas', [ConfiguracaoTaxaController::class, 'index'])->name('taxas.index');
Route::post('/configuracao-taxas', [ConfiguracaoTaxaController::class, 'store'])->name('taxas.store');

Route::resource('leituras', LeituraController::class);

Route::get('/faturas', [FaturaController::class, 'index'])->name('faturas.index');
Route::patch('/faturas/{fatura}/pagar', [FaturaController::class, 'marcarPago'])->name('faturas.pagar');