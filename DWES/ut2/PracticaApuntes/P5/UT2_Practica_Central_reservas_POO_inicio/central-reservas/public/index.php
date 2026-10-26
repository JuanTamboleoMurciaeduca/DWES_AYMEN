<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/cargar.php';
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$actividades = crearActividades();
$avisos = [];
$mensaje = '';
$error = '';
$cierre = '';

// INICIO E1
// TODO E1. Lee y valida los filtros como indica el apartado 7.
$texto = entrada($_GET, 'q');
$tipo = entrada($_GET, 'tipo');
if ($tipo !== '' && $tipo !== 'gratuita' && $tipo !== 'pago') {
    $avisos[] = 'El tipo indicado no es valido';
    $tipo = '';
}
$estadoTexto = entrada($_GET, 'estado');
$estado = null;
if ($estadoTexto !== '') {
    $estado = EstadoActividad::tryFrom($estadoTexto);
    if ($estado === null) {
        $avisos[] = 'El estado indicado no es valido';
        $estadoTexto = '';
    }
}
$soloDisponibles = entrada($_GET, 'disponibles') === '1';
$orden = entrada($_GET, 'orden', 'nombre');
if ($orden !== 'nombre' && $orden !== 'libres') {
    $avisos[] = 'El orden indicado no es valido';
    $orden = 'nombre';
}
$idConsulta = entrada($_GET, 'id');
// FIN E1

if (isset($_GET['accion'])) {
    try {
        $accion = entrada($_GET, 'accion');
        if ($accion !== 'reservar' && $accion !== 'cancelar') {
            throw new InvalidArgumentException('La accion tiene que ser reservar o cancelar');
        }
        $idActividad = enteroPositivo(entrada($_GET, 'idActividad'));
        $cantidad = enteroPositivo(entrada($_GET, 'cantidad'));
        $actividad = buscarPorId($actividades, $idActividad);
        if ($actividad === null) {
            throw new ReservaException('No existe la actividad indicada');
        }
        if ($accion === 'reservar') {
            $actividad->reservar($cantidad);
            $mensaje = 'Reserva realizada: ' . euros($actividad->importe($cantidad));
        } else {
            $actividad->cancelar($cantidad);
            $mensaje = 'Cancelacion realizada: ' . euros($actividad->importe($cantidad));
        }
    } catch (PlazasInsuficientesException $excepcion) {
        $error = $excepcion->getMessage();
    } catch (ReservaException $excepcion) {
        $error = $excepcion->getMessage();
    } catch (InvalidArgumentException $excepcion) {
        $error = $excepcion->getMessage();
    } finally {
        $cierre = 'Procesamiento de la operación finalizado.';
    }
}

// INICIO E3
// TODO E3. Consulta la ficha y prepara el listado, el resumen y las etiquetas.
$ficha = null;
if ($idConsulta !== '') {
    try {
        $idFicha = enteroPositivo($idConsulta);
        $ficha = buscarPorId($actividades, $idFicha);
        if ($ficha === null) {
            $avisos[] = 'No existe la actividad con id ' . $idConsulta;
        }
    } catch (InvalidArgumentException $excepcion) {
        $avisos[] = 'El id de la ficha no es valido';
    }
}
$visibles = filtrarActividades($actividades, $texto, $tipo, $estado, $soloDisponibles);
$visibles = ordenarActividades($visibles, $orden);
$resumen = resumirActividades($visibles);
$etiquetas = generarEtiquetas($visibles, prefijo: 'Actividad: ');
// FIN E3

require __DIR__ . '/../vista/catalogo.php';
