<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Autor.php';
require_once __DIR__ . '/../src/Categoria.php';
require_once __DIR__ . '/../src/Libro.php';
require_once __DIR__ . '/../src/datos.php';

// Fase 4: convierte los registros de $datos en objetos Libro.
$libros = [];

foreach ($datos as $registro) {
    $id = $registro['id'];
    $titulo = $registro['titulo'];
    $paginas = $registro['paginas'];
    $autor = $registro['autor'] === null ? null : new Autor($registro['autor']);
    $categoria = new Categoria($registro['categoria']);
    $disponible = $registro['disponible'];
    $libros[] = new Libro($id, $titulo, $paginas, $autor, $categoria, $disponible);
}

/** Lo que realiza la linea "$libro->autor?->nombre ?? 'Sin autor'" es, verificar primero si el contenido del autor del $libro es 
 * correcto de acuerdo al constructor de la variable, es decir que nombre sea un string, en el caso de que no sea asi se escribe 'Sin autor'  */

// Fase 5: realiza aquí las comprobaciones de préstamos e identidad.
// Añade textos a $mensajes; la vista los mostrará debajo del catálogo.
// Termina devolviendo Dune para conservar el estado inicial del catálogo.
$mensajes = [];
$dune = $libros[0];
$otro = [];
foreach ($libros as $libro) {
    if ($libro->titulo === '1984') {
        $otro = $libro;
    }
}


/* $mensajes[] = 'Dune Disponible: '.($dune->disponible ? 'true' : 'false');
$mensajes[] = 'Otro Disponible: '.($otro->disponible ? 'true' : 'false');

$dune->prestar();

$mensajes[] = 'Dune Disponible (Prestado): '.($dune->disponible ? 'true' : 'false');
$mensajes[] = 'Otro Disponible: '.($otro->disponible ? 'true' : 'false');

$dune->devolver();

$mensajes[] = 'Dune Disponible (Devuelto): '.($dune->disponible ? 'true' : 'false');
$mensajes[] = 'Otro Disponible: '.($otro->disponible ? 'true' : 'false');

$fichaDune = $dune->ficha();
$fichaOtro = $otro->ficha();

$mensajes[] = "Ficha Completa: $fichaDune";
$mensajes[] = "Ficha Completa: $fichaOtro";
     */

$alias = $dune;
$alias->prestar();
$mensajes[] = 'Dune Disponible: ' . ($dune->disponible ? 'true' : 'false');
$mensajes[] = 'Alias Disponible: ' . ($alias->disponible ? 'true' : 'false');

$mensajes[] = 'Alias y dune son iguales: ' . ($dune === $alias  ? 'true' : 'false');

$autor = new Autor('Frank Herbert');
$categoria = new Categoria('Ciencia Ficción');
$duneCopia = new Libro(10, 'Dune', 412, $autor, $categoria, true);

$mensajes[] = 'CopiaDune y dune son iguales: ' . ($dune === $duneCopia  ? 'true' : 'false');

$dune->devolver();

$mensajes[] = 'Alias Disponible: ' . ($alias->disponible ? 'true' : 'false');
$mensajes[] = 'Dunelias Disponible: ' . ($dune->disponible ? 'true' : 'false');


// Lectura del formulario facilitada. La búsqueda conserva el texto escrito.
$entrada = $_GET['q'] ?? '';
$entradaBusqueda = is_string($entrada) ? $entrada : '';
$soloDisponibles = isset($_GET['disponibles']);
$ordenEntrada = $_GET['orden'] ?? 'paginas';
$orden = is_string($ordenEntrada)
    && in_array($ordenEntrada, ['paginas', 'titulo'], true)
    ? $ordenEntrada : 'paginas';

// Fase 6.1: normaliza la búsqueda y filtra con array_filter.
$busqueda = mb_strtolower(trim(($entradaBusqueda)), 'UTF-8');
$visibles = array_filter($libros, fn(Libro $libro) => str_contains(mb_strtolower($libro->titulo, 'UTF-8'), $busqueda) && (!$soloDisponibles || $libro->disponible));


// Fase 6.2: ordena $visibles mediante usort y <=>.
usort($libros, fn(Libro $a, Libro $b) =>
$orden === 'paginas' ? $a->paginas <=> $b->paginas : $a->titulo <=> $b->titulo);
// Fase 6.3: resumen del catálogo completo, antes de filtrar.
// Completa disponibles con array_filter y paginas con array_reduce.
$resumen = [
    'total' => count($libros),
    'disponibles' => count(array_filter($libros, fn(Libro $libro) => $libro->disponible)),
    'paginas' => array_reduce($libros, fn(int $suma, Libro $libro) => $suma + $libro->paginas, 0)
];

// Fase 6.3: crea las fichas de los libros visibles con array_map.

$etiquetas = [];
$etiquetas = array_map(fn(Libro $libro) => $libro->ficha(), $visibles);



// Fase 6.3: busca los ids 30 y 999 con array_find y añade mensajes.

$mensajes[] = 'Busqueda por Id (30): ' . array_find($libros, fn(Libro $libro) => $libro->id === 30)?->titulo ?? 'Id No Encontrado';
$mensajes[] = 'Busqueda por Id (999): ' . (array_find($libros, fn(Libro $libro) => $libro->id === 999)?->titulo ?? 'Libro no encontrado');



require __DIR__ . '/../vista/catalogo.php';
