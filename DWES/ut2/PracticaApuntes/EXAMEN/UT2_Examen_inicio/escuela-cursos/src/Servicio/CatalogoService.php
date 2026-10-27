<?php

declare(strict_types=1);

namespace Escuela\Curso\Servicio;

use Escuela\Curso\Contrato\CursoRepository;
use Escuela\Curso\Excepcion\CursoException;
use Escuela\Curso\Modelo\{Curso, EstadoCurso};
use InvalidArgumentException;

final class CatalogoService
{
    public function __construct(private CursoRepository $repository) {}

    public function filtrar(string $texto = '', ?EstadoCurso $estado = null, bool $soloConPlazas = false): array
    {
        $texto = mb_strtolower(trim($texto), 'UTF-8');
        // TODO F1: filtra los cursos mediante array_filter.

        // No ibas mal encaminado, pero necesitas repasar este tipo de funciones
        return array_values(array_filter(
            $this->repository->todos(),
            fn(Curso $c): bool =>
            str_contains($c->nombreNormalizado(), $texto) &&
                ($estado === null || $c->estado() === $estado) &&
                (!$soloConPlazas || ($c->plazasLibres() > 0 && $c->estado() === EstadoCurso::Abierto))
        ));
    }

    public function ordenar(array $cursos): array
    {
        // TODO F2: ordena una copia mediante usort y un callback.
        usort(
            $cursos,
            fn(Curso $a, Curso $b) => (($a->precioPlaza() <=> $b->precioPlaza()) === 0)
                ? ($a->id() <=> $b->id())
                : ($a->precioPlaza() <=> $b->precioPlaza())
        );

        return $cursos;
    }

    public function etiquetas(array $cursos, string $prefijo = 'Curso: '): array
    {
        // TODO F3: array_map y arrow function.
        return array_map(fn(Curso $a) => $a->etiqueta($prefijo), $cursos);
    }

    public function resumen(array $cursos): array
    {
        // TODO F4: calcula las tres cifras mediante array_reduce.
        return array_reduce(
            $cursos,
            function (array $acumulado, $cursos) {
                // Por cada elemento sumamos 1
                $acumulado['cantidad'] += 1;
                // Sumamos plazasLibres en vez de asignar
                $acumulado['libres'] += $cursos->plazasLibres();
                // Lo mismo, le sumamos eso en lugar de asignar
                $acumulado['importCentimos'] += ($cursos->ocupadas * $cursos->precioBaseCentimos);
            },
            // Falta iniciar el acumulador
            ['cantidad' => 0, 'libres' => 0, 'importeCentimos' => 0]
        );
    }

    public function buscarOpciones(int $plazas, int $presupuestoCentimos): array
    {
        // TODO D1: repara las etapas de esta búsqueda sin utilizar bucles.
        if ($plazas <= 0 || $presupuestoCentimos < 0) {
            throw new InvalidArgumentException('Plazas o presupuesto no válidos');
        }

        $candidatos = array_filter(
            $this->repository->todos(),
            fn(Curso $curso): bool =>
            $curso->estado() === EstadoCurso::Abierto
                // Cambiar esta condición
                && $curso->plazasLibres() >= $plazas
        );

        $propuestas = array_map(
            fn(Curso $curso): array => [
                'id' => $curso->id(),
                'importeCentimos' => $curso->precioPlaza() * $plazas,
                'libresDespues' => $curso->plazasLibres() - $plazas
            ],
            $candidatos
        );

        // Pero si esto os lo he dado hecho!
        $resultado = array_reduce(
            $propuestas,
            function (array $acumulado, array $propuesta) use ($presupuestoCentimos): array {
                if ($propuesta['importeCentimos'] <= $presupuestoCentimos) {
                    $acumulado[] = $propuesta;
                }

                return $acumulado;
            },
            []
        );

        usort(
            $resultado,
            fn(array $a, array $b): int => (($a['importeCentimos'] <=> $b['importeCentimos']) !== 0)
                ? ($a['importeCentimos'] <=> $b['importeCentimos'])
                : ($a['id'] <=> $b['id'])
        );

        return $resultado;
    }

    private function requerido(int $id): Curso
    {
        return $this->repository->buscarPorId($id)
            ?? throw new CursoException('El curso no existe');
    }

    public function reservar(int $id, int $cantidad): void
    {
        $this->requerido($id)->reservar($cantidad);
    }

    public function cancelar(int $id, int $cantidad): void
    {
        $this->requerido($id)->cancelar($cantidad);
    }

    // public function planificarReserva(int $plazas, int $presupuestoCentimos): array
    // {
    //     /* if($plazas <= 0 || $presupuestoCentimos < 0){
    //         throw new InvalidArgumentException('Las plazas no pueden ser menores o iguales a 0 y el presupuseto no puede ser menor que 0');
    //     }
    //     return  */
    // }
}
