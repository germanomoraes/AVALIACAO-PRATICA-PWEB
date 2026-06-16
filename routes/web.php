<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumidorController;
use App\Http\Controllers\ConfiguracaoTaxaController;

Route::get('/', function () {
    return redirect()->route('consumidores.index');
});

Route::resource('consumidores', ConsumidorController::class);

Route::get('/configuracao-taxas', [ConfiguracaoTaxaController::class, 'index'])->name('taxas.index');
Route::post('/configuracao-taxas', [ConfiguracaoTaxaController::class, 'store'])->name('taxas.store');