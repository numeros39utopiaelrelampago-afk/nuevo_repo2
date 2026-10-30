<?php 
$tituloPagina = "Modificar producto";
include __DIR__ . '/../../includes/head.php';
?>

    <?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

    <main>
        <h2>Modificar Producto #<?php echo $producto['id']; ?></h2>

        <?php if (!empty($error)): ?>
    <div class="alert alert-danger" style="max-width: 500px;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>
        
        <form method="POST" action="index.php?accion=admin_prod_editar&id=<?php echo $producto['id']; ?>" style="max-width: 500px;">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">
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
                <label for="rareza" class="form-label">Rareza:</label>
    <select name="rareza" id="rareza" class="form-select" required>
        <option value="">Seleccione una rareza</option>
        <?php 
        $listaRarezasOpciones = [
            'COMMON', 'RARE', 'SUPER', 'ULTRA', 'SECRET', 'ULTIMATE', 'GHOST', 
            'GOLD', 'PLATINUM', 'PRISMATIC COLLECTOR', 'PRISMATIC SECRET', 
            'QCR', 'SHATTERFOIL', 'COLLECTOR', 'OTRA'
        ];
        foreach ($listaRarezasOpciones as $r): 
        ?>
            <option value="<?php echo strtolower($r); ?>" <?php echo (strtoupper($producto['rareza']) === $r) ? 'selected' : ''; ?>>
    <?php echo ucwords(strtolower($r)); ?>
</option>
        <?php endforeach; ?>
    </select>
            </p>

            <p>
                <label for="categoria" class="form-label">Categoría:</label>
    <select name="categoria" id="categoria" class="form-select" required>
        <option value="">Seleccione una categoría</option>
        <?php foreach ($listaCategorias as $cat): ?>
            <option value="<?php echo $cat['id']; ?>" 
                <?php echo ($cat['id'] == $producto['id_categoria']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cat['nombre']); ?>
            </option>
        <?php endforeach; ?>
    </select>
            </p>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="index.php?accion=admin_productos" class="btn btn-primary">Cancelar</a>
        </form>
    </main>

    <?php 
include __DIR__ . '/../../includes/footer.php'; 
?>
