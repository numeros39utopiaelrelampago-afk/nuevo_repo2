<header>
    <h1>Store of Ragnarok</h1>
    <nav>
    <a href="listado.php">Catálogo</a>
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