<?php

require_once __DIR__ . '/../BancoEjercicios/datos.php';

$suma = array_reduce(
    $libros,
    fn(int $total, array $libros): int => $total + $libros['paginas'],
    0,
);
