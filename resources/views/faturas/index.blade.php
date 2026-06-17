<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Faturas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2>Lista de Faturas</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('leituras.create') }}" class="btn btn-primary mb-3">Nova Leitura</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Consumidor</th>
                <th>Mês/Ano</th>
                <th>Consumo (m³)</th>
                <th>Valor Total</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($faturas as $fatura)
                <tr>
                    <td>{{ $fatura->consumidor->nome }}</td>
                    <td>{{ $fatura->leitura->mes_referencia }}/{{ $fatura->leitura->ano_referencia }}</td>
                    <td>{{ $fatura->leitura->consumo_m3 }} m³</td>
                    <td>R$ {{ number_format($fatura->valor_total, 2, ',', '.') }}</td>
                    <td>
                        @if($fatura->status === 'pago')
                            <span class="badge bg-success">Pago</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendente</span>
                        @endif
                    </td>
                    <td>
                        {{-- Marcar como pago --}}
                        @if($fatura->status === 'pendente')
                            <form action="{{ route('faturas.pagar', $fatura->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm">Marcar como Pago</button>
                            </form>
                        @endif

                        {{-- Botão WhatsApp (Bônus) --}}
                        @php
                            $mensagem = "Olá, {$fatura->consumidor->nome}! Segue o consumo de {$fatura->leitura->mes_referencia}/{$fatura->leitura->ano_referencia}:\n"
                                . "Medidor: {$fatura->consumidor->numero_medidor}\n"
                                . "Leitura anterior: {$fatura->leitura->leitura_anterior} m³ → Leitura atual: {$fatura->leitura->leitura_atual} m³\n"
                                . "Consumo: {$fatura->leitura->consumo_m3} m³ (" . ($fatura->leitura->consumo_m3 * 1000) . " litros)\n"
                                . "Valor da fatura: R$ " . number_format($fatura->valor_total, 2, ',', '.') . "\n"
                                . "Att, Associação Comunitária";
                            $telefone = preg_replace('/\D/', '', $fatura->consumidor->telefone);
                            $link = "https://wa.me/55{$telefone}?text=" . urlencode($mensagem);
                        @endphp
                        <a href="{{ $link }}" target="_blank" class="btn btn-success btn-sm">
                            📲 WhatsApp
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhuma fatura gerada ainda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>