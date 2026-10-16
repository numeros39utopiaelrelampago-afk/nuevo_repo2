<header>
    <a href="listado.php" class="logo-link" title="Volver al inicio">
        <img src="assets/img/logo.jpg" alt="Logo Tienda" class="logo-tienda">
    </a>
    <nav>
    <a href="index.php?accion=carrito">Carrito (<span id="cantidad-carrito">0</span>)</a>
<?php if (isset($_SESSION['id_user'])): ?>
            <span>Hola, <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong></span>
            
            <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin'): ?>
                <a href="index.php?accion=admin_ventas" style="color: #ffc107;">Panel Admin</a>
            <?php endif; ?>

            <a href="index.php?accion=logout">Cerrar Sesión</a>
        <?php else: ?>
            <a href="index.php?accion=login">Ingresar / Registro</a>
        <?php endif; ?>
    </nav>
</header>
<main>