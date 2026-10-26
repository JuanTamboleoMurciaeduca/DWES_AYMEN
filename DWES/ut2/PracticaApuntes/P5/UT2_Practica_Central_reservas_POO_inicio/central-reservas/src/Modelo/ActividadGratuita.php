<?php

declare(strict_types=1);

// TODO M7. Implementa la especialización final gratuita.
final class ActividadGratuita extends Actividad
{
    #[Override]
    function tipo(): string
    {
        return 'gratuita';
    }

    #[Override]
    function importe(int $cantidad): int
    {
        // Si es gratuita
        if ($cantidad < 0) {
            throw new InvalidArgumentException('La cantidad tiene que ser mayor que cero');
        } else {
            return 0;
        }
    }
}
