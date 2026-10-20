        <?php 
            $tituloPagina = "Mi Carrito";
            include __DIR__ . '/../../includes/head.php';
            include __DIR__ . '/../../includes/header.php';
        ?>

        <h2>Detalle de tu Carrito</h2>

        <!-- TABLA DONDE JS RENDERIZA LOS PRODUCTOS -->
        <table class="table table-striped table-hover border">
    <thead class="table-dark">
                <tr style="background-color: #f2f2f2;">
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="cuerpo-tabla-carrito">
                <!-- carrito.js insertará aquí las filas de forma dinámica -->
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align: right;">Total General:</th>
                    <th colspan="2" style="text-align: left;">$<span id="total-pagar">0.00</span></th>
                </tr>
            </tfoot>
        </table>

        <br>

        <!-- ACCIONES DEL CARRITO -->
        <div>
            <button type="button" onclick="vaciarCarrito()">Vaciar Carrito</button>
        </div>

        <hr style="margin: 25px 0;">

        <!-- SECCIÓN DE FINALIZACIÓN DE COMPRA -->
        <section>
            <?php if (isset($_SESSION['id_user'])): ?>
                <!-- Si está logueado, permitimos confirmar la compra -->
                <form method="POST" action="index.php?accion=procesar_compra" onsubmit="return validarEnvioCompra();">
                    <!-- Este input oculto se llena automáticamente desde carrito.js -->
                    <input type="hidden" name="carrito_datos" id="input-carrito-datos" value="">

                    <p>Vas a confirmar la orden a nombre de: <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong></p>
                    <button type="submit" style="padding: 10px 20px; font-size: 16px; background-color: #28a745; color: white; border: none; cursor: pointer;">
                        Confirmar y Finalizar Compra
                    </button>
                </form>
            <?php else: ?>
                <!-- Si no está logueado, lo obligamos a crear cuenta o iniciar sesión -->
                <div style="background-color: #fff3cd; border: 1px solid #ffeeba; padding: 15px; max-width: 500px;">
                    <p><strong>Atención:</strong> Para poder confirmar tu compra tenés que identificarte.</p>
                    <a href="index.php?accion=login" style="display: inline-block; padding: 8px 15px; background-color: #007bff; color: white; text-decoration: none;">
                        Iniciar Sesión o Crear Cuenta
                    </a>
                </div>
            <?php endif; ?>
        </section>
    
        <?php include __DIR__ . '/../../includes/footer.php'; ?>