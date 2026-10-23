<?php 
$tituloPagina = "Gestión de Clientes (ABML)";
include __DIR__ . '/../../includes/head.php';
?>

<?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

<main class="flex-grow-1" style="max-width: 100% !important; margin: 0 !important; padding: 20px 30px;">

    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="row mt-3">
        <!-- COLUMNA IZQUIERDA: ALTA DE NUEVO CLIENTE -->
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="card shadow-sm border p-3">
                <h4 class="mb-3">Alta de Nuevo Cliente</h4>
                <form method="POST" action="index.php?accion=admin_cliente_crear">
                    <div class="mb-2">
                        <label class="form-label fw-bold">Nombre de usuario:</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold">Email:</label>
                        <input type="email" name="email" class="form-control" required placeholder="ejemplo@correo.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contraseña:</label>
                        <input type="password" name="pass" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar Cliente</button>
                </form>
            </div>
        </div>

        <!-- COLUMNA DERECHA: LISTADO Y PAGINADOR -->
        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm border p-3">
                <h4>Clientes Registrados</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover border align-middle mt-2">
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
                                    <td class="text-nowrap">
                                        <a href="index.php?accion=admin_cliente_editar&id=<?php echo $c['id']; ?>" class="btn btn-sm btn-primary">Modificar</a>  
                                        <a href="index.php?accion=admin_cliente_eliminar&id=<?php echo $c['id']; ?>" 
                                           class="btn btn-sm btn-danger text-white" 
                                           style="background-color: #dc3545 !important;"
                                           onclick="return confirm('¿Seguro que querés eliminar este cliente?');">Baja</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- PAGINADOR DE CLIENTES -->
                <?php if ($totalPaginas > 1): ?>
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo ($paginaActual <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="index.php?accion=admin_clientes&p=<?php echo $paginaActual - 1; ?>">« Anterior</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <li class="page-item <?php echo ($i === $paginaActual) ? 'active' : ''; ?>">
                                    <a class="page-link" href="index.php?accion=admin_clientes&p=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo ($paginaActual >= $totalPaginas) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="index.php?accion=admin_clientes&p=<?php echo $paginaActual + 1; ?>">Siguiente »</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php 
include __DIR__ . '/../../includes/footer.php'; 
?>