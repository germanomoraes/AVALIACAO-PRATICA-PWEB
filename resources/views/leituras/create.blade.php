<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Leitura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2>Registrar Nova Leitura</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('leituras.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Consumidor</label>
            <select name="consumidor_id" class="form-select" required>
                <option value="">Selecione...</option>
                @foreach ($consumidores as $consumidor)
                    <option value="{{ $consumidor->id }}">{{ $consumidor->nome }} — Medidor: {{ $consumidor->numero_medidor }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Mês</label>
            <select name="mes_referencia" class="form-select" required>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ano</label>
            <input type="number" name="ano_referencia" class="form-control" value="{{ date('Y') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Leitura Atual (m³)</label>
            <input type="number" step="0.01" name="leitura_atual" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Leitura</button>
        <a href="{{ route('leituras.index') }}" class="btn btn-secondary">Voltar</a>
    </form>

</body>
</html>