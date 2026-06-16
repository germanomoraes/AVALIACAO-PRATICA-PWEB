<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracaoTaxa;
use Illuminate\Http\Request;

class ConfiguracaoTaxaController extends Controller
{
    public function index()
    {
        // Vai buscar a taxa à base de dados. Se não existir, simula os valores exigidos pela prova (25.00 e 2.00)
        $taxa = ConfiguracaoTaxa::first() ?? new ConfiguracaoTaxa(['taxa_fixa' => 25.00, 'valor_excedente' => 2.00]);
        return view('taxas.index', compact('taxa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'taxa_fixa' => 'required|numeric',
            'valor_excedente' => 'required|numeric',
        ]);

        $taxa = ConfiguracaoTaxa::first();
        if ($taxa) {
            $taxa->update($request->all());
        } else {
            ConfiguracaoTaxa::create($request->all());
        }

        return redirect()->route('taxas.index');
    }
}
