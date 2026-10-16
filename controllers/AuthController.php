<?php
require_once __DIR__ . '/../models/Usuario.php';

// Muestra la vista con el formulario
function mostrarLogin() {
    $error = isset($_GET['error']) ? $_GET['error'] : '';
    $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
    require_once __DIR__ . '/../views/tienda/login.php';
}

// Procesa el formulario de Login
function procesarLogin() {
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

// Procesa el formulario de Registro rápido
function procesarRegistro() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre']);
        $email  = trim($_POST['email']);
        $pass   = trim($_POST['pass']);

        if (empty($nombre) || empty($email) || empty($pass)) {
            header("Location: index.php?accion=login&error=Todos los campos son obligatorios");
            exit;
        }

        $creado = registrarUsuario($nombre, $pass, $email);

        if ($creado) {
            header("Location: index.php?accion=login&mensaje=Cuenta creada con éxito. Ahora podés iniciar sesión");
        } else {
            header("Location: index.php?accion=login&error=El usuario ya existe, elegí otro");
        }
        exit;
    }
}

// Cierra la sesión y redirige al catálogo
function cerrarSesion() {
    session_destroy();
    header("Location: index.php?accion=catalogo");
    exit;
}

// Función auxiliar para proteger rutas de Administrador
function verificarEsAdmin() {
    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
        header("Location: index.php?accion=login&error=Acceso denegado. Se requieren permisos de administrador.");
        exit;
    }
}

function mostrarMiPerfil() {
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
        
        // Actualizamos el nombre en la sesión por si lo cambió
        $_SESSION['nombre'] = $nombre;

        header("Location: index.php?accion=mi_perfil&mensaje=Datos guardados correctamente");
        exit;
    }
}