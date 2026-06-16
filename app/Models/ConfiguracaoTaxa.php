<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracaoTaxa extends Model
{
    protected $table = 'configuracao_taxas';
    protected $fillable = ['taxa_fixa', 'valor_excedente'];
}