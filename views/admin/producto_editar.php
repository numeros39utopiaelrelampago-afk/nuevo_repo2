<?php 
$tituloPagina = "Modificar producto";
include __DIR__ . '/../../includes/head.php';
?>

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
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="index.php?accion=admin_productos" class="btn btn-primary">Cancelar</a>
        </form>
    </main>

    <?php 
include __DIR__ . '/../../includes/footer.php'; 
?>
