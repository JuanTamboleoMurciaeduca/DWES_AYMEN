<?php

class ServicioAlquileres{
    
    private array $alquileres;
    public function __construct(array $alquileres)
    {
        $this->alquileres = $alquileres;
    }

    public function todos(){
        foreach($this->alquileres as $alquiler){
            return $alquiler;
        }
    }

    public function consultar(string $texto='', ?EstadoAlquiler $estado = null): array{
        $arrayFiltrado = array_filter($this->alquileres, fn(Alquiler $a) => normalizar($a->cliente()) === normalizar($texto) 
                                                                            || $a->$estado === $estado);
                                                                        
        usort($arrayFiltrado, fn(Alquiler $a, Alquiler $b) =>  $a->cliente() <=> $b->cliente() || $a->id() <=> $b->id());      
        return $arrayFiltrado;
    }
    
    public function normalizar(string $texto): string{

        $textoNormalizado = mb_strtolower(trim($texto),'UTF-8');
        if($textoNormalizado === ''){

        }
        return $textoNormalizado;
    }

    function resumir(array $alquileres): array{

        $cantidad = count($alquileres);
        $sumaCentimos = 0;

        foreach($alquileres as $alquiler){
            $sumaCentimos = $sumaCentimos + $alquiler->importe();
        }     
        $info = [$cantidad, $sumaCentimos];

        return $info;
    }



}