<?php

namespace App\Http\Controllers;

use App\Models\Leitura;
use App\Models\Consumidor;
use App\Models\Fatura;
// Importamos o LeituraRequest que fará a validação
use App\Http\Requests\LeituraRequest; 
use App\Services\FaturaCalculatorService;

class LeituraController extends Controller
{
    public function __construct(
        private FaturaCalculatorService $calculator
    ) {}

    public function index()
    {
        $leituras = Leitura::with('consumidor')->latest()->get();
        return view('leituras.index', compact('leituras'));
    }

    public function create()
    {
        $consumidores = Consumidor::all();
        return view('leituras.create', compact('consumidores'));
    }

    // 1. Trocamos Request genérico pelo LeituraRequest (Validação extraída)
    public function store(LeituraRequest $request) 
    {
        // Busca última leitura do consumidor
        $ultimaLeitura = Leitura::where('consumidor_id', $request->consumidor_id)
            ->latest()->first();

        $leituraAnterior = $ultimaLeitura ? $ultimaLeitura->leitura_atual : 0;

        // Instanciamos o Model com os dados validados e a leitura anterior
        $leitura = new Leitura([
            'consumidor_id' => $request->consumidor_id,
            'mes_referencia' => $request->mes_referencia,
            'ano_referencia' => $request->ano_referencia,
            'leitura_anterior' => $leituraAnterior,
            'leitura_atual' => $request->leitura_atual,
        ]);

        // 2. Usamos o método do Model para a regra de negócio (Regra extraída)
        if (!$leitura->leituraValida()) {
            return back()->withErrors(['leitura_atual' => 'A leitura atual não pode ser menor que a anterior ('.$leituraAnterior.' m³).'])->withInput();
        }

        // Verifica se já existe leitura nesse mês/ano
        $jaExiste = Leitura::where('consumidor_id', $request->consumidor_id)
            ->where('mes_referencia', $request->mes_referencia)
            ->where('ano_referencia', $request->ano_referencia)
            ->exists();

        if ($jaExiste) {
            return back()->withErrors(['mes_referencia' => 'Já existe uma leitura para esse consumidor nesse mês/ano.'])->withInput();
        }

        // 3. Calcula consumo e salva
        $consumo = $leitura->leitura_atual - $leitura->leitura_anterior;
        $leitura->consumo_m3 = $consumo;
        $leitura->save();

        // 4. Delega cálculo da fatura para o Service (A regra mudou e agora está centralizada no Service)[cite: 1]
        $valorTotal = $this->calculator->calcular($consumo);

        // Gera a fatura
        Fatura::create([
            'leitura_id' => $leitura->id,
            'consumidor_id' => $request->consumidor_id,
            'valor_total' => $valorTotal,
            'status' => 'pendente',
        ]);

        return redirect()->route('faturas.index')->with('success', 'Leitura registrada e fatura gerada com sucesso!');
    }
}

