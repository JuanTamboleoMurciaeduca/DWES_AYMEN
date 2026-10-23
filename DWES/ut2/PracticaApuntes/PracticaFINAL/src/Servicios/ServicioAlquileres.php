<?php

class ServicioAlquileres
{

    private array $alquileres;
    public function __construct(array $alquileres)
    {
        $this->alquileres = $alquileres;
    }

    public function todos()
    {
        // No tienes que recorrer nada -0,25
        return $this->alquileres;
    }

    public function consultar(string $texto = '', ?EstadoAlquiler $estado = null): array
    {
        $arrayFiltrado =
            array_filter(
                $this->alquileres,
                // Tipo de retorno
                fn(Alquiler $a): bool =>
                // 1. Comprobar si el testo está en cliente
                // 2. Comprobar null para true
                // 3. Comprobar estado
                str_contains($this->normalizar($a->cliente()), $this->normalizar($texto)) &&
                    ($estado === null || $a->$estado === $estado)
            );

        usort(
            $arrayFiltrado,
            fn(Alquiler $a, Alquiler $b): int => ($a->importe() <=> $b->importe()) === 0
                ? $a->id() <=> $b->id()
                : $a->importe() <=> $b->importe()
        );
        return $arrayFiltrado;
    }

    public function normalizar(string $texto): string
    {
        return mb_strtolower(trim($texto), 'UTF-8');
    }

    function resumir(array $alquileres): array
    {

        $cantidad = count($alquileres);
        $sumaCentimos = 0;

        foreach ($alquileres as $alquiler) {
            $sumaCentimos = $sumaCentimos + $alquiler->importe();
        }
        $info = [$cantidad, $sumaCentimos];

        return $info;
    }
}
