<?php

declare(strict_types=1);

// TODO M5. Especializa JuegoMesa con su constructor, plazo y ficha.

final class JuegoMesa extends Juego
{

    private int $jugadores;

    public function __construct(int $id, string $nombre, int $jugadores)
    {
        parent::__construct($id, $nombre);
        if ($jugadores <= 0) {
            throw new InvalidArgumentException('Numero de jugadores no valido');
        }
        $this->jugadores = $jugadores;
    }

    public function jugadores(): int
    {
        return $this->jugadores;
    }

    public function plazoMaximo(): int
    {
        return 14;
    }

    public function ficha(): string
    {
        return parent::ficha() . ' · ' . $this->jugadores . ' jugadores';
    }
}
