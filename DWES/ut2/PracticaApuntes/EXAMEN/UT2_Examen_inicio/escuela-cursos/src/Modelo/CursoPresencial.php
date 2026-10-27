<?php

declare(strict_types=1);

namespace Escuela\Curso\Modelo;

use InvalidArgumentException;
use Override;

final class CursoPresencial extends Curso
{
   
    public function __construct(
        int $id,
        string $nombre,
        int $capacidad,
        int $ocupadas,
        EstadoCurso $estado,
        int $precioBaseCentimos,
        private readonly int $materialesCentimos,
    ) {
        // TODO M0: valida los materiales e inicializa la parte heredada.

        parent::__construct($id, $nombre, $capacidad, $ocupadas, $estado, $precioBaseCentimos);
        if($materialesCentimos < 0){
            throw new InvalidArgumentException('Valores negativos no permitidos en Materiales Centimos');
        }
        $this->materialesCentimos = $materialesCentimos;
    }


    public function tipo(): string
    {
        return 'presencial';
    }

    public function precioPlaza(): int
    {
        // TODO M1: calcula el precio de una plaza presencial.
        $suma = $this->precioBaseCentimos + $this->materialesCentimos;
        return $suma;
    }
}
