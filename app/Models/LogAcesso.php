<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAcesso extends Model
{
    public $timestamps = false;

    protected $table = 'logs_acesso';

    protected $fillable = ['user_id', 'consumidor_id', 'acao'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consumidor()
    {
        return $this->belongsTo(Consumidor::class);
    }
}