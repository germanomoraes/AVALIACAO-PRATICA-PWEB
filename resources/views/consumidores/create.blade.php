<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Consumidor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white"><h2>Cadastrar Consumidor</h2></div>
        <div class="card-body">
            <form action="{{ route('consumidores.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Endereço:</label>
                    <input type="text" name="endereco" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Telefone:</label>
                    <input type="text" name="telefone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Número do Medidor (Único):</label>
                    <input type="text" name="numero_medidor" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ route('consumidores.index') }}" class="btn btn-secondary">Voltar</a>
            </form>
        </div>
    </div>
</body>
</html>