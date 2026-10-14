<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Compra Confirmada!</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <header>
        <h1>Store of Ragnarok</h1>
        <nav>
    <a href="listado.php">Volver al catálogo</a>
        </nav>
    </header>
<main style="text-align: center; margin-top: 40px;">
        <div style="border: 1px solid #c3e6cb; background-color: #d4edda; color: #155724; display: inline-block; padding: 30px; border-radius: 5px;">
            <h2>¡Gracias por tu compra, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h2>
            <p>Tu orden ha sido registrada con éxito bajo el comprobante <strong>#<?php echo $idVenta; ?></strong>.</p>
            <p>Ya puedes consultar el estado o realizar una nueva compra.</p>
            <br>
            <a href="index.php?accion=catalogo" style="padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 3px;">
                Seguir comprando
            </a>
        </div>
    </main>

    <!-- JS para vaciar localStorage una vez confirmada la compra en el servidor -->
    <script>
        localStorage.removeItem("carrito");
    </script>
</body>
</html>