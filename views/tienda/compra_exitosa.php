<?php 
$tituloPagina = "Compra Exitosa";
include __DIR__ . '/../../includes/head.php';
include __DIR__ . '/../../includes/header.php';
?>

<div class="container my-5 text-center">
    <div class="card shadow-sm mx-auto p-4 border-success" style="max-width: 600px; background-color: #d4edda; color: #155724;">
        <h2 class="mb-3">¡Gracias por tu compra, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h2>
        <p class="fs-5">Tu orden ha sido registrada con éxito bajo el comprobante <strong>#<?php echo htmlspecialchars($idVenta); ?></strong>.</p>
        <p>Ya podés consultar el estado de tu pedido o realizar una nueva compra.</p>
        <div class="mt-4">
            <a href="listado.php" class="btn btn-success btn-lg">
                Seguir comprando
            </a>
        </div>
    </div>
</div>

<script>
    var claveStorage = "carrito_" + "<?php echo isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 'invitado'; ?>";
    localStorage.removeItem(claveStorage);
</script>

<?php 
include __DIR__ . '/../../includes/footer.php'; 
?>