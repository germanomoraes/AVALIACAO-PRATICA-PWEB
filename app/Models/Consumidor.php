<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumidor extends Model
{
    use SoftDeletes;

    protected $table = 'consumidores';

    protected $fillable = ['nome', 'endereco', 'telefone', 'numero_medidor'];

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}