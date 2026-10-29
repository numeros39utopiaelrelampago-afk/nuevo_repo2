<?php 
$tituloPagina = "Detalle de Pedido #" . $pedido['id_ventas'];
include __DIR__ . '/../../includes/head.php';
include __DIR__ . '/../../includes/header.php';
?>

<section style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; max-width: 700px; margin-top: 15px;">
    <h2>Comprobante de Compra #<?php echo $pedido['id_ventas']; ?></h2>
    <p><strong>Fecha:</strong> <?php echo date("d/m/Y H:i", strtotime($pedido['fecha'])); ?> hs</p>
    <p><strong>Comprador:</strong> <?php echo htmlspecialchars($_SESSION['nombre']); ?></p>
    
    <hr style="margin: 20px 0;">

    <h3>Artículos Comprados</h3>
    <table class="table table-striped table-hover border">
    <thead class="table-dark">
            <tr>
                <th>Carta / Artículo</th>
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
                <th colspan="3" style="text-align: right;">Total Pagado:</th>
                <th>$<?php echo number_format($pedido['total'], 2); ?></th>
            </tr>
        </tfoot>
    </table>
</section>

<?php 
include __DIR__ . '/../../includes/footer.php'; 
?>