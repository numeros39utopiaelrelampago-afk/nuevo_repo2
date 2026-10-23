<?php
require_once __DIR__ . '/../models/Producto.php';
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

    $porPagina = 10;
    $paginaActual = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;

    $totalClientes = contarTotalClientesAdmin();
    $totalPaginas  = ceil($totalClientes / $porPagina);
    if ($totalPaginas < 1) $totalPaginas = 1;

    if ($paginaActual > $totalPaginas) {
        $paginaActual = $totalPaginas;
    }

    $offset = ($paginaActual - 1) * $porPagina;
    $clientes = obtenerClientesPaginadosAdmin($porPagina, $offset);

    $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
    $error   = isset($_GET['error']) ? $_GET['error'] : '';

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

// ==========================================
// SECCIÓN: ABML PRODUCTOS
// ==========================================

// Listado (L)
function listarProductosAdmin() {
    verificarEsAdmin();

    $porPagina = 10;
    $paginaActual = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;

    $totalProductos = contarTotalProductosAdmin();
    $totalPaginas   = ceil($totalProductos / $porPagina);
    if ($totalPaginas < 1) $totalPaginas = 1;

    if ($paginaActual > $totalPaginas) {
        $paginaActual = $totalPaginas;
    }

    $offset = ($paginaActual - 1) * $porPagina;
    $productos = obtenerProductosPaginadosAdmin($porPagina, $offset);

    $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
    $error   = isset($_GET['error']) ? $_GET['error'] : '';

    require_once __DIR__ . '/../views/admin/productos.php';
}

// Alta (A)[cite: 2, 6]
function crearProductoAdmin() {
    verificarEsAdmin();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre    = trim($_POST['nombre']);
        $precio    = floatval($_POST['precio']);
        $stock     = intval($_POST['stock']);
        $rareza    = trim($_POST['rareza']);
        $categoria = trim($_POST['categoria']);

        if (!empty($nombre) && $precio > 0 && !empty($categoria)) {
            crearProducto($nombre, $precio, $stock, $rareza, $categoria);
            header("Location: index.php?accion=admin_productos&mensaje=Carta agregada con éxito");
        } else {
            header("Location: index.php?accion=admin_productos&error=Completá todos los campos obligatorios");
        }
        exit;
    }
}

// Modificación (M)[cite: 2, 6]
function editarProductoAdmin() {
    verificarEsAdmin();
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre    = trim($_POST['nombre']);
        $precio    = floatval($_POST['precio']);
        $stock     = intval($_POST['stock']);
        $rareza    = trim($_POST['rareza']);
        $categoria = trim($_POST['categoria']);

        // 1. Validar campos de texto requeridos
        if (empty($nombre) || empty($rareza) || empty($categoria)) {
            header("Location: index.php?accion=admin_prod_editar&id=$id&error=Todos los campos de texto son obligatorios");
            exit;
        }

        // 2. Validar que el precio sea estrictamente mayor a 0
        if ($precio <= 0) {
            header("Location: index.php?accion=admin_prod_editar&id=$id&error=El precio debe ser un valor positivo mayor a 0");
            exit;
        }

        // 3. Validar que el stock sea 0 o mayor (sin números negativos)
        if ($stock < 0) {
            header("Location: index.php?accion=admin_prod_editar&id=$id&error=El stock no puede ser un número negativo");
            exit;
        }

        // Si pasa todas las validaciones, actualizamos en la base de datos
        actualizarProducto($id, $nombre, $precio, $stock, $rareza, $categoria);
        header("Location: index.php?accion=admin_productos&mensaje=Carta modificada con éxito");
        exit;
    }

    $conexion = obtenerConexion();
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        header("Location: index.php?accion=admin_productos");
        exit;
    }

    $error = isset($_GET['error']) ? $_GET['error'] : '';
    require_once __DIR__ . '/../views/admin/producto_editar.php';
}
// Baja (B)[cite: 2]
function borrarProductoAdmin() {
    verificarEsAdmin();
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        eliminarProducto($id);
    }
    header("Location: index.php?accion=admin_productos&mensaje=Producto eliminado");
    exit;
}