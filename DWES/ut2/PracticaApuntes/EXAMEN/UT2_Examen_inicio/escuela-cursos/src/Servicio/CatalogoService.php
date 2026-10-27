<?php

declare(strict_types=1);

namespace Escuela\Curso\Servicio;

use Escuela\Curso\Contrato\CursoRepository;
use Escuela\Curso\Excepcion\CursoException;
use Escuela\Curso\Modelo\{Curso, EstadoCurso};
use InvalidArgumentException;

final class CatalogoService
{
    public function __construct(private CursoRepository $repository)
    {
    }

    public function filtrar(string $texto = '', ?EstadoCurso $estado = null, bool $soloConPlazas = false): array{
        $texto = mb_strtolower(trim($texto), 'UTF-8');
        // TODO F1: filtra los cursos mediante array_filter.

        /* array_filter($this->repository->todos(),
        function () {
            if($this->nombre){

            }
        } */
        
        ) 
    }

    public function ordenar(array $cursos): array
    {
        // TODO F2: ordena una copia mediante usort y un callback.
        return usort($cursos, fn(Curso $a, Curso $b): array => $a->precioPlaza() <=> $b->precioPlaza() && $a->id() <=> $b->id());    
    }

    public function etiquetas(array $cursos, string $prefijo = 'Curso: '): array
    {
        // TODO F3: array_map y arrow function.
        return array_map(fn(Curso $a) => $a->etiqueta($prefijo), $cursos);
    }

    public function resumen(array $cursos): array
    {
        // TODO F4: calcula las tres cifras mediante array_reduce.
        return array_reduce($cursos, 
            function (array $acumulado, $cursos){
                $acumulado['cantidad'] = count($cursos);
                $acumulado['libres'] = $cursos->plazasLibres();
                $acumulado['importCentimos'] = $cursos->ocupadas * $cursos->precioBaseCentimos;
            });

    }

    public function buscarOpciones(int $plazas, int $presupuestoCentimos): array
    {
        // TODO D1: repara las etapas de esta búsqueda sin utilizar bucles.
        if ($plazas <= 0 || $presupuestoCentimos < 0) {
            throw new InvalidArgumentException('Plazas o presupuesto no válidos');
        }

        $candidatos = array_filter(
            $this->repository->todos(),
            fn (Curso $curso): bool =>
                $curso->estado() === EstadoCurso::Abierto
                || $curso->plazasLibres() >= $plazas
        );

        $propuestas = array_map(
            fn (Curso $curso): array => [
                'id' => $curso->id(),
                'importeCentimos' => $curso->precioPlaza() * $plazas,
                'libresDespues' => $curso->plazasLibres() - $plazas
            ],
            $candidatos
        );

        
        $resultado = array_reduce(
            $propuestas,
            function (array $acumulado, array $propuesta) use ($presupuestoCentimos): array {
                $disponible = $presupuestoCentimos - $acumulado['importeAcumulado'];
                
                if ($propuesta['importeCentimos'] <= $presupuestoCentimos) {
                    $acumulado['opciones'] = [$propuesta];
                    $acumulado['importeAcumulado'] += $propuesta['importeCentimos'];
                }
                
                return $acumulado;
            },
            ['opciones' => [], 'importeAcumulado' => 0]
            );

         usort(
            $resultado,
            fn (array $a, array $b): int =>
                (($a['importeCentimos'] <=> $b['importeCentimos']) !== 0)
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
    public function planificarReserva(int $plazas,int $presupuestoCentimos): array{
        /* if($plazas <= 0 || $presupuestoCentimos < 0){
            throw new InvalidArgumentException('Las plazas no pueden ser menores o iguales a 0 y el presupuseto no puede ser menor que 0');
        }
        return  */
    }
}
