<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leitura extends Model
{
    protected $fillable = [
        'consumidor_id',
        'mes_referencia',
        'ano_referencia',
        'leitura_anterior',
        'leitura_atual',
        'consumo_m3',
    ];

    public function consumidor()
    {
        return $this->belongsTo(Consumidor::class);
    }

    public function fatura()
    {
        return $this->hasOne(Fatura::class);
    }
}