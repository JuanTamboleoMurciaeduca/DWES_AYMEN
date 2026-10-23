<?php

abstract class Alquiler
{
    // Mejor promoción
    function __construct(private readonly int $id, private string $cliente, private int $dias, private EstadoAlquiler $estado)
    {
        // También igual
        if ($id <= 0) {
            throw new InvalidArgumentException('El id tiene que ser positivo');
        }
        if (trim($cliente) === '') {
            throw new InvalidArgumentException('El nombre del cliente no puede estar vacio');
        } else {
            $this->cliente = trim($cliente);
        }
        if ($dias > 7 || $dias < 1) {
            throw new InvalidArgumentException('Los dias se tiene que mantener en el rango (1-7)');
        }
    }

    function id(): int
    {
        return $this->id;
    }
    function cliente(): string
    {
        return $this->cliente;
    }
    function dias(): int
    {
        return $this->dias;
    }
    function estado(): EstadoAlquiler
    {
        return $this->estado;
    }

    abstract function modalidad(): string;
    protected abstract function tarifaDiaria(): int;

    public function importe(): int
    {
        $calc = $this->tarifaDiaria() * $this->dias();
        return $calc;
    }

    public function iniciar(): void
    {
        // De reservado a activo -0,25
        if ($this->estado() === EstadoAlquiler::Reservado) {
            $this->estado = EstadoAlquiler::Activo;
        } else {
            throw new AlquilerException('El estado del alquiler tiene que satr reservado');
        }
    }
    public function finalizar(): void
    {
        if ($this->estado() === EstadoAlquiler::Activo) {
            $this->estado = EstadoAlquiler::Finalizado;
        } else {
            throw new AlquilerException('El estado del alquiler tiene que estar iniciado');
        }
    }

    // Era en bin/alquileres.php
    function mostrar(
        string $titulo,
        array $alquileres,
        ServicioAlquileres $servicio
    ): void {
        echo $titulo . PHP_EOL;
        if ($alquileres === []) {
            echo 'Sin resultados' . PHP_EOL;
        }
        foreach ($alquileres as $a) {
            echo $a->id() . ' | ' . $a->cliente() . ' | ' . $a->modalidad() . ' | días: ' . $a->dias() . ' | ' . $a->estado()->value . ' | ' . $a->importe() . ' céntimos' . PHP_EOL;
        }
        $resumen = $servicio->resumir($alquileres);
        echo 'Cantidad: ' . $resumen['cantidad'] . ' | Importe: ' . $resumen['importe'] . ' céntimos' . PHP_EOL . PHP_EOL;
    }
}
