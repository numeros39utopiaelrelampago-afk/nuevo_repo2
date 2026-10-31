<?php
require_once __DIR__ . '/../models/Usuario.php';

// Muestra la vista con el formulario
function mostrarLogin() {
    $error   = isset($_GET['error']) ? $_GET['error'] : '';
    $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
    require_once __DIR__ . '/../views/tienda/login.php'; 
}

// Procesa el formulario de Login
function procesarLogin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre']);
        $pass   = trim($_POST['pass']);

        if (empty($nombre) || empty($pass)) {
            header("Location: index.php?accion=login&error=Completa todos los campos");
            exit;
        }

        $usuario = obtenerUsuarioPorNombre($nombre);

        // Comprobación doble: primero verifica si es hash; si no, si coincide en texto plano
        $claveValida = false;
        if ($usuario) {
            if (password_verify($pass, $usuario['pass'])) {
                $claveValida = true;
            } elseif ($pass === $usuario['pass']) { // Respaldo para usuarios creados a mano en phpMyAdmin
                $claveValida = true;
            }
        }

        if ($usuario && $claveValida) {
            $_SESSION['id_user'] = $usuario['id'];
            $_SESSION['nombre']  = $usuario['nombre'];
            $_SESSION['tipo']    = $usuario['tipo'];

            if ($usuario['tipo'] === 'admin') {
                header("Location: index.php?accion=admin_ventas");
            } else {
                header("Location: listado.php");
            }
            exit;
        } else {
            header("Location: index.php?accion=login&error=Usuario o contraseña incorrectos");
            exit;
        }
    }
}

// Procesa el formulario de Registro rápido de clientes
function procesarRegistro() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
        $email  = isset($_POST['email']) ? trim($_POST['email']) : '';
        $pass   = isset($_POST['pass']) ? trim($_POST['pass']) : '';

        // 1. Validar campos obligatorios
        if (empty($nombre) || empty($email) || empty($pass)) {
            header("Location: index.php?accion=registro&error=Todos los campos son obligatorios");
            exit;
        }

        // 2. Validar formato estricto de correo
        $patronEmail = '/^[a-zA-Z0-9._%+-]{3,}@[a-zA-Z]{5,}\.com$/i';
        if (!preg_match($patronEmail, $email)) {
            header("Location: index.php?accion=registro&error=" . urlencode("El email debe tener al menos 3 caracteres antes del @, un dominio de mínimo 5 letras y terminar en .com"));
            exit;
        }

        // 3. Registrar al usuario
        registrarUsuario($nombre, $pass, $email);
        header("Location: index.php?accion=login&mensaje=" . urlencode("Cuenta creada con éxito"));
        exit;
    }
}

// Cierra la sesión y redirige al catálogo
function cerrarSesion() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    header("Location: listado.php");
    exit;
}

// Función auxiliar para proteger rutas de Administrador
function verificarEsAdmin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
        header("Location: index.php?accion=login&error=Acceso denegado. Se requieren permisos de administrador.");
        exit;
    }
}

function mostrarMiPerfil() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id_user'])) {
        header("Location: index.php?accion=login");
        exit;
    }

    $id = $_SESSION['id_user'];
    $usuario = obtenerPerfilUsuario($id);
    $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';

    require_once __DIR__ . '/../views/tienda/perfil.php';
}

function procesarGuardarPerfil() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id_user'])) {
        header("Location: index.php?accion=login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id        = $_SESSION['id_user'];
        $nombre    = trim($_POST['nombre']);
        $apellido  = trim($_POST['apellido']);
        $email     = trim($_POST['email']);
        $telefono  = trim($_POST['telefono']);
        $direccion = trim($_POST['direccion']);
        $provincia = trim($_POST['provincia']);
        $ciudad    = trim($_POST['ciudad']);
        $cp        = trim($_POST['codigo_postal']);

        actualizarPerfilCompleto($id, $nombre, $apellido, $email, $telefono, $direccion, $provincia, $ciudad, $cp);
        
        $_SESSION['nombre'] = $nombre;

        header("Location: index.php?accion=mi_perfil&mensaje=Datos guardados correctamente");
        exit;
    }
}