<?php

declare(strict_types=1);

use App\Modelo\EnvioNormal;
use App\Modelo\EnvioUrgente;
use App\Modelo\EstadoEnvio;
use App\Repositorio\RepositorioEnviosMemoria;
use App\Servicio\ServicioEnvios;
use App\Excepcion\EnvioException;

require __DIR__ . '/vendor/autoload.php';

$repositorio = new RepositorioEnviosMemoria();

$repositorio->registrar(new EnvioNormal(101, 'Librería Órbita', 1000, EstadoEnvio::Pendiente));
$repositorio->registrar(new EnvioUrgente(102, 'Taller Norte', 1500, EstadoEnvio::Enviado));
$repositorio->registrar(new EnvioNormal(103, 'Café Álamo', 2500, EstadoEnvio::Entregado));
$repositorio->registrar(new EnvioUrgente(104, 'Estudio Prisma', 500, EstadoEnvio::Cancelado));
$repositorio->registrar(new EnvioNormal(105, 'Papelería Sol', 2000, EstadoEnvio::Pendiente));
$repositorio->registrar(new EnvioUrgente(106, 'Órbita Creativa', 1001, EstadoEnvio::Pendiente));

$servicio = new ServicioEnvios($repositorio);
/* 
echo "Catálogo inicial" . PHP_EOL;
foreach ($servicio->etiquetas($repositorio->todos()) as $etiqueta) {
    echo $etiqueta . PHP_EOL;
}
print_r($servicio->resumir($repositorio->todos()));
 */


/* $orbita = $servicio->consultar(texto: ' ÓRBITA ');
foreach ($servicio->etiquetas($orbita) as $etiqueta) {
    echo $etiqueta . PHP_EOL;
}
print_r($servicio->resumir($orbita)); */

/* try {
    $servicio->enviar(101);
    echo '101 : ' . $repositorio->buscar(101)->estado()->value . '.' . PHP_EOL;
} catch (EnvioException $e) {
    echo 'Rechazado : ' . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->cancelar(101);
    echo '101 : ' . $repositorio->buscar(101)->estado()->value . '.' . PHP_EOL;
} catch (EnvioException $e) {
    echo 'Rechazado : ' . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->entregar(101);
    echo '101 : ' . $repositorio->buscar(101)->estado()->value . '.' . PHP_EOL;
} catch (EnvioException $e) {
    echo 'Rechazado : ' . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->enviar(101);
    echo '101 : ' . $repositorio->buscar(101)->estado()->value . '.' . PHP_EOL;
} catch (EnvioException $e) {
    echo 'Rechazado : ' . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->cancelar(105);
    echo '105 : ' . $repositorio->buscar(105)->estado()->value . '.' . PHP_EOL;
} catch (EnvioException $e) {
    echo 'Rechazado : ' . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->enviar(105);
    echo '105 : ' . $repositorio->buscar(105)->estado()->value . '.' . PHP_EOL;
} catch (EnvioException $e) {
    echo 'Rechazado : ' . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->entregar(102);
    echo '102 : ' . $repositorio->buscar(102)->estado()->value . '.' . PHP_EOL;
} catch (EnvioException $e) {
    echo 'Rechazado : ' . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->cancelar(104);
    echo '104 : ' . $repositorio->buscar(104)->estado()->value . '.' . PHP_EOL;
} catch (EnvioException $e) {
    echo 'Rechazado : ' . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->entregar(106);
    echo '106 : ' . $repositorio->buscar(106)->estado()->value . '.' . PHP_EOL;
} catch (EnvioException $e) {
    echo 'Rechazado : ' . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->enviar(999);
    echo '999 : ' . $repositorio->buscar(999)->estado()->value . '.' . PHP_EOL;
} catch (EnvioException $e) {
    echo 'Rechazado : ' . $e->getMessage() . PHP_EOL;
} */
