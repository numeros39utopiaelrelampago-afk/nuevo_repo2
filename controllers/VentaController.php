<?php
require_once __DIR__ . '/../models/Venta.php';

function procesarCompra() {
    // 1. Verificar sesión activa
    if (!isset($_SESSION['id_user'])) {
        header("Location: index.php?accion=login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idUsuario = $_SESSION['id_user'];
        $datosJson = isset($_POST['carrito_datos']) ? $_POST['carrito_datos'] : '[]';
        $items = json_decode($datosJson, true);

        if (empty($items) || !is_array($items)) {
            header("Location: index.php?accion=carrito&error=El carrito está vacío");
            exit;
        }

        $idVenta = registrarVentaCompleta($idUsuario, $items);

        if ($idVenta) {
            // Vaciar el carrito de este usuario en localStorage y redirigir
            $claveStorage = 'carrito_' . $idUsuario;
            echo "<!DOCTYPE html>
            <html lang='es'>
            <head><meta charset='UTF-8'></head>
            <body>
                <script>
                    localStorage.removeItem('{$claveStorage}');
                    alert('¡Compra #{$idVenta} confirmada con éxito!');
                    window.location.href = 'index.php?accion=historial_pedidos&mensaje=Compra exitosa';
                </script>
            </body>
            </html>";
            exit;
        } else {
            header("Location: index.php?accion=carrito&error=Hubo un problema al procesar la compra o no hay stock disponible");
            exit;
        }
    }
}

// Muestra el listado de compras realizadas por el cliente logueado
function mostrarMisPedidos() {
    if (!isset($_SESSION['id_user'])) {
        header("Location: index.php?accion=login&error=Inicia sesión para ver tus pedidos");
        exit;
    }

    $idUser = $_SESSION['id_user'];
    $pedidos = obtenerVentasPorCliente($idUser);

    require_once __DIR__ . '/../views/tienda/mis_pedidos.php';
}

// Muestra el detalle / comprobante de una compra específica
function verDetallePedidoCliente() {
    if (!isset($_SESSION['id_user'])) {
        header("Location: index.php?accion=login");
        exit;
    }

    $idUser = $_SESSION['id_user'];
    $idVenta = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Buscamos la venta validando que pertenezca al usuario en sesión por seguridad
    $pedido = obtenerVentaClientePorId($idVenta, $idUser);

    if (!$pedido) {
        header("Location: index.php?accion=mis_pedidos");
        exit;
    }

    $items = obtenerDetalleItemsVenta($idVenta);

    require_once __DIR__ . '/../views/tienda/pedido_detalle.php';
}