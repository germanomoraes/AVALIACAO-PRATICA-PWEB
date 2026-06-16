# AVALIAÇÃO-PRATICA-PWEB
# 💧 Sistema de Controle de Consumo de Água

Sistema web desenvolvido para substituir o processo manual de registro de consumo de água em uma associação comunitária. O leiturista registra as leituras mensais de cada medidor e o sistema calcula automaticamente o consumo e o valor da fatura de cada morador.

---

## 👥 Dupla

| Nome | Curso | Turno | Semestre |
|---|---|---|---|
| Ronald Vieira | ADS | Noturno | 4º Semestre |
| Germano Moraes | ADS | Noturno | 4º Semestre |

**Instituição:** IFCE — Campus Boa Viagem  
**Disciplina:** Programação Web I — 2026.1

---

## 🛠️ Tecnologias Utilizadas

- **PHP 8.x**
- **Laravel 11.x**
- **MySQL 8.x**
- **Blade (Laravel Templating Engine)**
- **Artisan CLI**
- **Composer**
- **HTML5 / CSS3 / Bootstrap**

---

## 📋 Funcionalidades

- **Cadastro de consumidores** — listar, cadastrar e editar (nome, endereço, número do medidor único e telefone)
- **Registro de leitura mensal** — seleção do consumidor, mês/ano e leitura atual em m³; o sistema calcula o consumo automaticamente (`leitura atual − leitura anterior`)
- **Validação de leitura** — impede registro de leitura atual menor que a anterior
- **Unicidade de leitura** — somente uma leitura por consumidor por mês
- **Geração de fatura** — valor calculado automaticamente conforme a regra de cobrança:
  - Até 10.000 L (10 m³): taxa fixa (padrão R$ 25,00)
  - Acima de 10.000 L: taxa fixa + R$ 2,00 por cada 1.000 L excedentes
- **Listagem de faturas do mês** — nome do consumidor, consumo e valor
- **Marcar fatura como paga** — o gestor altera o status de `pendente` para `pago`
- **Configuração de taxa** — o gestor pode alterar o valor da taxa fixa e do excedente a qualquer momento
- **Link WhatsApp (Bônus)** — botão que abre o WhatsApp com mensagem pré-preenchida para o consumidor

---

## ⚙️ Como Instalar e Rodar o Projeto Localmente

### Pré-requisitos

- PHP >= 8.1
- Composer
- MySQL 8.x
- Node.js (opcional, para assets)
- Git

### Passo a passo

```bash
# 1. Clone o repositório
git clone https://github.com/<seu-usuario>/<nome-do-repositorio>.git
cd <nome-do-repositorio>

# 2. Instale as dependências PHP
composer install

# 3. Copie o arquivo de ambiente
cp .env.example .env

# 4. Gere a chave da aplicação
php artisan key:generate

# 5. Configure o banco de dados no .env (veja a seção abaixo)

# 6. Execute as migrations
php artisan migrate

# 7. (Opcional) Popule com dados iniciais
php artisan db:seed

# 8. Inicie o servidor local
php artisan serve
```

Acesse em: [http://localhost:8000](http://localhost:8000)

---

## 🔧 Configuração do `.env`

Abra o arquivo `.env` e ajuste as variáveis de banco de dados:

```env
APP_NAME="Sistema de Controle de Consumo de Água"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=consumo_agua
DB_USERNAME=root
DB_PASSWORD=sua_senha_aqui
```

> **Atenção:** crie o banco de dados `consumo_agua` no MySQL antes de rodar as migrations:
> ```sql
> CREATE DATABASE consumo_agua CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> ```

---

## 🗄️ Migrations

As migrations foram geradas com o Artisan conforme exigido:

```bash
php artisan make:model Consumidor -mcr
php artisan make:model Leitura -mcr
php artisan make:model Fatura -mcr
php artisan make:model ConfiguracaoTaxa -mcr

php artisan migrate
```

### Estrutura das tabelas

**`consumidores`**
| Coluna | Tipo |
|---|---|
| id | bigint (PK) |
| nome | string |
| endereco | string |
| numero_medidor | string (unique) |
| telefone | string |
| timestamps | — |

**`leituras`**
| Coluna | Tipo |
|---|---|
| id | bigint (PK) |
| consumidor_id | FK → consumidores |
| mes_referencia | integer |
| ano_referencia | integer |
| leitura_anterior | decimal |
| leitura_atual | decimal |
| consumo_m3 | decimal |
| timestamps | — |

**`faturas`**
| Coluna | Tipo |
|---|---|
| id | bigint (PK) |
| leitura_id | FK → leituras |
| consumidor_id | FK → consumidores |
| valor_total | decimal |
| status | enum: pendente, pago |
| timestamps | — |

**`configuracoes_taxa`**
| Coluna | Tipo |
|---|---|
| id | bigint (PK) |
| taxa_fixa | decimal |
| valor_excedente | decimal |
| timestamps | — |

---

## 💰 Regra de Cobrança

| Consumo mensal | Cobrança |
|---|---|
| Até 10.000 litros (10 m³) | Taxa fixa (padrão: R$ 25,00 — configurável) |
| Acima de 10.000 litros | Taxa fixa + R$ 2,00 por cada 1.000 L excedentes |

**Exemplo:** consumo de 15.000 L → R$ 25,00 (fixa) + R$ 10,00 (5 × R$ 2,00) = **R$ 35,00**

---

## 📲 Bônus — Link WhatsApp

Ao lado de cada fatura, um botão gera automaticamente um link para o WhatsApp do consumidor com a mensagem pré-preenchida:

```
Olá, [Nome]! Segue o consumo de [Mês/Ano]:
Medidor: [Número]
Leitura anterior: [X] m³ → Leitura atual: [Y] m³
Consumo: [Z] m³ ([Z×1000] litros)
Valor da fatura: R$ [VALOR]
Att, Associação Comunitária
```

O link segue o formato: `https://wa.me/55[telefone]?text=[mensagem codificada]`

---

## 🔑 Usuário e Senha Padrão

> *(Preencha caso o sistema possua autenticação)*

| Campo | Valor |
|---|---|
| E-mail | admin@agua.com |
| Senha | password |

---

## 📁 Estrutura do Projeto

```
├── app/
│   ├── Http/Controllers/
│   │   ├── ConsumidorController.php
│   │   ├── LeituraController.php
│   │   ├── FaturaController.php
│   │   └── ConfiguracaoTaxaController.php
│   └── Models/
│       ├── Consumidor.php
│       ├── Leitura.php
│       ├── Fatura.php
│       └── ConfiguracaoTaxa.php
├── database/
│   └── migrations/
│       ├── create_consumidores_table.php
│       ├── create_leituras_table.php
│       ├── create_faturas_table.php
│       └── create_configuracoes_taxa_table.php
├── resources/views/
│   ├── consumidores/
│   ├── leituras/
│   ├── faturas/
│   └── configuracoes/
├── routes/
│   └── web.php
├── .env.example
└── README.md
```

---

## 📝 Padrão de Commits (Conventional Commits)

```
feat: cadastro de consumidores
feat: registro de leitura e cálculo de consumo
feat: geração de fatura com valor calculado
feat: configuração de taxa pelo gestor
feat: link WhatsApp para envio de fatura
fix: validação de leitura menor que anterior
migration: create_consumidores_table
migration: create_leituras_table
migration: create_faturas_table
migration: create_configuracoes_taxa_table
docs: atualiza README com instruções de uso
```

---

## 📌 Entrega

- Repositório GitHub público
- Link enviado pelo Google Classroom até **21h30**
- Mínimo de **6 commits significativos** com mensagens descritivas
