</main>

<footer>
    <p>© <?php echo date('Y'); ?> Matías Quinteros - Trabajo Final Programación 2</p>
</footer>

<script src="assets/js/bootstrap.bundle.min.js"></script>

<script>
    var USUARIO_ID_ACTUAL = "<?php echo isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 'invitado'; ?>";
</script>

<script src="assets/js/carrito.js"></script>
</body>
</html>