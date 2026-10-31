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
        foreach ($categorias as $i => $catId) {
            $clave = ":cat_" . $i;
            $placeholdersCat[] = $clave;
            $parametros[$clave] = (int)$catId;
        }
        $sql .= " AND id_categoria IN (" . implode(', ', $placeholdersCat) . ")";
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

// 2. Traer registros usando LIMIT y OFFSET
function buscarProductosPaginados($termino = '', $categorias = [], $rarezas = [], $limite = 50, $offset = 0) {
    $conexion = obtenerConexion();

    // Hacemos JOIN para traer los datos del producto y el nombre de la categoria
$sql = "SELECT p.*, c.nombre AS categoria 
        FROM productos p 
        LEFT JOIN categorias c ON p.id_categoria = c.id 
        WHERE p.activo = 1 AND p.stock > 0";
    $parametros = [];

    if (!empty($termino)) {
        $sql .= " AND p.nombre LIKE :termino";
        $parametros[':termino'] = '%' . $termino . '%';
    }

    // Filtrar por ID de categoría 
    if (!empty($categorias) && is_array($categorias)) {
        $categorias = array_filter($categorias);
        if (!empty($categorias)) {
            $placeholdersCat = [];
            foreach ($categorias as $i => $catId) {
                $clave = ":cat_" . $i;
                $placeholdersCat[] = $clave;
                $parametros[$clave] = $catId;
            }
            $sql .= " AND p.id_categoria IN (" . implode(', ', $placeholdersCat) . ")";
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
            $sql .= " AND p.rareza IN (" . implode(', ', $placeholdersRar) . ")";
        }
    }

    $sql .= " ORDER BY p.nombre ASC LIMIT :limite OFFSET :offset";

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
    $stmt = $conexion->query("SELECT id, nombre FROM categorias ORDER BY nombre ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtiene todas las rarezas disponibles para armar el <select>
function obtenerRarezas() {
    $conexion = obtenerConexion();
    $sql = "SELECT DISTINCT rareza FROM productos WHERE rareza IS NOT NULL AND rareza != '' ORDER BY rareza ASC";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Búsqueda con filtros de Texto, Categoría y Rareza 
function buscarProductosConFiltro($termino = '', $categorias = [], $rarezas = []) {
    $conexion = obtenerConexion();

    $sql = "SELECT id, nombre, precio, stock, rareza, categoria FROM productos WHERE stock > 0";
    $parametros = [];

    // Filtro por término de búsqueda (texto)
    if (!empty($termino)) {
        $sql .= " AND nombre LIKE :termino";
        $parametros[':termino'] = '%' . $termino . '%';
    }

    // Filtro múltiple de categorías
    if (!empty($categorias) && is_array($categorias)) {
    // Limpiamos elementos vacíos o 0
    $categorias = array_filter($categorias);
    if (!empty($categorias)) {
        $placeholdersCat = [];
        foreach ($categorias as $i => $catId) {
            $clave = ":cat_" . $i;
            $placeholdersCat[] = $clave;
            $parametros[$clave] = (int)$catId;
        }
        $sql .= " AND p.id_categoria IN (" . implode(', ', $placeholdersCat) . ")";
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
    
    $sql = "SELECT p.*, c.nombre AS categoria 
            FROM productos p 
            LEFT JOIN categorias c ON p.id_categoria = c.id 
            WHERE p.id = :id AND p.stock > 0 
            LIMIT 1";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id' => (int)$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function obtenerProductoPorIdAdmin($id) {
    $conexion = obtenerConexion();
    
    $sql = "SELECT p.*, c.nombre AS categoria 
        FROM productos p 
        LEFT JOIN categorias c ON p.id_categoria = c.id 
        WHERE p.id = :id AND p.activo = 1 AND p.stock > 0 
        LIMIT 1";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id' => (int)$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Listado (L)
function obtenerTodosLosProductosAdmin() {
    $conexion = obtenerConexion();
    $sql = "SELECT id, nombre, precio, stock, rareza, categoria FROM productos ORDER BY id DESC";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Alta (A)
function crearProducto($nombre, $precio, $stock, $rareza, $idCategoria) {
    $conexion = obtenerConexion();
    
    $sql = "INSERT INTO productos (nombre, precio, stock, rareza, id_categoria) 
            VALUES (:nombre, :precio, :stock, :rareza, :id_categoria)";
            
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':nombre'       => $nombre,
        ':precio'       => $precio,
        ':stock'        => $stock,
        ':rareza'       => $rareza,
        ':id_categoria' => (int)$idCategoria
    ]);

    return $conexion->lastInsertId();
}

// Modificación (M)
function actualizarProducto($id, $nombre, $precio, $stock, $rareza, $idCategoria) {
    $conexion = obtenerConexion();
    
    $sql = "UPDATE productos 
            SET nombre = :nombre, 
                precio = :precio, 
                stock = :stock, 
                rareza = :rareza, 
                id_categoria = :id_categoria 
            WHERE id = :id";
            
    $stmt = $conexion->prepare($sql);
    return $stmt->execute([
        ':id'           => (int)$id,
        ':nombre'       => $nombre,
        ':precio'       => $precio,
        ':stock'        => (int)$stock,
        ':rareza'       => $rareza,
        ':id_categoria' => (int)$idCategoria
    ]);
}

// Baja (B)
function eliminarProducto($id) {
    $conexion = obtenerConexion();
    $sql = "UPDATE productos SET activo = 0 WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    return $stmt->execute([':id' => (int)$id]);
}

function contarTotalProductosAdmin() {
    $conexion = obtenerConexion();
    $stmt = $conexion->query("SELECT COUNT(*) as total FROM productos WHERE activo = 1");
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fila ? (int)$fila['total'] : 0;
}

function obtenerProductosPaginadosAdmin($limite = 10, $offset = 0) {
    $conexion = obtenerConexion();
    
    $sql = "SELECT p.*, c.nombre AS categoria 
            FROM productos p 
            LEFT JOIN categorias c ON p.id_categoria = c.id 
            ORDER BY p.id ASC 
            LIMIT :limite OFFSET :offset";

    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}