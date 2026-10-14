<?php
require_once __DIR__ . '/../models/Producto.php';

function mostrarCatalogo() {
    // Leemos los filtros enviados por el formulario GET (si no existen, quedan vacíos)
    $termino   = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
    $categoria = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';
    $rareza    = isset($_GET['rareza']) ? trim($_GET['rareza']) : ''; 

    // Llamamos al modelo
    $categorias = obtenerCategorias();
    $rarezas    = obtenerRarezas(); 
    $productos  = buscarProductosConFiltro($termino, $categoria, $rareza);
    
    // Cargamos la vista pasándole las variables anteriores
    require_once __DIR__ . '/../views/tienda/catalogo.php';
}

function mostrarDetalleProducto() {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $producto = obtenerProductoPorId($id);

    // Si el producto no existe o se quedó sin stock, volvemos al listado
    if (!$producto) {
        header("Location: listado.php");
        exit;
    }

    require_once __DIR__ . '/../views/tienda/detalle.php';
}

// En controllers/CatalogoController.php
function mostrarCarrito() {
    require_once __DIR__ . '/../views/tienda/carrito.php';
}