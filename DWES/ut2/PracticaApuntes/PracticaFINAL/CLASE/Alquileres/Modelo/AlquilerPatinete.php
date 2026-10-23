<?php

class AlquilerPatinete extends Alquiler{

    #[Override]
    function modalidad(): string
    {
        $mod = 'patinete';
        return $mod;
    }

    #[Override]
    protected function tarifaDiaria(): int
    {
        $cantidad = 1000;
        return $cantidad;
    }
}