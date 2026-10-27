<?php

abstract class Alquiler {
    private readonly int $id;
    private string $cliente;
    private int $dias;
    private EstadoAlquiler $estado;

    function __construct(int $id, string $cliente, int $dias, EstadoAlquiler $estado){
        if($id < 0){
            throw new InvalidArgumentException('El id tiene que ser positivo');
        }else{
            $this->id = $id;
        }
        if(trim($cliente) === ''){
            throw new InvalidArgumentException('El nombre del cliente no puede estar vacio');
        }else{            
            $this->cliente = trim($cliente);
        }
        if($dias > 7 || $dias < 1){
            throw new InvalidArgumentException('Los dias se tiene que mantener en el rango (1-7)');
        }else{                     
            $this->dias = $dias;
        }
        $this->estado = $estado;
    }

    function id(): int{return $this->id;}
    function cliente(): string{return $this->cliente;}
    function dias(): int{return $this->dias;}
    function estado(): EstadoAlquiler{ return $this->estado;}

    abstract function modalidad(): string;
    protected abstract function tarifaDiaria(): int;
    
    public function importe(): int{
        $calc = $this->tarifaDiaria() * $this->dias();
        return $calc;
    }

    public function iniciar(): void{
        if($this->estado() === EstadoAlquiler::Finalizado){
            $this->estado = EstadoAlquiler::Activo;
        }else{
            throw new AlquilerException('El estado del alquiler tiene que estar finalizado');
        }
    }
    public function finalizar(): void{
        if($this->estado() === EstadoAlquiler::Activo){
            $this->estado = EstadoAlquiler::Finalizado;
        }else{
            throw new AlquilerException('El estado del alquiler tiene que estar iniciado');
        }
    }

    function mostrar(string $titulo, array $alquileres,
        ServicioAlquileres $servicio): void
    {
        echo $titulo . PHP_EOL;
        if ($alquileres === []) {
            echo 'Sin resultados' . PHP_EOL;
        }
        foreach ($alquileres as $a) {
            echo $a->id() . ' | ' . $a->cliente() . ' | ' . $a->modalidad(). ' | días: ' . $a->dias() . ' | ' . $a->estado()->value. ' | ' . $a->importe() . ' céntimos' . PHP_EOL;
        }
        $resumen = $servicio->resumir($alquileres);
        echo 'Cantidad: ' . $resumen['cantidad']. ' | Importe: ' . $resumen['importe'] . ' céntimos'. PHP_EOL . PHP_EOL;
    }


}