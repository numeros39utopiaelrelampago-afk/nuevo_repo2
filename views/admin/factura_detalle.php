<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #<?php echo $factura['id_ventas']; ?></title>
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/admin_nav.php'; ?>

    <p><a href="index.php?accion=admin_ventas">← Volver al listado de ventas</a></p>

    <div style="border: 2px solid #333; padding: 20px; max-width: 650px;">
        <h2>FACTURA DE VENTA #<?php echo $factura['id_ventas']; ?></h2>
        <p><strong>Fecha:</strong> <?php echo $factura['fecha']; ?></p>
        <p><strong>Cliente:</strong> <?php echo htmlspecialchars($factura['cliente']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($factura['email']); ?></p>
        <hr>

        <h3>Detalle de Artículos</h3>
        <table border="1" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9f9f9;">
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unit.</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $it): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($it['producto']); ?></td>
                        <td><?php echo $it['cantidad']; ?></td>
                        <td>$<?php echo number_format($it['precio'], 2); ?></td>
                        <td>$<?php echo number_format($it['precio'] * $it['cantidad'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align: right;">Total General:</th>
                    <th>$<?php echo number_format($factura['total'], 2); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>