<?php

namespace App\Services;

class FaturaCalculatorService
{
    
public function calcular(float $consumo): float
    {
        // Até 10 m³: R$ 25,00
        if ($consumo <= 10) {
            return 25.00;
        } 
        // Acima de 10 m³ até 20 m³: R$ 25,00 + R$ 2,00 por m³ excedente a 10 m³
        elseif ($consumo <= 20) {
            $excedente = $consumo - 10;
            return 25.00 + ($excedente * 2.00);
        } 
        // Acima de 20 m³: R$ 25,00 + R$ 20,00 (da faixa anterior) + R$ 3,00 por m³ acima de 20 m³[cite: 1]
        else {
            $excedente = $consumo - 20;
            return 25.00 + (10 * 2.00) + ($excedente * 3.00);
        }
    }
}
