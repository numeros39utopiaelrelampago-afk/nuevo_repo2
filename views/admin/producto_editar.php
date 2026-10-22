<?php 
$tituloPagina = "Modificar producto";
include __DIR__ . '/../../includes/head.php';
?>

    <?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

    <main>
        <h2>Modificar Carta #<?php echo $producto['id']; ?></h2>

        <?php if (!empty($error)): ?>
    <div class="alert alert-danger" style="max-width: 500px;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>
        
        <form method="POST" action="index.php?accion=admin_prod_editar&id=<?php echo $producto['id']; ?>" style="max-width: 500px;">
            <p>
                <label>Nombre:</label><br>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required style="width: 100%;">
            </p>

            <p>
                <label>Precio ($):</label><br>
                    <input type="number" 
                    name="precio" 
                    step="0.01" 
                    min="0.01" 
                    value="<?php echo htmlspecialchars($producto['precio']); ?>" 
                    required 
                    style="width: 100%;">
                <small class="text-muted">Debe ser mayor a $0.00</small>
            </p>

            <p>
                <label>Stock:</label><br>
                    <input type="number" 
                    name="stock" 
                    step="1" 
                    min="0" 
                    value="<?php echo htmlspecialchars($producto['stock']); ?>" 
                    required 
                    style="width: 100%;">
                <small class="text-muted">No puede ser negativo (0 = agotado)</small>
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
