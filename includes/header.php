<header>
    <a href="listado.php" class="logo-link" title="Volver al inicio">
        <img src="assets/img/logo.jpg" alt="Store of Ragnarok" class="logo-tienda">
    </a>
    <nav>
    <a href="index.php?accion=carrito">Carrito (<span id="cantidad-carrito">0</span>)</a>
<?php if (isset($_SESSION['id_user'])): ?>
            <!-- Menú desplegable del usuario -->
            <div class="usuario-dropdown">
                <span class="usuario-btn">Hola, <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong> ▾</span>
                <div class="dropdown-contenido">
                    <a href="index.php?accion=mi_perfil">Ver o editar datos</a>
                    <a href="index.php?accion=mis_pedidos">Ver pedidos realizados</a>
                </div>
            </div>

            <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin'): ?>
                <a href="index.php?accion=admin_ventas" style="color: #554d35;">Panel Admin</a>
            <?php endif; ?>

            <a href="index.php?accion=logout">Cerrar Sesión</a>
        <?php else: ?>
            <a href="index.php?accion=login">Ingresar / Registro</a>
        <?php endif; ?>
    </nav>
</header>
<main>