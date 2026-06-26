<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumidorController;
use App\Http\Controllers\ConfiguracaoTaxaController;
use App\Http\Controllers\LeituraController;
use App\Http\Controllers\FaturaController;

// Rota raiz — redireciona para login se não autenticado
Route::get('/', function () {
    return redirect()->route('consumidores.index');
});

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {

    // Leiturista e admin podem acessar
    Route::resource('leituras', LeituraController::class);
    Route::get('/faturas', [FaturaController::class, 'index'])->name('faturas.index');
    Route::patch('/faturas/{fatura}/pagar', [FaturaController::class, 'marcarPago'])->name('faturas.pagar');

    // Somente admin pode acessar
    Route::middleware('admin')->group(function () {
        Route::resource('consumidores', ConsumidorController::class)->parameters([
            'consumidores' => 'consumidor'
        ]);
        Route::get('/configuracao-taxas', [ConfiguracaoTaxaController::class, 'index'])->name('taxas.index');
        Route::post('/configuracao-taxas', [ConfiguracaoTaxaController::class, 'store'])->name('taxas.store');
    });

});

require __DIR__.'/auth.php';