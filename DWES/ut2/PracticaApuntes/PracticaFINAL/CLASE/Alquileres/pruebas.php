<?php
require_once __DIR__. ('/Excepcion/AlquilerException.php');
require_once __DIR__. ('/Modelo/Alquiler.php');
require_once __DIR__. ('/Modelo/AlquilerBicicleta.php');
require_once __DIR__. ('/Modelo/AlquilerPatinete.php');
require_once __DIR__. ('/Modelo/EstadoAlquiler.php');
require_once __DIR__. ('/Servicios/ServicioAlquileres.php');



$alquileres = new ServicioAlquileres([new AlquilerBicicleta(501, 'Lucía Torres', 2, EstadoAlquiler::Reservado),
                                     new AlquilerPatinete(502, 'Álex Ruiz', 2, EstadoAlquiler::Activo),
                                     new AlquilerBicicleta(503, 'Óscar Gil', 3, EstadoAlquiler::Finalizado),
                                     new AlquilerPatinete(504, 'Lucia Molina', 1, EstadoAlquiler::Reservado)]);

