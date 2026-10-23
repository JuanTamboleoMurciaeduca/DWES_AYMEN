<?php
declare(strict_types=1);

// TODO M7. Implementa la especialización final gratuita.
final class ActividadGratuita extends Actividad{


    function __construct(int $id, string $nombre, int $capacidad, int $ocupadas, EstadoActividad $estado, ?Responsable $responsable)
    {
        parent::__construct($id, $nombre, $capacidad, $ocupadas, $estado, $responsable);

    }
    #[Override]
    function tipo(): string
    {
        $tipo = 'gratuita';
        return $tipo;
    }
    #[Override]
    function importe(int $cantidad): int{
        if($cantidad <= 0){
            throw new InvalidArgumentException('La cantidad tiene que ser mayor que cero');
        }else{
            return 0;
        }  
    }

    

}