# Análise Arquitetural

| Elemento       | Arquivo encontrado | Responsabilidade |
| :---           | :---               | :---             |
| Model          | app/Models/Consumidor.php | Representar a tabela de consumidores e persistência via Eloquent. |
| Model          | app/Models/Leitura.php | Representar a entidade de leitura, relacionamentos e regras da entidade. |
| Controller     | app/Http/Controllers/LeituraController.php | Receber a requisição, coordenar o fluxo e retornar a resposta HTTP. |
| Form Request   | app/Http/Requests/LeituraRequest.php | Validar os dados enviados pelo usuário. |
| Service        | app/Services/FaturaCalculatorService.php | Centralizar regras de negócio (cálculo de faturas). |

### Justificativa - Parte 3
A verificação se a leitura atual é maior ou igual à anterior pertence ao Model Leitura porque isso é um comportamento intrínseco da entidade. Essa regra define a integridade dos dados da própria leitura (estado válido), não sendo apenas uma validação de formato de entrada (que fica no Request).