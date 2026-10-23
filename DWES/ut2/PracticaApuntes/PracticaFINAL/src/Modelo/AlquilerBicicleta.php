<?php

class AlquilerBicicleta extends Alquiler
{
    function modalidad(): string
    {
        return 'bicicleta';
    }

    protected function tarifaDiaria(): int
    {
        return 500;
    }
}
