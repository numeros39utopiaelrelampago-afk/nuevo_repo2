<?php
require_once __DIR__ . '/../models/Producto.php';

function mostrarCatalogo() {
    $termino    = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
    // Si no se envió nada o no es un array, se inicializa como array vacío
    $categorias = isset($_GET['categoria']) && is_array($_GET['categoria']) ? $_GET['categoria'] : [];
    $rarezas    = isset($_GET['rareza']) && is_array($_GET['rareza']) ? $_GET['rareza'] : [];

    $listaCategorias = obtenerCategorias();
    $listaRarezas    = obtenerRarezas();
    $productos       = buscarProductosConFiltro($termino, $categorias, $rarezas);

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