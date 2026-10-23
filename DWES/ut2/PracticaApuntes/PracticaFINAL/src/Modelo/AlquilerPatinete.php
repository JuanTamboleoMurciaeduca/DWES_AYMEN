<?php

class AlquilerPatinete extends Alquiler{

    function modalidad(): string
    {
        return 'patinete';
    }

    #[Override]
    protected function tarifaDiaria(): int
    {
        return 1000;
    }
}