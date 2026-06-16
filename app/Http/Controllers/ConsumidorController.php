<?php

namespace App\Http\Controllers;

use App\Models\Consumidor;
use Illuminate\Http\Request;

class ConsumidorController extends Controller
{
    public function index()
    {
        // Busca todos os consumidores no banco e manda para a view index
        $consumidores = Consumidor::all();
        return view('consumidores.index', compact('consumidores'));
    }

    public function create()
    {
        // Mostra a tela de cadastro
        return view('consumidores.create');
    }

    public function store(Request $request)
    {
        // Valida e salva no banco de dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'numero_medidor' => 'required|string|unique:consumidores',
        ]);

        Consumidor::create($request->all());

        return redirect()->route('consumidores.index');
    }

    public function show(Consumidor $consumidor)
    {
        // Não precisamos do show nesta prova
    }

    public function edit(Consumidor $consumidor)
    {
        // Mostra a tela de edição
        return view('consumidores.edit', compact('consumidor'));
    }

    public function update(Request $request, Consumidor $consumidor)
    {
        // Valida e atualiza no banco de dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'numero_medidor' => 'required|string|unique:consumidores,numero_medidor,' . $consumidor->id,
        ]);

        $consumidor->update($request->all());

        return redirect()->route('consumidores.index');
    }

    public function destroy(Consumidor $consumidor)
    {
        $consumidor->delete();
        return redirect()->route('consumidores.index');
    }
}