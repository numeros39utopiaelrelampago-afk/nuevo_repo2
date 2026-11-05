<?php
require_once __DIR__ . '/../config/conexion.php';

// Busca un usuario por su nombre para el login
function obtenerUsuarioPorNombre($nombre) {
    $conexion = obtenerConexion();
    $sql = "SELECT id, nombre, pass, email, tipo FROM usuarios WHERE nombre = :nombre LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':nombre' => $nombre]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function registrarUsuario($nombre, $pass, $email) {
    $conexion = obtenerConexion();

    $sqlCheck = "SELECT id FROM usuarios WHERE nombre = :nombre LIMIT 1";
    $check = $conexion->prepare($sqlCheck);
    $check->execute([':nombre' => $nombre]);
    if ($check->fetch()) {
        return false; 
    }

    $passHash = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, pass, email, tipo) VALUES (:nombre, :pass, :email, 'cliente')";
    $stmt = $conexion->prepare($sql);
    return $stmt->execute([
        ':nombre' => $nombre,
        ':pass'   => $passHash,
        ':email'  => $email
    ]);
}

// Listar únicamente los usuarios que sean clientes
function obtenerTodosLosClientes() {
    $conexion = obtenerConexion();
    $sql = "SELECT id, nombre, email, tipo FROM usuarios WHERE tipo = 'cliente' ORDER BY id DESC";
    $stmt = $conexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener cliente por ID (para editar)
function obtenerClientePorId($id) {
    $conexion = obtenerConexion();
    $sql = "SELECT id, nombre, email, tipo FROM usuarios WHERE id = :id AND tipo = 'cliente'";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function actualizarCliente($id, $nombre, $email) {
    $conexion = obtenerConexion();
    $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id AND tipo = 'cliente'";
    $stmt = $conexion->prepare($sql);
    return $stmt->execute([
        ':nombre' => $nombre,
        ':email'  => $email,
        ':id'     => $id
    ]);
}

function eliminarCliente($id) {
    $conexion = obtenerConexion();
    $sql = "DELETE FROM usuarios WHERE id = :id AND tipo = 'cliente'";
    $stmt = $conexion->prepare($sql);
    return $stmt->execute([':id' => $id]);
}

function obtenerPerfilUsuario($id) {
    $conexion = obtenerConexion();
    $sql = "SELECT id, nombre, apellido, email, telefono, direccion, provincia, ciudad, codigo_postal 
            FROM usuarios WHERE id = :id LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function actualizarPerfilCompleto($id, $nombre, $apellido, $email, $telefono, $direccion, $provincia, $ciudad, $cp) {
    $conexion = obtenerConexion();
    $sql = "UPDATE usuarios SET 
                nombre = :nombre,
                apellido = :apellido,
                email = :email,
                telefono = :telefono,
                direccion = :direccion,
                provincia = :provincia,
                ciudad = :ciudad,
                codigo_postal = :cp
            WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    return $stmt->execute([
        ':nombre'    => $nombre,
        ':apellido'  => $apellido,
        ':email'     => $email,
        ':telefono'  => $telefono,
        ':direccion' => $direccion,
        ':provincia' => $provincia,
        ':ciudad'    => $ciudad,
        ':cp'        => $cp,
        ':id'        => $id
    ]);
}

function contarTotalClientesAdmin() {
    $conexion = obtenerConexion();
    $stmt = $conexion->query("SELECT COUNT(*) as total FROM usuarios");
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    return intval($fila['total']);
}

function obtenerClientesPaginadosAdmin($limite = 10, $offset = 0) {
    $conexion = obtenerConexion();
    $sql = "SELECT id, nombre, email FROM usuarios ORDER BY id DESC LIMIT :limite OFFSET :offset";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}