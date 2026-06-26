<?php

namespace App\Http\Controllers;

use App\Models\Consumidor;
use App\Models\LogAcesso;
use Illuminate\Http\Request;

class ConsumidorController extends Controller
{
    public function index()
    {
        $consumidores = Consumidor::all();
        return view('consumidores.index', compact('consumidores'));
    }

    public function create()
    {
        return view('consumidores.create');
    }

    public function store(Request $request)
    {
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
        if ($consumidor->id) {
            LogAcesso::create([
                'user_id' => auth()->id(),
                'consumidor_id' => $consumidor->id,
                'acao' => 'visualizou dados do consumidor',
            ]);
        }

        return view('consumidores.show', compact('consumidor'));
    }

    public function edit(Consumidor $consumidor)
    {
        if ($consumidor->id) {
            LogAcesso::create([
                'user_id' => auth()->id(),
                'consumidor_id' => $consumidor->id,
                'acao' => 'acessou edição do consumidor',
            ]);
        }

        return view('consumidores.edit', compact('consumidor'));
    }

    public function update(Request $request, Consumidor $consumidor)
    {
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