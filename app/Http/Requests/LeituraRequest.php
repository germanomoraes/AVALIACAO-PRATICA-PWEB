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
            'consumidor_id' => 'required|integer|exists:consumidores,id',
            'leitura_anterior' => 'required|numeric|min:0',
            'leitura_atual' => 'required|numeric|min:0',
        ];
    }
} 
