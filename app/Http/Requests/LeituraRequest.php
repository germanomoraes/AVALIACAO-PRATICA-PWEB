<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LeituraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'consumidor_id' => 'required|exists:consumidores,id',
        'mes_referencia' => 'required|integer|min:1|max:12',
        'ano_referencia' => 'required|integer|min:2000',
        'leitura_atual' => 'required|numeric|min:0',
    ];
}
}
