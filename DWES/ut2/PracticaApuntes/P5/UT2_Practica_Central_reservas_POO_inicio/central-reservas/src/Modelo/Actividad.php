<?php
declare(strict_types=1);

// TODO M6. Implementa la clase abstracta Actividad, sus reglas y las operaciones final.

abstract class Actividad implements Reservable{
    use GeneraEtiqueta;
    private readonly int $id; 
    private readonly string $nombre;
    private readonly int $capacidad;
    private int $ocupadas;
    private readonly EstadoActividad $estado;
    private readonly ?Responsable $responsable; 

    function __construct(int $id, string $nombre, int $capacidad, int $ocupadas,EstadoActividad $estado, ?Responsable $responsable)
    {
        if($id < 0){
            throw new InvalidArgumentException('Dato invalido, el id tiene que ser positivo');
        }else{
            $this->id = $id;
        }

        if(trim($nombre) === ''){
            throw new InvalidArgumentException('Dato invalido, el nombre tiene que contener informacion');
        }else{
            $this->nombre = $nombre;
        }

        if($capacidad < 0){
            throw new InvalidArgumentException('Dato invalido, la capacidad tiene que ser un entero mayor que cero');
        }else{
            $this->capacidad = $capacidad;
        }

        if($ocupadas < 0 && $ocupadas > $capacidad ){
            throw new InvalidArgumentException('Dato invalido, ocupadas tiene que ser mayor que cero y menor que la capacidad');
        }else{
            $this->ocupadas = $ocupadas;
        }

        if($estado === EstadoActividad::Abierta || $estado === EstadoActividad::Cerrada){
            $this->estado =  $estado;
        }else{
            throw new InvalidArgumentException('Dato invalido, la actividad solo puede estar cerrada o abierta');
        }
        if($responsable === null || $responsable instanceof Responsable ){
            $this->responsable = $responsable;
        }else{
            throw new InvalidArgumentException('Dato invalido, responsable solo pude ser un objeto resposable o null');
        }
    }
    public function id(): int{
        return $this->id; 
    }
    public function nombre(): string{
        return $this->nombre; 
    }
    public function capacidad(): int{
        return $this->capacidad; 
    }
    public function ocupadas(): int{
        return $this->ocupadas; 
    }
    public function estado(): EstadoActividad{
        return $this->estado; 
    }
    public function responsable(): ?Responsable{
        return $this->responsable; 
    }

    #[Override]
    function plazasLibres(): int
    {
        return $this->capacidad() - $this->ocupadas();
    }

    abstract function tipo(): string;
    abstract function importe(int $cantidad): int;

    #[Override]
    public final function reservar(int $cantidad): void
    {
        if($cantidad <= 0){
            throw new InvalidArgumentException('La cantidad tiene que ser mayor que cero');
        }elseif($this->estado === EstadoActividad::Cerrada){
            throw new ReservaException('El estado de la reserva esta cerrado');
        }elseif($cantidad > $this->plazasLibres()){
            throw new PlazasInsuficientesException('La cantidad de reservas supera las plazas maximas');
        }else{
            $this->ocupadas + $this->ocupadas + $cantidad;
        }       
    }

    #[Override]
    public final function cancelar(int $cantidad): void
    {
        if($cantidad <= 0){
            throw new InvalidArgumentException('La cantidad tiene que ser mayor que cero');
        }elseif($cantidad > $this->plazasLibres()){
            throw new PlazasInsuficientesException('La cantidad supera las plazas maximas');
        }else{
            $this->ocupadas + $this->ocupadas - $cantidad;
        }  
    }
}