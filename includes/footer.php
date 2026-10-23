</main>

<footer>
    <p>© <?php echo date('Y'); ?> Matías Quinteros - Trabajo Final Programación 2</p>
</footer>

<!-- 1. JS de Bootstrap -->
<script src="assets/js/bootstrap.bundle.min.js"></script>

<!-- 2. Variable global para aislar el carrito por usuario -->
<script>
    var USUARIO_ID_ACTUAL = "<?php echo isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 'invitado'; ?>";
</script>

<!-- Carga global del script JS nativo con localStorage -->
<script src="assets/js/carrito.js"></script>
</body>
</html>