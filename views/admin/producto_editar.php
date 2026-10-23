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
                <label class="form-label fw-bold">Categoría:</label><br>
                <select name="categoria" class="form-select" required style="width: 100%;">
                    <option value="cartas sueltas" <?php echo ($producto['categoria'] === 'cartas sueltas') ? 'selected' : ''; ?>>Cartas sueltas</option>
                    <option value="cartas OCG" <?php echo ($producto['categoria'] === 'cartas OCG') ? 'selected' : ''; ?>>Cartas OCG</option>
                    <option value="binders" <?php echo ($producto['categoria'] === 'binders') ? 'selected' : ''; ?>>Binders</option>
                    <option value="deckbox" <?php echo ($producto['categoria'] === 'deckbox') ? 'selected' : ''; ?>>Deckbox</option>
                    <option value="lotes" <?php echo ($producto['categoria'] === 'lotes') ? 'selected' : ''; ?>>Lotes</option>
                    <option value="playmats" <?php echo ($producto['categoria'] === 'playmats') ? 'selected' : ''; ?>>Playmats</option>
                    <option value="tins" <?php echo ($producto['categoria'] === 'tins') ? 'selected' : ''; ?>>Tins</option>
                </select>
            </p>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="index.php?accion=admin_productos" class="btn btn-primary">Cancelar</a>
        </form>
    </main>

    <?php 
include __DIR__ . '/../../includes/footer.php'; 
?>
