<?php
// Punto de entrada único a toda la aplicación
session_start();
require_once 'includes/init.php';

require_once 'config/conexion.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/CatalogoController.php';
require_once 'controllers/VentaController.php';
require_once 'controllers/AdminController.php';

// Definir la acción solicitada por URL (por defecto va al catálogo)
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'catalogo';

switch ($accion) {
    case 'catalogo':
        header("Location: listado.php");
        exit;
    case 'login':
        mostrarLogin();
        break;
    case 'registrar':           
        procesarRegistro();
        break;
    case 'autenticar':
        procesarLogin();
        break;
    case 'logout':
        cerrarSesion();
        break;
    case 'carrito':
        mostrarCarrito();
        break;
    case 'procesar_compra':
        procesarCompra();
        break;
    case 'detalle':
        mostrarDetalleProducto();
        break;
    case 'mis_pedidos':
        mostrarMisPedidos();
        break;
    case 'detalle_pedido':
        verDetallePedidoCliente();
        break;
    case 'mi_perfil':
        mostrarMiPerfil();
        break;
    case 'guardar_perfil':
        procesarGuardarPerfil();
        break;

        // Rutas del Administrador
    case 'admin_ventas':
        listarVentasAdmin();
        break;
    case 'admin_factura':
        verFacturaDetalle();
        break;
    case 'admin_clientes':
        listarClientesAdmin();
        break;
    case 'admin_cliente_crear':
        crearClienteAdmin();
        break;
    case 'admin_cliente_editar':
        editarClienteAdmin();
        break;
    case 'admin_cliente_eliminar':
        borrarClienteAdmin();
        break;
        // ABML Productos 
    case 'admin_productos':
        listarProductosAdmin();
        break;
    case 'admin_prod_crear':
        crearProductoAdmin();
        break;
    case 'admin_prod_editar':
        editarProductoAdmin();
        break;
    case 'admin_prod_eliminar':
        borrarProductoAdmin();
        break;

    default:
        mostrarCatalogo();
        break;
}
