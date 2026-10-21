<?php

declare(strict_types=1);

// TODO M4. Implementa la base abstracta Juego y las operaciones del préstamo.
abstract class Juego implements Prestable
{
    use GeneraEtiqueta;

    private int $id;
    private string $nombre;
    private bool $prestado = false;
    private int $dias = 0;

    function __construct(int $id, string $nombre)
    {
        if ($id <= 0 || trim($nombre) === '') {
            throw new InvalidArgumentException('Datos inválidos');
        }
        $this->id = $id;
        $this->nombre = trim($nombre);
    }

    public function id(): int
    {
        return $this->id;
    }
    public function nombre(): string
    {
        return $this->nombre;
    }
    public function prestado(): bool
    {
        return $this->prestado;
    }
    public function dias(): int
    {
        return $this->dias;
    }

    public abstract function plazoMaximo(): int;

    public function ficha(): string
    {
        $estado = $this->prestado() ? 'Prestado' : 'Disponible';
        return $this->etiqueta() . " · " . $estado . " · Dias: " . $this->dias();
    }

    #[Override]
    public function prestar(int $dias): void
    {
        if ($dias <= 0) {
            throw new InvalidArgumentException('Numero de dias invalido');
        }
        if ($this->prestado()) {
            throw new PrestamoException('El juego ya esta prestado');
        }
        if ($dias > $this->plazoMaximo()) {
            throw new PrestamoException('Plazo maximo suprado');
        }
        $this->prestado = true;
        $this->dias = $dias;
    }

    public function renovar(int $diasExtra): void
    {
        if ($diasExtra <= 0) {
            throw new InvalidArgumentException('Numero de dias invalido');
        }
        if (!$this->prestado()) {
            throw new PrestamoException('El juego no está prestado');
        }
        if ($this->dias() + $diasExtra > $this->plazoMaximo()) {
            throw new PrestamoException('Plazo maximo superado');
        }
        $this->dias += $diasExtra;
    }

    public function devolver(): void
    {
        if (!$this->prestado()) {
            throw new PrestamoException('El juego no esta prestado');
        }
        $this->prestado = false;
        $this->dias = 0;
    }
}
