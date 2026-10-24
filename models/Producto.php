<?php
require_once __DIR__ . '/../config/conexion.php';

// 1. Contar el total de productos coincidentes
function contarProductosConFiltro($termino = '', $categorias = [], $rarezas = []) {
    $conexion = obtenerConexion();
    $sql = "SELECT COUNT(*) as total FROM productos WHERE stock > 0";
    $parametros = [];

    if (!empty($termino)) {
        $sql .= " AND nombre LIKE :termino";
        $parametros[':termino'] = '%' . $termino . '%';
    }

    if (!empty($categorias) && is_array($categorias)) {
        $categorias = array_filter($categorias);
        if (!empty($categorias)) {
            $placeholdersCat = [];
            foreach ($categorias as $i => $cat) {
                $clave = ":cat_" . $i;
                $placeholdersCat[] = $clave;
                $parametros[$clave] = $cat;
            }
            $sql .= " AND categoria IN (" . implode(', ', $placeholdersCat) . ")";
        }
    }

    if (!empty($rarezas) && is_array($rarezas)) {
        $rarezas = array_filter($rarezas);
        if (!empty($rarezas)) {
            $placeholdersRar = [];
            foreach ($rarezas as $i => $rar) {
                $clave = ":rar_" . $i;
                $placeholdersRar[] = $clave;
                $parametros[$clave] = $rar;
            }
            $sql .= " AND rareza IN (" . implode(', ', $placeholdersRar) . ")";
        }
    }

    $stmt = $conexion->prepare($sql);
    $stmt->execute($parametros);
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    return intval($fila['total']);
}

// 2. Traer la porción (página) de 50 registros usando LIMIT y OFFSET
function buscarProductosPaginados($termino = '', $categorias = [], $rarezas = [], $limite = 50, $offset = 0) {
    $conexion = obtenerConexion();
    $sql = "SELECT id, nombre, precio, stock, rareza, categoria FROM productos WHERE stock > 0";
    $parametros = [];

    if (!empty($termino)) {
        $sql .= " AND nombre LIKE :termino";
        $parametros[':termino'] = '%' . $termino . '%';
    }

    if (!empty($categorias) && is_array($categorias)) {
        $categorias = array_filter($categorias);
        if (!empty($categorias)) {
            $placeholdersCat = [];
            foreach ($categorias as $i => $cat) {
                $clave = ":cat_" . $i;
                $placeholdersCat[] = $clave;
                $parametros[$clave] = $cat;
            }
            $sql .= " AND categoria IN (" . implode(', ', $placeholdersCat) . ")";
        }
    }

    if (!empty($rarezas) && is_array($rarezas)) {
        $rarezas = array_filter($rarezas);
        if (!empty($rarezas)) {
            $placeholdersRar = [];
            foreach ($rarezas as $i => $rar) {
                $clave = ":rar_" . $i;
                $placeholdersRar[] = $clave;
                $parametros[$clave] = $rar;
            }
            $sql .= " AND rareza IN (" . implode(', ', $placeholdersRar) . ")";
        }
    }

    // PDO requiere pasar LIMIT y OFFSET como enteros
    $sql .= " ORDER BY nombre ASC LIMIT :limite OFFSET :offset";

    $stmt = $conexion->prepare($sql);

    foreach ($parametros as $clave => $valor) {
        $stmt->bindValue($clave, $valor);
    }
    $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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
function buscarProductosConFiltro($termino = '', $categorias = [], $rarezas = []) {
    $conexion = obtenerConexion();

    $sql = "SELECT id, nombre, precio, stock, rareza, categoria FROM productos WHERE stock > 0";
    $parametros = [];

    // Filtro por término de búsqueda (texto)
    if (!empty($termino)) {
        $sql .= " AND nombre LIKE :termino";
        $parametros[':termino'] = '%' . $termino . '%';
    }

    // Filtro múltiple por categoría usando IN (...)
    if (!empty($categorias) && is_array($categorias)) {
        // Filtrar elementos vacíos si viniera alguno
        $categorias = array_filter($categorias);
        if (!empty($categorias)) {
            $placeholdersCat = [];
            foreach ($categorias as $indice => $cat) {
                $clave = ":cat_" . $indice;
                $placeholdersCat[] = $clave;
                $parametros[$clave] = $cat;
            }
            $sql .= " AND categoria IN (" . implode(', ', $placeholdersCat) . ")";
        }
    }

    // Filtro múltiple por rareza usando IN (...)
    if (!empty($rarezas) && is_array($rarezas)) {
        $rarezas = array_filter($rarezas);
        if (!empty($rarezas)) {
            $placeholdersRar = [];
            foreach ($rarezas as $indice => $rar) {
                $clave = ":rar_" . $indice;
                $placeholdersRar[] = $clave;
                $parametros[$clave] = $rar;
            }
            $sql .= " AND rareza IN (" . implode(', ', $placeholdersRar) . ")";
        }
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

function contarTotalProductosAdmin() {
    $conexion = obtenerConexion();
    $stmt = $conexion->query("SELECT COUNT(*) as total FROM productos");
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    return intval($fila['total']);
}

function obtenerProductosPaginadosAdmin($limite = 10, $offset = 0) {
    $conexion = obtenerConexion();
    $sql = "SELECT * FROM productos ORDER BY id ASC LIMIT :limite OFFSET :offset";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}