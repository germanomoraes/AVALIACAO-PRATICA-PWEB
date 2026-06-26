<?php

namespace App\Http\Controllers;

use App\Models\Fatura;
use Illuminate\Http\Request;

class FaturaController extends Controller
{
    public function index()
    {
        $faturas = Fatura::with(['consumidor', 'leitura'])->latest()->get();
        return view('faturas.index', compact('faturas'));
    }

    public function marcarPago(Fatura $fatura)
    {
        $fatura->update(['status' => 'pago']);
        return redirect()->route('faturas.index')->with('success', 'Fatura marcada como paga!');
    }
}