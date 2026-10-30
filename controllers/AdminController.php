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

// Listado
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

// Alta
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

// Modificación
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

// Baja
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

// Listado
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

    // OBTENER LA LISTA DE CATEGORÍAS PARA EL SELECT:
    $listaCategorias = obtenerCategorias();

    $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
    $error   = isset($_GET['error']) ? $_GET['error'] : '';

    require_once __DIR__ . '/../views/admin/productos.php';
}

// Alta
function crearProductoAdmin() {
    verificarEsAdmin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre      = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
        $precio      = isset($_POST['precio']) ? floatval($_POST['precio']) : 0.0;
        $stock       = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
        $rareza      = isset($_POST['rareza']) ? strtoupper(trim($_POST['rareza'])) : '';
        $idCategoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : 0;

        // 1. Obtener y validar categorías contra la base de datos
        $categoriasBD = obtenerCategorias();
        $idsValidos   = array_column($categoriasBD, 'id');

        if (!in_array($idCategoria, $idsValidos, false) || $idCategoria <= 0) {
            header("Location: index.php?accion=admin_productos&error=Categoría no válida");
            exit;
        }

        // 2. Validación de rarezas predeterminadas contra lista blanca
        $rareza = isset($_POST['rareza']) ? strtolower(trim($_POST['rareza'])) : '';

$rarezasValidas = [
    'common', 'rare', 'super', 'ultra', 'secret', 'ultimate', 'ghost',
    'gold', 'platinum', 'prismatic collector', 'prismatic secret', 
    'qcr', 'shatterfoil', 'collector', 'otra'
];

if (!in_array($rareza, $rarezasValidas, true)) {
    // Redirección de error...
}

        // 3. Validación de campos obligatorios, stock no negativo y precio positivo
        if (!empty($nombre) && $precio > 0 && $stock >= 0) {
            crearProducto($nombre, $precio, $stock, $rareza, $idCategoria);
            header("Location: index.php?accion=admin_productos&mensaje=Carta agregada con éxito");
        } else {
            header("Location: index.php?accion=admin_productos&error=Completá todos los campos obligatorios y asegurate de ingresar valores válidos");
        }
        exit;
    }
}

// Cargar la vista de edición (GET)
function editarProductoAdmin() {
    verificarEsAdmin();
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $producto = obtenerProductoPorIdAdmin($id);
    if (!$producto) {
        header("Location: index.php?accion=admin_productos&error=Producto no encontrado");
        exit;
    }

    // Traer la lista de categorías para el desplegable
    $listaCategorias = obtenerCategorias();

    require_once __DIR__ . '/../views/admin/producto_editar.php';
}

// Modificación 
// Modificación 
// Modificación 
function modificarProductoAdmin() {
    verificarEsAdmin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id          = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $nombre      = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
        $precio      = isset($_POST['precio']) ? floatval($_POST['precio']) : 0.0;
        $stock       = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
        $rareza      = isset($_POST['rareza']) ? strtoupper(trim($_POST['rareza'])) : '';
        $idCategoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : 0;

        // 1. Validar que el ID del producto sea válido
        if ($id <= 0) {
            header("Location: index.php?accion=admin_productos&error=ID de producto inválido");
            exit;
        }

        // 2. Validar campos requeridos básicos
        if (empty($nombre) || empty($rareza) || empty($idCategoria)) {
            header("Location: index.php?accion=admin_prod_editar&id={$id}&error=Todos los campos de texto son obligatorios");
            exit;
        }

        // 3. Validar precio y stock numéricos
        if ($precio <= 0) {
            header("Location: index.php?accion=admin_prod_editar&id={$id}&error=El precio debe ser un valor positivo mayor a 0");
            exit;
        }

        if ($stock < 0) {
            header("Location: index.php?accion=admin_prod_editar&id={$id}&error=El stock no puede ser un número negativo");
            exit;
        }

        // 4. Validar categoría contra la base de datos
        $categoriasBD = obtenerCategorias();
        $idsValidos   = array_column($categoriasBD, 'id');

        if (!in_array($idCategoria, $idsValidos, false)) {
            header("Location: index.php?accion=admin_prod_editar&id={$id}&error=Categoría no válida");
            exit;
        }

        // 5. Validar rareza contra lista blanca estricta
        $rarezasValidas = [
            'COMMON', 'RARE', 'SUPER', 'ULTRA', 'SECRET', 'ULTIMATE', 
            'GOLD', 'PLATINUM', 'PRISMATIC COLLECTOR', 'PRISMATIC SECRET', 
            'QCR', 'SHATTERFOIL', 'COLLECTOR', 'OTRA'
        ];

        if (!in_array($rareza, $rarezasValidas, true)) {
            header("Location: index.php?accion=admin_prod_editar&id={$id}&error=Rareza no válida seleccionada");
            exit;
        }

        // Si pasa todas las validaciones, actualiza en la base de datos
        actualizarProducto($id, $nombre, $precio, $stock, $rareza, $idCategoria);
        header("Location: index.php?accion=admin_productos&mensaje=Producto modificado con éxito");
        exit;
    }
}

// Baja
function borrarProductoAdmin() {
    verificarEsAdmin();
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        eliminarProducto($id);
    }
    header("Location: index.php?accion=admin_productos&mensaje=Producto eliminado");
    exit;
}