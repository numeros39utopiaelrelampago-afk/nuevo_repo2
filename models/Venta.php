<?php
require_once __DIR__ . '/../config/conexion.php';

function registrarVentaCompleta($idUser, $itemsCarrito) {
    $conexion = obtenerConexion();

    try {
        // Iniciamos la transacción atómica
        $conexion->beginTransaction();

        // 1. Calcular el total acumulado
        $totalVenta = 0;
        foreach ($itemsCarrito as $item) {
            $totalVenta += ($item['precio'] * $item['cantidad']);
        }

        // 2. Insertar en la tabla 'ventas'
        $sqlVenta = "INSERT INTO ventas (id_user, total) VALUES (:id_user, :total)";
        $stmtVenta = $conexion->prepare($sqlVenta);
        $stmtVenta->execute([
            ':id_user' => $idUser,
            ':total'   => $totalVenta
        ]);

        // Obtenemos el id autoincremental de la venta recién creada
        $idVentaGenerada = $conexion->lastInsertId();

        // 3. Preparar sentencias para insertar en 'item' y descontar stock
        $sqlItem = "INSERT INTO item (id_prod, id_venta, cantidad, precio) 
                    VALUES (:id_prod, :id_venta, :cantidad, :precio)";
        $stmtItem = $conexion->prepare($sqlItem);

        $sqlStock = "UPDATE productos SET stock = stock - :cantidad WHERE id = :id";
        $stmtStock = $conexion->prepare($sqlStock);

        // 4. Recorrer cada producto del carrito
        foreach ($itemsCarrito as $prod) {
            // Insertar detalle de factura en 'item'
            $stmtItem->execute([
                ':id_prod'   => $prod['id'],
                ':id_venta'  => $idVentaGenerada,
                ':cantidad'  => $prod['cantidad'],
                ':precio'    => $prod['precio']
            ]);

            // Descontar el stock en la tabla 'productos'
            $stmtStock->execute([
                ':cantidad'  => $prod['cantidad'],
                ':id'        => $prod['id']
            ]);
        }

        // Si todo salió bien, consolidamos los cambios
        $conexion->commit();
        return $idVentaGenerada;

    } catch (Exception $e) {
        // Si algo falló, revertimos todo para no dejar registros corruptos
        $conexion->rollBack();
        return false;
    }
}

// Obtiene el historial general de ventas con el nombre del comprador
function obtenerTodasLasVentas() {
    $conexion = obtenerConexion();
    $sql = "SELECT v.id_ventas, v.fecha, v.total, u.nombre AS cliente, u.email
            FROM ventas v
            JOIN usuarios u ON v.id_user = u.id
            ORDER BY v.id_ventas DESC";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtiene los datos de la cabecera de una factura específica
function obtenerVentaPorId($idVenta) {
    $conexion = obtenerConexion();
    $sql = "SELECT v.id_ventas, v.fecha, v.total, u.nombre AS cliente, u.email
            FROM ventas v
            JOIN usuarios u ON v.id_user = u.id
            WHERE v.id_ventas = :id_ventas";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id_ventas' => $idVenta]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Obtiene el detalle de renglones/ítems de una factura
function obtenerDetalleItemsVenta($idVenta) {
    $conexion = obtenerConexion();
    $sql = "SELECT i.id_item, i.cantidad, i.precio, p.nombre AS producto
            FROM item i
            JOIN productos p ON i.id_prod = p.id
            WHERE i.id_venta = :id_venta";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id_venta' => $idVenta]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>