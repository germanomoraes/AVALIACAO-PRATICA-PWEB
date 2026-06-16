<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Configuração de Taxas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white"><h2>Configuração de Taxas de Água</h2></div>
        <div class="card-body">
            <form action="{{ route('taxas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Taxa Fixa (até 10.000 L) - R$:</label>
                    <input type="number" step="0.01" name="taxa_fixa" value="{{ $taxa->taxa_fixa }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Valor Excedente (por cada 1.000 L) - R$:</label>
                    <input type="number" step="0.01" name="valor_excedente" value="{{ $taxa->valor_excedente }}" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Guardar Configuração</button>
                <a href="{{ route('consumidores.index') }}" class="btn btn-secondary">Voltar aos Consumidores</a>
            </form>
        </div>
    </div>
</body>
</html>