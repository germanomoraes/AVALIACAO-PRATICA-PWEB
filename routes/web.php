<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumidorController;

Route::get('/', function () {
    return redirect()->route('consumidores.index');
});

Route::resource('consumidores', ConsumidorController::class);