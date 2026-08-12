# Análise Arquitetural

| Elemento       | Arquivo encontrado | Responsabilidade |
| :---           | :---               | :---             |
| Model          | app/Models/Consumidor.php | Representar a tabela de consumidores e persistência via Eloquent. |
| Model          | app/Models/Leitura.php | Representar a entidade de leitura, relacionamentos e regras da entidade. |
| Controller     | app/Http/Controllers/LeituraController.php | Receber a requisição, coordenar o fluxo e retornar a resposta HTTP. |
| Form Request   | app/Http/Requests/LeituraRequest.php | Validar os dados enviados pelo usuário. |
| Service        | app/Services/FaturaCalculatorService.php | Centralizar regras de negócio (cálculo de faturas). |