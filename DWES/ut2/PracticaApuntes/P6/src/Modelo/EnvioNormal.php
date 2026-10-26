<?php

declare(strict_types=1);

namespace App\Modelo;

class EnvioNormal extends Envio
{
    public function modalidad(): string
    {
        return 'normal';
    }

    protected function cuotaFija(): int
    {
        return 350;
    }

    protected function precioBloque(): int
    {
        return 120;
    }
}