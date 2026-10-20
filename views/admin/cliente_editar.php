<?php 
$tituloPagina = "Modificar cliente";
include __DIR__ . '/../../includes/head.php';
?>

<main>
    <?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

    <h2>Modificar Cliente #<?php echo $cliente['id']; ?></h2>
    <form method="POST" action="index.php?accion=admin_cliente_editar&id=<?php echo $cliente['id']; ?>">
        <p>Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required></p>
        <p>Email: <input type="text" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required></p>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php?accion=admin_clientes">Cancelar</a>
    </form>
</main>

    <?php 
include __DIR__ . '/../../includes/footer.php'; 
?>