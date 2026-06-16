!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Consumidor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning"><h2>Editar Consumidor</h2></div>
        <div class="card-body">
            <form action="{{ route('consumidores.update', $consumidor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Nome:</label>
                    <input type="text" name="nome" value="{{ $consumidor->nome }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Endereço:</label>
                    <input type="text" name="endereco" value="{{ $consumidor->endereco }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Telefone:</label>
                    <input type="text" name="telefone" value="{{ $consumidor->telefone }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Número do Medidor:</label>
                    <input type="text" name="numero_medidor" value="{{ $consumidor->numero_medidor }}" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Atualizar</button>
                <a href="{{ route('consumidores.index') }}" class="btn btn-secondary">Voltar</a>
            </form>
        </div>
    </div>
</body>
</html>