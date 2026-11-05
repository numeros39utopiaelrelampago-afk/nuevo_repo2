<?php
require_once __DIR__ . '/../config/conexion.php'; 

function registrarVentaCompleta($idUsuario, $itemsCarrito) {
    $conexion = obtenerConexion();

    try {
        $conexion->beginTransaction();

        $totalGeneral = 0;
        foreach ($itemsCarrito as $item) {
            $stmt = $conexion->prepare("SELECT precio, stock FROM productos WHERE id = :id FOR UPDATE");
            $stmt->execute([':id' => $item['id']]);
            $prodBd = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$prodBd) {
                throw new Exception("El producto ID " . $item['id'] . " ya no existe.");
            }

            if ($prodBd['stock'] < $item['cantidad']) {
                throw new Exception("Stock insuficiente para: " . $item['nombre']);
            }

            $totalGeneral += floatval($prodBd['precio']) * intval($item['cantidad']);
        }

        $stmtVenta = $conexion->prepare("INSERT INTO ventas (id_user, total, fecha) VALUES (:id_user, :total, NOW())");
        $stmtVenta->execute([
            ':id_user' => $idUsuario,
            ':total'      => $totalGeneral
        ]);

        $idVenta = $conexion->lastInsertId();

        $stmtItem = $conexion->prepare("INSERT INTO items (id_venta, id_prod, cantidad, precio) VALUES (:id_venta, :id_prod, :cantidad, :precio)");
        $stmtStock = $conexion->prepare("UPDATE productos SET stock = stock - :cantidad WHERE id = :id");

        foreach ($itemsCarrito as $item) {
            $stmtItem->execute([
                ':id_venta' => $idVenta,
                ':id_prod'  => $item['id'],
                ':cantidad' => $item['cantidad'],
                ':precio'   => $item['precio']
            ]);

            $stmtStock->execute([
                ':cantidad' => $item['cantidad'],
                ':id'       => $item['id']
            ]);
        }

        $conexion->commit();
        return $idVenta;

    } catch (Exception $e) {
        $conexion->rollBack();
        return false;
    }
}

function obtenerTodasLasVentas() {
    $conexion = obtenerConexion();
    $sql = "SELECT v.id_ventas, v.fecha, v.total, u.nombre AS cliente, u.email
            FROM ventas v
            JOIN usuarios u ON v.id_user = u.id
            ORDER BY v.id_ventas DESC";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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

function obtenerDetalleItemsVenta($idVenta) {
    $conexion = obtenerConexion();
    $sql = "SELECT i.id_item, i.cantidad, i.precio, p.nombre AS producto
            FROM items i
            JOIN productos p ON i.id_prod = p.id
            WHERE i.id_venta = :id_venta";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id_venta' => $idVenta]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerVentasPorCliente($idUser) {
    $conexion = obtenerConexion();
    $sql = "SELECT id_ventas, fecha, total 
            FROM ventas 
            WHERE id_user = :id_user 
            ORDER BY id_ventas DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id_user' => $idUser]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerVentaClientePorId($idVenta, $idUser) {
    $conexion = obtenerConexion();
    $sql = "SELECT id_ventas, fecha, total 
            FROM ventas 
            WHERE id_ventas = :id_ventas AND id_user = :id_user 
            LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':id_ventas' => $idVenta,
        ':id_user'   => $idUser
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>