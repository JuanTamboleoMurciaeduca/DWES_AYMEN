<?php

// Mal definido -0,5
enum EstadoAlquiler: string
{
    case Finalizado = 'finalizado';
    case Activo = 'activo';
    case Reservado = 'reservado';
}
