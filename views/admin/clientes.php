<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes (ABML)</title>
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

    <h2>Gestión de Clientes (ABML)</h2>

    <?php if (!empty($mensaje)): ?>
        <p style="color: green;"><strong><?php echo htmlspecialchars($mensaje); ?></strong></p>
    <?php endif; ?>

    <!-- ALTA: FORMULARIO PARA REGISTRAR NUEVO CLIENTE -->
    <fieldset style="max-width: 500px; margin-bottom: 25px;">
        <legend><strong>Alta de Nuevo Cliente</strong></legend>
        <form method="POST" action="index.php?accion=admin_cliente_crear">
            <p>Usuario: <input type="text" name="nombre" required></p>
            <p>Email: <input type="text" name="email" required></p>
            <p>Contraseña: <input type="password" name="pass" required></p>
            <button type="submit">Dar de Alta</button>
        </form>
    </fieldset>

    <!-- LISTADO, MODIFICACIÓN Y BAJA -->
    <h3>Clientes Registrados</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #eee;">
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $c): ?>
                <tr>
                    <td><?php echo $c['id']; ?></td>
                    <td><?php echo htmlspecialchars($c['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($c['email']); ?></td>
                    <td>
                        <a href="index.php?accion=admin_cliente_editar&id=<?php echo $c['id']; ?>">Modificar</a> | 
                        <a href="index.php?accion=admin_cliente_eliminar&id=<?php echo $c['id']; ?>" 
                           onclick="return confirm('¿Seguro que querés eliminar este cliente?');">Baja</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>