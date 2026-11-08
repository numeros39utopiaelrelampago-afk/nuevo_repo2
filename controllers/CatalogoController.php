<?php
require_once __DIR__ . '/../models/Producto.php';

function mostrarCatalogo() {
    $termino = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

    $categorias = [];
    if (isset($_GET['categoria'])) {
        if (is_array($_GET['categoria'])) {
            $categorias = array_map('intval', $_GET['categoria']);
        } elseif (!empty($_GET['categoria'])) {
            $categorias = [intval($_GET['categoria'])];
        }
    }

    $rarezas = isset($_GET['rareza']) && is_array($_GET['rareza']) ? $_GET['rareza'] : [];

    $porPagina = 20;
    $paginaActual = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;

    $totalProductos = contarProductosConFiltro($termino, $categorias, $rarezas);
    $totalPaginas   = ceil($totalProductos / $porPagina);
    if ($totalPaginas < 1) $totalPaginas = 1;

    if ($paginaActual > $totalPaginas) {
        $paginaActual = $totalPaginas;
    }

    $offset = ($paginaActual - 1) * $porPagina;

    $listaCategorias = obtenerCategorias();
    $listaRarezas    = obtenerRarezas();
    $productos       = buscarProductosPaginados($termino, $categorias, $rarezas, $porPagina, $offset);

    $parametrosUrl = $_GET;
    unset($parametrosUrl['p']); 

    require_once __DIR__ . '/../views/tienda/catalogo.php';
}

function mostrarDetalleProducto() {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $producto = obtenerProductoPorId($id);

    if (!$producto) {
        header("Location: listado.php");
        exit;
    }

    require_once __DIR__ . '/../views/tienda/detalle.php';
}

function mostrarCarrito() {
    require_once __DIR__ . '/../views/tienda/carrito.php';
}