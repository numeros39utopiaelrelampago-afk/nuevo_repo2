        <?php 
            $tituloPagina = "Iniciar sesión";
            include __DIR__ . '/../../includes/head.php';
            include __DIR__ . '/../../includes/header.php';
        ?>

        <!-- Mensajes de alerta -->
        <div style="width: 100%;">
            <?php if (!empty($error)): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($mensaje)): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px;">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

                <div style="display: flex; gap: 50px;">
                <!-- FORMULARIO 1: INICIAR SESIÓN -->
                <div style="border: 1px solid #ccc; padding: 20px; width: 300px;">
                    <h3>Iniciar Sesión</h3>
                    <form method="POST" action="index.php?accion=autenticar">
                        <p>
                            <label>Usuario:</label><br>
                            <input type="text" name="nombre" required style="width: 90%;">
                        </p>
                        <p>
                            <label>Contraseña:</label><br>
                            <input type="password" name="pass" required style="width: 90%;">
                        </p>
                        <button type="submit">Ingresar</button>
                    </form>
                </div>

                <!-- FORMULARIO 2: CREAR CUENTA NUEVA -->
                <div style="border: 1px solid #ccc; padding: 20px; width: 300px;">
                    <h3>Crear Cuenta Nueva</h3>
                    <form method="POST" action="index.php?accion=registro">
                        <p>
                            <label>Nombre de usuario:</label><br>
                            <input type="text" name="nombre" required style="width: 90%;">
                        </p>
                        <p>
                            <label>Email:</label><br>
                            <input type="text" name="email" required style="width: 90%;">
                        </p>
                        <p>
                            <label>Contraseña:</label><br>
                            <input type="password" name="pass" required style="width: 90%;">
                        </p>
                        <button type="submit">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>

    <?php include __DIR__ . '/../../includes/footer.php'; ?>+    