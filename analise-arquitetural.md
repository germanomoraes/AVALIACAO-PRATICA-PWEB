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

### Uso de IA (Parte 12)
**Ferramenta utilizada:** Claude
**Objetivo:** Compreender a separação de responsabilidades e implementar a lógica matemática das faixas de consumo no Service.
**Prompt utilizado:** "me ajude a fazer o passo a passo dessa nova atividade (...) O sistema possui uma regra relacionada ao cálculo da fatura (...) Nova regra: Até 10m3 R$ 25,00..."
**Como a resposta foi utilizada:** A resposta auxiliou na construção da estrutura condicional (if/else) dentro do `FaturaCalculatorService`, garantindo que o cálculo do excedente ficasse correto e isolado no Service.
**O código foi testado?** (X) Sim ( ) Não

