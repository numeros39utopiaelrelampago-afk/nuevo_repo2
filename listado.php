<?php
// listado.php - Punto de entrada público al catálogo de productos
require_once 'includes/init.php';
require_once 'config/conexion.php';
require_once 'controllers/CatalogoController.php';

// Ejecuta la función que consulta a MySQL y carga la vista con filtros
mostrarCatalogo();