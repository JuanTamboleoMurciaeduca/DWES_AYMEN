<?php
declare(strict_types=1);

// TODO M4. Implementa Responsable final, sus propiedades readonly y el trait.
final class Responsable{
    use GeneraEtiqueta;
    public readonly int $id;
    public readonly string $nombre;

    function __construct(int $id, string $nombre){
        if($id < 0){
            throw new InvalidArgumentException('Id no valido, tiene que ser positivo');
        }else{
            $this->id = $id;
        }
        if(trim($nombre) === ''){
            throw new InvalidArgumentException('Nombre no valido, no puede estar vacio');
        }else{
            $this->nombre = $nombre;    
        }            
    }

    public function id(): int{
        return $this->id;
    }
    public function nombre(): string{
        return $this->nombre;
    }
}