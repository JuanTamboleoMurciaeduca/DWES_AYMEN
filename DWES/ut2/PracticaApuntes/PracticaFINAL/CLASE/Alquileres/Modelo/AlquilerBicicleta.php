<?php

class AlquilerBicicleta extends Alquiler{
    
    #[Override]
    function modalidad(): string
    {
        $mod = 'bicicleta';
        return $mod;
    }

    #[Override]
    protected function tarifaDiaria(): int
    {
        $cantidad = 500;
        return $cantidad;
    }

}