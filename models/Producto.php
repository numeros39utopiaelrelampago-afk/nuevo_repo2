<?php
require_once __DIR__ . '/../config/conexion.php';

// Obtiene todas las categorías disponibles
function obtenerCategorias() {
    $conexion = obtenerConexion();
    $sql = "SELECT DISTINCT categoria FROM productos ORDER BY categoria ASC";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// NUEVA: Obtiene todas las rarezas disponibles para armar el <select>
function obtenerRarezas() {
    $conexion = obtenerConexion();
    $sql = "SELECT DISTINCT rareza FROM productos WHERE rareza IS NOT NULL AND rareza != '' ORDER BY rareza ASC";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Búsqueda con filtros de Texto, Categoría y Rareza (manteniendo stock > 0)
function buscarProductosConFiltro($termino = '', $categoria = '', $rareza = '') {
    $conexion = obtenerConexion();

    $sql = "SELECT id, nombre, precio, stock, rareza, categoria FROM productos WHERE stock > 0";
    $parametros = [];

    // Filtro por nombre
    if (!empty($termino)) {
        $sql .= " AND nombre LIKE :termino";
        $parametros[':termino'] = '%' . $termino . '%';
    }

    // Filtro por categoría
    if (!empty($categoria)) {
        $sql .= " AND categoria = :categoria";
        $parametros[':categoria'] = $categoria;
    }

    // NUEVO: Filtro por rareza
    if (!empty($rareza)) {
        $sql .= " AND rareza = :rareza";
        $parametros[':rareza'] = $rareza;
    }

    $sql .= " ORDER BY nombre ASC";

    $stmt = $conexion->prepare($sql);
    $stmt->execute($parametros);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerProductoPorId($id) {
    $conexion = obtenerConexion();
    $sql = "SELECT id, nombre, precio, stock, rareza, categoria 
            FROM productos 
            WHERE id = :id AND stock > 0 
            LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Listado (L): Obtiene TODOS los productos sin filtrar por stock para el panel admin[cite: 2]
function obtenerTodosLosProductosAdmin() {
    $conexion = obtenerConexion();
    $sql = "SELECT id, nombre, precio, stock, rareza, categoria FROM productos ORDER BY id DESC";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Alta (A): Inserta una nueva carta
function crearProducto($nombre, $precio, $stock, $rareza, $categoria) {
    $conexion = obtenerConexion();
    $sql = "INSERT INTO productos (nombre, precio, stock, rareza, categoria) 
            VALUES (:nombre, :precio, :stock, :rareza, :categoria)";
    $stmt = $conexion->prepare($sql);
    return $stmt->execute([
        ':nombre'    => $nombre,
        ':precio'    => $precio,
        ':stock'     => $stock,
        ':rareza'    => $rareza,
        ':categoria' => $categoria
    ]);
}

// Modificación (M): Actualiza los datos de una carta por su ID
function actualizarProducto($id, $nombre, $precio, $stock, $rareza, $categoria) {
    $conexion = obtenerConexion();
    $sql = "UPDATE productos 
            SET nombre = :nombre, precio = :precio, stock = :stock, rareza = :rareza, categoria = :categoria 
            WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    return $stmt->execute([
        ':nombre'    => $nombre,
        ':precio'    => $precio,
        ':stock'     => $stock,
        ':rareza'    => $rareza,
        ':categoria' => $categoria,
        ':id'        => $id
    ]);
}

// Baja (B): Elimina una carta[cite: 2]
function eliminarProducto($id) {
    $conexion = obtenerConexion();
    $sql = "DELETE FROM productos WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    return $stmt->execute([':id' => $id]);
}