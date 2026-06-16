<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumidor extends Model
{
    // Avisa o Laravel qual o nome correto da tabela
    protected $table = 'consumidores';
    
    // Permite salvar esses dados
    protected $fillable = ['nome', 'endereco', 'telefone', 'numero_medidor'];
}