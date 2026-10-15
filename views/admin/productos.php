<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Cartas</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

    <main>
        <h2>Inventario de productos TCG</h2>

        <?php if (!empty($mensaje)): ?>
            <p style="color: green;"><strong><?php echo htmlspecialchars($mensaje); ?></strong></p>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><strong><?php echo htmlspecialchars($error); ?></strong></p>
        <?php endif; ?>

        <!-- FORMULARIO DE ALTA -->
        <fieldset style="max-width: 600px; margin-bottom: 25px; padding: 15px; background: white;">
            <legend><strong>Cargar Nuevo producto</strong></legend>
            <form method="POST" action="index.php?accion=admin_prod_crear">
                <p>
                    <label>Nombre:</label><br>
                    <input type="text" name="nombre" placeholder="Ej: forbidden droplet..." required style="width: 90%;">
                </p>
                <p>
                    <label>Precio ($):</label><br>
                    <input type="number" step="0.01" name="precio" required style="width: 90%;">
                </p>
                <p>
                    <label>Stock inicial:</label><br>
                    <input type="number" name="stock" value="1" required style="width: 90%;">
                </p>
                <p>
                    <label>Rareza:</label><br>
                    <input type="text" name="rareza" placeholder="Ej: ultra, secret, super..." required style="width: 90%;">
                </p>
                <p>
                    <label>Categoría:</label><br>
                    <input type="text" name="categoria" value="cartas sueltas" required style="width: 90%;">
                </p>
                <button type="submit">Agregar producto</button>
            </form>
        </fieldset>

        <!-- LISTADO DE CARTAS -->
        <h3>Listado General de Stock</h3>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Rareza</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr <?php echo ($p['stock'] == 0) ? 'style="background-color: #ffebee;"' : ''; ?>>
                        <td><?php echo $p['id']; ?></td>
                        <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                        <td>$<?php echo number_format($p['precio'], 2); ?></td>
                        <td>
                            <strong><?php echo $p['stock']; ?></strong>
                            <?php if ($p['stock'] == 0): ?>
                                <span style="color: red; font-size: 11px;">(Agotado)</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-transform: uppercase;"><?php echo htmlspecialchars($p['rareza']); ?></td>
                        <td><?php echo htmlspecialchars($p['categoria']); ?></td>
                        <td>
                            <a href="index.php?accion=admin_prod_editar&id=<?php echo $p['id']; ?>">Modificar</a> | 
                            <a href="index.php?accion=admin_prod_eliminar&id=<?php echo $p['id']; ?>" 
                               onclick="return confirm('¿Seguro que querés eliminar esta carta?');">Baja</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>