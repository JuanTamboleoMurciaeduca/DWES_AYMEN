<?php
require_once __DIR__ . '/src/cargar.php';
require_once __DIR__ . '/src/datos.php';

$actividades = crearActividades();

/*1*/

$tallerComic = $actividades[0];
echo $tallerComic->importe(2);
echo "\n";

$tallerVideojuegos = $actividades[2];
echo $tallerVideojuegos->importe(2);
echo "\n";

/*2*/

echo $tallerComic->responsable()?->nombre()?? "Nombre vacio";
echo "\n";
echo $tallerVideojuegos->responsable()?->nombre()?? "Nombre vacio";
echo "\n";

$tallerLectura = $actividades[3];
echo $tallerLectura->responsable()?->nombre()?? "Nombre vacio";
echo "\n";

/*3*/

echo $tallerVideojuegos->etiqueta('TV');
echo "\n";
echo $tallerVideojuegos->responsable()?->etiqueta('TV')?? "No hay Responsable";

echo "\n";

echo $tallerLectura->etiqueta('TL');
echo "\n";
echo $tallerLectura->responsable()?->etiqueta('TL')?? "No hay Responsable";
echo "\n";
/*4*/

try{
    $tallerVideojuegos->responsable()->nombre = 'bruno';
}catch (Error $e){
    echo $e->getMessage();
}
echo "\n";
echo $tallerVideojuegos->responsable()->nombre;



