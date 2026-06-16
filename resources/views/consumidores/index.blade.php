<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consumidores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Lista de Consumidores</h2>
    <a href="{{ route('consumidores.create') }}" class="btn btn-primary mb-3">Novo Consumidor</a>
    
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>Medidor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consumidores as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->nome }}</td>
                <td>{{ $c->endereco }}</td>
                <td>{{ $c->telefone }}</td>
                <td>{{ $c->numero_medidor }}</td>
                <td>
                    <a href="{{ route('consumidores.edit', $c->id) }}" class="btn btn-sm btn-warning">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>