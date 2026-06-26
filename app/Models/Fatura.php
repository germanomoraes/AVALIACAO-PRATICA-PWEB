<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    protected $fillable = [
        'leitura_id',
        'consumidor_id',
        'valor_total',
        'status',
    ];

    public function consumidor()
    {
        return $this->belongsTo(Consumidor::class);
    }

    public function leitura()
    {
        return $this->belongsTo(Leitura::class);
    }
}