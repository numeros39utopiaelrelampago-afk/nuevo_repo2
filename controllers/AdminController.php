<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Venta.php';

// ==========================================
// SECCIÓN: VENTAS Y FACTURAS
// ==========================================

function listarVentasAdmin() {
    verificarEsAdmin();
    $ventas = obtenerTodasLasVentas();
    require_once __DIR__ . '/../views/admin/ventas.php';
}

function verFacturaDetalle() {
    verificarEsAdmin();
    $idVenta = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $factura = obtenerVentaPorId($idVenta);
    if (!$factura) {
        header("Location: index.php?accion=admin_ventas");
        exit;
    }

    $items = obtenerDetalleItemsVenta($idVenta);
    require_once __DIR__ . '/../views/admin/factura_detalle.php';
}

// ==========================================
// SECCIÓN: ABML CLIENTES
// ==========================================

// Listado (L)
function listarClientesAdmin() {
    verificarEsAdmin();
    $clientes = obtenerTodosLosClientes();
    $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
    $error = isset($_GET['error']) ? $_GET['error'] : '';
    require_once __DIR__ . '/../views/admin/clientes.php';
}

// Alta (A)
function crearClienteAdmin() {
    verificarEsAdmin();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre']);
        $email  = trim($_POST['email']);
        $pass   = trim($_POST['pass']);

        if (!empty($nombre) && !empty($email) && !empty($pass)) {
            registrarUsuario($nombre, $pass, $email);
            header("Location: index.php?accion=admin_clientes&mensaje=Cliente agregado con exito");
        } else {
            header("Location: index.php?accion=admin_clientes&error=Todos los campos son obligatorios");
        }
        exit;
    }
}

// Modificación (M)
function editarClienteAdmin() {
    verificarEsAdmin();
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre']);
        $email  = trim($_POST['email']);
        actualizarCliente($id, $nombre, $email);
        header("Location: index.php?accion=admin_clientes&mensaje=Cliente modificado con exito");
        exit;
    }

    $cliente = obtenerClientePorId($id);
    if (!$cliente) {
        header("Location: index.php?accion=admin_clientes");
        exit;
    }
    require_once __DIR__ . '/../views/admin/cliente_editar.php';
}

// Baja (B)
function borrarClienteAdmin() {
    verificarEsAdmin();
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        eliminarCliente($id);
    }
    header("Location: index.php?accion=admin_clientes&mensaje=Cliente eliminado");
    exit;
}