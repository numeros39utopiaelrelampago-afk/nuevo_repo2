<?php 
$tituloPagina = "Gestión de Clientes (ABML)";
include __DIR__ . '/../../includes/head.php';
?>

<?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

<main>

    <?php if (!empty($mensaje)): ?>
        <p style="color: green;"><strong><?php echo htmlspecialchars($mensaje); ?></strong></p>
    <?php endif; ?>

    <!-- ALTA: FORMULARIO PARA REGISTRAR NUEVO CLIENTE -->
    <fieldset style="max-width: 500px; margin-bottom: 25px;">
        <legend><strong>Alta de Nuevo Cliente</strong></legend>
        <form method="POST" action="index.php?accion=admin_cliente_crear">
            <p>Usuario: <input type="text" name="nombre" required></p>
            <p>Email: <input type="email" name="email" required placeholder="ejemplo@correo.com">
            <p>Contraseña: <input type="password" name="pass" required></p>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </fieldset>

    <!-- LISTADO, MODIFICACIÓN Y BAJA -->
    <legend><strong>Clientes Registrados</strong></legend>
    <table class="table table-striped table-hover border">
        <thead class="table-dark">
            <tr>
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
    <a href="index.php?accion=admin_cliente_editar&id=<?php echo $c['id']; ?>" class="btn btn-sm btn-primary">Modificar</a>  
    <a href="index.php?accion=admin_cliente_eliminar&id=<?php echo $c['id']; ?>" 
       class="btn btn-sm btn-danger text-white" 
       style="background-color: #dc3545;" 
       onclick="return confirm('¿Eliminar cliente?');">Baja</a>
</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php 
include __DIR__ . '/../../includes/footer.php'; 
?>