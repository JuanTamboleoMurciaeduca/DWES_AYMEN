<?php

declare(strict_types=1);

final class Libro
{
    // Fase 2: constructor con promoción de propiedades públicas tipadas.
    public function __construct(
        public int $id,
        public string $titulo,
        public int $paginas,
        public ?Autor $autor,
        public Categoria $categoria,
        public bool $disponible = true,
    ) {
        // Fase 3: título sin espacios en los extremos y valores por defecto si no es válido o las páginas no son positivas.
        $this->titulo = trim($this->titulo);
        if ($this->titulo === '') {
            $this->titulo = 'Sin Titulo';
        }

        if ($paginas <= 0) {
            $this->paginas = 1;
        }
    }
    // Fase 5: prestar(), devolver() y ficha().
    function prestar(): void
    {
        $this->disponible = false;
    }
    function devolver(): void
    {
        $this->disponible = true;
    }
    function ficha(): string
    {
        $autor = $this->autor?->nombre ?? 'Sin Titulo';
        $categoria = $this->categoria->nombre;
        $fichaCompleta = "$this->titulo / $autor / $categoria / $this->paginas páginas";
        return $fichaCompleta;
    }
}
