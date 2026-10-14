<?php

function obtenerConexion() {
    $host = "127.0.0.1";
    $dbname = "e-commerce";
    $user = "root";
    $password = "";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

?>


