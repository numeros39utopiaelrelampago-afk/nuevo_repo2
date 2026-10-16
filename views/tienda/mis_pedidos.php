<?php 
$tituloPagina = "Mis Pedidos";
include __DIR__ . '/../../includes/head.php';
include __DIR__ . '/../../includes/header.php';
?>

<h2>Pedidos Realizados</h2>

<?php if (empty($pedidos)): ?>
    <div style="background: white; padding: 25px; border-radius: 6px; border: 1px solid #e2e8f0; max-width: 600px;">
        <p>Todavía no realizaste ninguna compra en la tienda.</p>
        <br>
        <a href="listado.php" style="padding: 8px 16px; background-color: #2563eb; color: white; text-decoration: none; border-radius: 4px;">
            Ver Catálogo de Cartas
        </a>
    </div>
<?php else: ?>
    <table border="1" cellpadding="10" cellspacing="0" style="max-width: 750px;">
        <thead>
            <tr>
                <th>N° Pedido</th>
                <th>Fecha de Compra</th>
                <th>Total Abonado</th>
                <th>Comprobante</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $p): ?>
                <tr>
                    <td><strong>#<?php echo $p['id_ventas']; ?></strong></td>
                    <td><?php echo date("d/m/Y H:i", strtotime($p['fecha'])); ?> hs</td>
                    <td>$<?php echo number_format($p['total'], 2); ?></td>
                    <td>
                        <a href="index.php?accion=detalle_pedido&id=<?php echo $p['id_ventas']; ?>" 
                           style="color: #2563eb; font-weight: bold; text-decoration: none;">
                            Ver Detalle 📄
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php 
include __DIR__ . '/../../includes/footer.php'; 
?>