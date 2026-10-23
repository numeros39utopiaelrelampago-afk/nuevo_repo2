        <?php 
$tituloPagina = "Mi Carrito";
include __DIR__ . '/../../includes/head.php';
include __DIR__ . '/../../includes/header.php';
?>

<h2>Mi Carrito de Compras</h2>

<table id="tabla-carrito" class="table table-striped table-hover border">
    <thead class="table-dark">
        <tr>
            <th>Producto</th>
            <th>Precio Unitario</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody id="cuerpo-tabla-carrito">
        <!-- carrito.js inyecta aquí los productos -->
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-end">Total General:</th>
            <th colspan="2">$<span id="total-pagar">0.00</span></th>
        </tr>
    </tfoot>
</table>

<div class="mb-4">
    <button type="button" class="btn btn-secondary" onclick="vaciarCarrito()">Vaciar Carrito</button>
</div>

<hr>

<section>
    <?php if (isset($_SESSION['id_user'])): ?>
        <form method="POST" action="index.php?accion=procesar_compra" onsubmit="return validarEnvioCompra();">
            <input type="hidden" name="carrito_datos" id="input-carrito-datos" value="">

            <p>Comprador: <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong></p>
            <button type="submit" class="btn btn-success btn-lg">
                Confirmar y Finalizar Compra
            </button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning" style="max-width: 500px;">
            <p class="mb-2"><strong>Atención:</strong> Para poder confirmar tu compra tenés que identificarte.</p>
            <a href="index.php?accion=login" class="btn btn-primary">
                Iniciar Sesión o Crear Cuenta
            </a>
        </div>
    <?php endif; ?>
</section>

<script>
function validarEnvioCompra() {
    var carrito = obtenerCarritoStorage();
    if (carrito.length === 0) {
        alert("Tu carrito está vacío.");
        return false;
    }
    return true;
}
</script>

<?php 
include __DIR__ . '/../../includes/footer.php'; 
?>