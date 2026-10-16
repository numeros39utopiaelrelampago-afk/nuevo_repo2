<?php
require_once __DIR__ . '/../models/Venta.php';

function finalizarCompra() {
    // 1. Verificar que el usuario tenga sesión iniciada
    if (!isset($_SESSION['id_user'])) {
        header("Location: index.php?accion=login&error=Inicia sesion para finalizar la compra");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 2. Tomar el texto JSON enviado desde el input hidden del carrito
        $carritoJson = isset($_POST['carrito_datos']) ? $_POST['carrito_datos'] : '';
        $items = json_decode($carritoJson, true);

        // 3. Validar que no venga vacío o malformado
        if (empty($items) || !is_array($items)) {
            header("Location: index.php?accion=carrito&error=El carrito esta vacio");
            exit;
        }

        $idUsuario = $_SESSION['id_user'];

        // 4. Delegar la inserción en base de datos al Modelo
        $idVenta = registrarVentaCompleta($idUsuario, $items);

        if ($idVenta) {
            // Guardamos el ID de la venta en una variable para la vista
            require_once __DIR__ . '/../views/tienda/compra_exitosa.php';
        } else {
            header("Location: index.php?accion=carrito&error=Ocurrio un error al procesar la venta");
        }
        exit;
    }

    header("Location: index.php?accion=catalogo");
    exit;
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