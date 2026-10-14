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
        $pass = trim($_POST['pass']);

        if (empty($nombre) || empty($pass)) {
            header("Location: index.php?accion=login&error=Completa todos los campos");
            exit;
        }

        $usuario = obtenerUsuarioPorNombre($nombre);

        // Verificamos credenciales con password_verify
        if ($usuario && password_verify($pass, $usuario['pass'])) {
            // Guardamos datos clave en la sesión
            $_SESSION['id_user'] = $usuario['id'];
            $_SESSION['nombre']  = $usuario['nombre'];
            $_SESSION['tipo']    = $usuario['tipo']; // 'cliente' o 'admin'

            // Redirección diferenciada por rol
            if ($usuario['tipo'] === 'admin') {
                header("Location: index.php?accion=admin_ventas");
            } else {
                // El cliente vuelve a su carrito o al catálogo
                header("Location: index.php?accion=carrito");
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