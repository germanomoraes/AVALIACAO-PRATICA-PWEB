<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Leituras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2>Lista de Leituras</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('leituras.create') }}" class="btn btn-primary mb-3">Nova Leitura</a>
    <a href="{{ route('faturas.index') }}" class="btn btn-secondary mb-3">Ver Faturas</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Consumidor</th>
                <th>Mês/Ano</th>
                <th>Leitura Anterior (m³)</th>
                <th>Leitura Atual (m³)</th>
                <th>Consumo (m³)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($leituras as $leitura)
                <tr>
                    <td>{{ $leitura->consumidor->nome }}</td>
                    <td>{{ $leitura->mes_referencia }}/{{ $leitura->ano_referencia }}</td>
                    <td>{{ $leitura->leitura_anterior }}</td>
                    <td>{{ $leitura->leitura_atual }}</td>
                    <td>{{ $leitura->consumo_m3 }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhuma leitura registrada ainda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>