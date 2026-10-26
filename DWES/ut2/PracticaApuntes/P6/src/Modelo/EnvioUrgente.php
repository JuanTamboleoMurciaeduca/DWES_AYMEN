<?php
declare(strict_types=1);
namespace App\Modelo;
class EnvioUrgente extends Envio
{
    public function modalidad(): string
    {
        return 'urgente';
    }
    protected function cuotaFija(): int
    {
        return 600;
    }
    protected function precioBloque(): int
    {
        return 200;
    }
}