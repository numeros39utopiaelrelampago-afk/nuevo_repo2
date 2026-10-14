<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Ventas</title>
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

    <h2>Ventas Realizadas</h2>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #eee;">
                <th>N° Venta</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total Facturado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($ventas)): ?>
                <tr><td colspan="5" style="text-align: center;">No hay ventas registradas aún.</td></tr>
            <?php else: ?>
                <?php foreach ($ventas as $v): ?>
                    <tr>
                        <td>#<?php echo $v['id_ventas']; ?></td>
                        <td><?php echo $v['fecha']; ?></td>
                        <td><?php echo htmlspecialchars($v['cliente']); ?> (<?php echo htmlspecialchars($v['email']); ?>)</td>
                        <td>$<?php echo number_format($v['total'], 2); ?></td>
                        <td>
                            <a href="index.php?accion=admin_factura&id=<?php echo $v['id_ventas']; ?>">
                                Ver Factura
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>