<?php
declare(strict_types=1);

// TODO M7. Implementa la especialización final de pago y su constructor.
final class ActividadPago extends Actividad{


    private readonly int $precioCentimos;
    function __construct(int $id, string $nombre, int $capacidad, int $ocupadas, EstadoActividad $estado, Responsable $responsable, int $precioCentimos)
    {
        parent::__construct($id, $nombre, $capacidad, $ocupadas, $estado, $responsable);
        if($precioCentimos <= 0){
            throw new InvalidArgumentException('Precio negativo o igual a cero, no es valido');       
        }else{
           $this->precioCentimos = $precioCentimos;
        }
    }
    #[Override]
    function tipo(): string
    {
        return 'pago';
    }
    #[Override]
    function importe(int $cantidad): int
    {
        if($cantidad < 0){
            throw new InvalidArgumentException('No se admiten cantidades negativas');
        }elseif($cantidad === 0 && $this->precioCentimos === 0){
            return 0;
        }else{            
            $total = $cantidad * $this->precioCentimos;
            return $total;
        }
    }
}