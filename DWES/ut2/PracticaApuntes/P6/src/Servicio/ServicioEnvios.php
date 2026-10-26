<?php

declare(strict_types=1);

namespace App\Servicio;

use App\Contrato\RepositorioEnvios;
use App\Excepcion\EnvioException;
use App\Modelo\Envio;
use App\Modelo\EstadoEnvio;
use InvalidArgumentException;

class ServicioEnvios
{
    public function __construct(private RepositorioEnvios $repositorio)
    {
    }

    public function enviar(int $id): void
    {
        $this->obtener($id)->enviar();
    }

    public function entregar(int $id): void
    {
        $this->obtener($id)->entregar();
    }

    public function cancelar(int $id): void
    {
        $this->obtener($id)->cancelar();
    }

    public function consultar(
        string $texto = '',
        ?string $modalidad = null,
        ?EstadoEnvio $estado = null,
        string $orden = 'precio'
    ): array {
        if ($modalidad !== null && $modalidad !== 'normal' && $modalidad !== 'urgente') {
            throw new InvalidArgumentException(
                'La modalidad debe ser null, normal o urgente.'
            );
        }

        if ($orden !== 'precio' && $orden !== 'peso') {
            throw new InvalidArgumentException('El orden debe ser precio o peso.');
        }

        $busqueda = self::normalizar($texto);
        $seleccion = [];

        foreach ($this->repositorio->todos() as $envio) {
            $coincideTexto = $busqueda === ''
                || str_contains(self::normalizar($envio->cliente()), $busqueda);
            $coincideModalidad = $modalidad === null || $envio->modalidad() === $modalidad;
            $coincideEstado = $estado === null || $envio->estado() === $estado;

            if ($coincideTexto && $coincideModalidad && $coincideEstado) {
                $seleccion[] = $envio;
            }
        }

        usort(
            $seleccion,
            static function (Envio $a, Envio $b) use ($orden): int {
                $valorA = $orden === 'peso' ? $a->peso() : $a->tarifa();
                $valorB = $orden === 'peso' ? $b->peso() : $b->tarifa();

                if ($valorA === $valorB) {
                    return $a->id() <=> $b->id();
                }

                return $valorA <=> $valorB;
            }
        );

        return $seleccion;
    }

    public function etiquetas(array $envios): array
    {
        $etiquetas = [];

        foreach ($envios as $envio) {
            $etiquetas[] = sprintf(
                '%d | %s | %s | %s | %d céntimos',
                $envio->id(),
                $envio->cliente(),
                $envio->modalidad(),
                $envio->estado()->value,
                $envio->tarifa()
            );
        }

        return $etiquetas;
    }

    public function resumir(array $envios): array
    {
        $resumen = [
            'cantidad' => 0,
            'peso' => 0,
            'importeTotal' => 0,
            'importeActivo' => 0,
            'pendiente' => 0,
            'enviado' => 0,
            'entregado' => 0,
            'cancelado' => 0,
        ];

        foreach ($envios as $envio) {
            $resumen['cantidad']++;
            $resumen['peso'] += $envio->peso();
            $resumen['importeTotal'] += $envio->tarifa();

            if ($envio->estado() !== EstadoEnvio::Cancelado) {
                $resumen['importeActivo'] += $envio->tarifa();
            }

            $resumen[$envio->estado()->value]++;
        }

        return $resumen;
    }

    private function obtener(int $id): Envio
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id debe ser un entero positivo.');
        }

        $envio = $this->repositorio->buscar($id);

        if ($envio === null) {
            throw new EnvioException("No existe el envío con id {$id}.");
        }

        return $envio;
    }

    private static function normalizar(string $texto): string
    {
        $texto = trim($texto);
        $texto = preg_replace('/\s+/u', ' ', $texto) ?? '';

        return mb_strtolower($texto, 'UTF-8');
    }
}