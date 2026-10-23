<?php 
$tituloPagina = "Inventario";
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
        <!-- COLUMNA IZQUIERDA: FORMULARIO DE ALTA -->
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="card shadow-sm border p-3">
                <h4 class="mb-3">Cargar Nuevo Producto</h4>
                <form method="POST" action="index.php?accion=admin_prod_crear">
                    <div class="mb-2">
                        <label class="form-label fw-bold">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: forbidden droplet..." required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold">Precio ($):</label>
                        <input type="number" step="0.01" min="0.01" name="precio" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold">Stock inicial:</label>
                        <input type="number" step="1" min="0" name="stock" value="1" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold">Rareza:</label>
                        <input type="text" name="rareza" class="form-control" placeholder="Ej: ultra, secret..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Categoría:</label>
                        <input type="text" name="categoria" value="cartas sueltas" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Agregar Producto</button>
                </form>
            </div>
        </div>

        <!-- COLUMNA DERECHA: LISTADO Y PAGINADOR -->
        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm border p-3">
                <h4>Listado de Stock</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover border align-middle mt-2">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Rareza</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $p): ?>
                                <tr <?php echo ($p['stock'] == 0) ? 'style="background-color: #ffebee;"' : ''; ?>>
                                    <td><?php echo $p['id']; ?></td>
                                    <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                                    <td>$<?php echo number_format($p['precio'], 2); ?></td>
                                    <td>
                                        <strong><?php echo $p['stock']; ?></strong>
                                        <?php if ($p['stock'] == 0): ?>
                                            <span class="text-danger small">(Agotado)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-uppercase"><?php echo htmlspecialchars($p['rareza']); ?></td>
                                    <td><?php echo htmlspecialchars($p['categoria']); ?></td>
                                    <td class="text-nowrap">
                                        <a href="index.php?accion=admin_prod_editar&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-primary">Modificar</a>  
                                        <a href="index.php?accion=admin_prod_eliminar&id=<?php echo $p['id']; ?>" 
                                           class="btn btn-sm btn-danger text-white" 
                                           style="background-color: #dc3545 !important;"
                                           onclick="return confirm('¿Seguro que querés eliminar esta carta?');">Baja</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- PAGINADOR DEL INVENTARIO -->
                <?php if ($totalPaginas > 1): ?>
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo ($paginaActual <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="index.php?accion=admin_productos&p=<?php echo $paginaActual - 1; ?>">« Anterior</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <li class="page-item <?php echo ($i === $paginaActual) ? 'active' : ''; ?>">
                                    <a class="page-link" href="index.php?accion=admin_productos&p=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo ($paginaActual >= $totalPaginas) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="index.php?accion=admin_productos&p=<?php echo $paginaActual + 1; ?>">Siguiente »</a>
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