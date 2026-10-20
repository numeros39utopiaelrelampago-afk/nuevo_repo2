<?php 
$tituloPagina = "Ventas";
include __DIR__ . '/../../includes/head.php';
?>

<?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

<main class="flex-grow-1">
    <h2>Ventas Realizadas</h2>
    <table class="table table-striped table-hover border align-middle">
        <thead class="table-dark">
            <tr>
                <th>N° Venta</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total Facturado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($ventas)): ?>
                <tr><td colspan="5" class="text-center py-3">No hay ventas registradas aún.</td></tr>
            <?php else: ?>
                <?php foreach ($ventas as $v): ?>
                    <tr>
                        <td><strong>#<?php echo $v['id_ventas']; ?></strong></td>
                        <td><?php echo $v['fecha']; ?></td>
                        <td><?php echo htmlspecialchars($v['cliente']); ?> (<?php echo htmlspecialchars($v['email']); ?>)</td>
                        <td>$<?php echo number_format($v['total'], 2); ?></td>
                        <td>
                            <a href="index.php?accion=admin_factura&id=<?php echo $v['id_ventas']; ?>" class="btn btn-sm btn-primary">
                                Ver Factura 📄
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?php 
include __DIR__ . '/../../includes/footer.php'; 
?>