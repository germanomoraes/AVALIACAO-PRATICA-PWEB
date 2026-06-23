<?php

namespace App\Http\Controllers;

use App\Models\Leitura;
use App\Models\Consumidor;
use App\Models\Fatura;
use App\Models\ConfiguracaoTaxa;
use App\Services\FaturaCalculatorService;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $request->validate([
            'consumidor_id' => 'required|exists:consumidores,id',
            'mes_referencia' => 'required|integer|min:1|max:12',
            'ano_referencia' => 'required|integer|min:2000',
            'leitura_atual' => 'required|numeric|min:0',
        ]);

        // Busca última leitura do consumidor
        $ultimaLeitura = Leitura::where('consumidor_id', $request->consumidor_id)
            ->latest()->first();

        $leituraAnterior = $ultimaLeitura ? $ultimaLeitura->leitura_atual : 0;

        // Validação: leitura atual não pode ser menor que a anterior
        if ($request->leitura_atual < $leituraAnterior) {
            return back()->withErrors(['leitura_atual' => 'A leitura atual não pode ser menor que a anterior ('.$leituraAnterior.' m³).'])->withInput();
        }

        // Verifica se já existe leitura nesse mês/ano para esse consumidor
        $jaExiste = Leitura::where('consumidor_id', $request->consumidor_id)
            ->where('mes_referencia', $request->mes_referencia)
            ->where('ano_referencia', $request->ano_referencia)
            ->exists();

        if ($jaExiste) {
            return back()->withErrors(['mes_referencia' => 'Já existe uma leitura para esse consumidor nesse mês/ano.'])->withInput();
        }

        // Calcula consumo em m³
        $consumo = $request->leitura_atual - $leituraAnterior;

        // Salva a leitura
        $leitura = Leitura::create([
            'consumidor_id' => $request->consumidor_id,
            'mes_referencia' => $request->mes_referencia,
            'ano_referencia' => $request->ano_referencia,
            'leitura_anterior' => $leituraAnterior,
            'leitura_atual' => $request->leitura_atual,
            'consumo_m3' => $consumo,
        ]);

        // Calcula valor da fatura usando o Service
        $config = ConfiguracaoTaxa::first();
        $taxaFixa = $config ? $config->taxa_fixa : 25;
        $valorExcedente = $config ? $config->valor_excedente : 2;

        $valorTotal = $this->calculator->calcular($consumo, $taxaFixa, 10, $valorExcedente);

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