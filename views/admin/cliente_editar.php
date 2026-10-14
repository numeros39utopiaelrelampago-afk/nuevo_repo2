<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Cliente</title>
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

    <h2>Modificar Cliente #<?php echo $cliente['id']; ?></h2>
    <form method="POST" action="index.php?accion=admin_cliente_editar&id=<?php echo $cliente['id']; ?>">
        <p>Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required></p>
        <p>Email: <input type="text" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required></p>
        <button type="submit">Guardar Cambios</button>
        <a href="index.php?accion=admin_clientes">Cancelar</a>
    </form>
</body>
</html>