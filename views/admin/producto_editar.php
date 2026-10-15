<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Carta</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

    <main>
        <h2>Modificar Carta #<?php echo $producto['id']; ?></h2>
        
        <form method="POST" action="index.php?accion=admin_prod_editar&id=<?php echo $producto['id']; ?>" style="max-width: 500px;">
            <p>
                <label>Nombre:</label><br>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required style="width: 100%;">
            </p>
            <p>
                <label>Precio ($):</label><br>
                <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required style="width: 100%;">
            </p>
            <p>
                <label>Stock:</label><br>
                <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" required style="width: 100%;">
            </p>
            <p>
                <label>Rareza:</label><br>
                <input type="text" name="rareza" value="<?php echo htmlspecialchars($producto['rareza']); ?>" required style="width: 100%;">
            </p>
            <p>
                <label>Categoría:</label><br>
                <input type="text" name="categoria" value="<?php echo htmlspecialchars($producto['categoria']); ?>" required style="width: 100%;">
            </p>
            <button type="submit">Guardar Cambios</button>
            <a href="index.php?accion=admin_productos">Cancelar</a>
        </form>
    </main>
</body>
</html>