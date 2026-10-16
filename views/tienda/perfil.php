<?php 
$tituloPagina = "Mi Perfil";
include __DIR__ . '/../../includes/head.php';
include __DIR__ . '/../../includes/header.php';
?>

<h2>Mi Perfil</h2>

<?php if (!empty($mensaje)): ?>
    <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 4px;">
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?accion=guardar_perfil" style="max-width: 650px;">
    
    <!-- SECCIÓN 1: DATOS PERSONALES -->
    <fieldset style="border: 1px solid #cbd5e1; padding: 20px; border-radius: 6px; margin-bottom: 25px;">
        <legend style="font-weight: bold; padding: 0 8px; color: #1e293b;">Datos Personales</legend>
        
        <p style="margin-bottom: 12px;">
            <label>Nombre:</label><br>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>" required style="width: 95%;">
        </p>
        <p style="margin-bottom: 12px;">
            <label>Apellido:</label><br>
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido'] ?? ''); ?>" placeholder="Completá tu apellido" style="width: 95%;">
        </p>
        <p style="margin-bottom: 12px;">
            <label>Teléfono:</label><br>
            <input type="text" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?>" placeholder="Ej: 11 1234-5678" style="width: 95%;">
        </p>
        <p style="margin-bottom: 12px;">
            <label>Email:</label><br>
            <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>" required style="width: 95%;">
        </p>
    </fieldset>

    <!-- SECCIÓN 2: DATOS DE FACTURACIÓN -->
    <fieldset style="border: 1px solid #cbd5e1; padding: 20px; border-radius: 6px; margin-bottom: 25px;">
        <legend style="font-weight: bold; padding: 0 8px; color: #1e293b;">Datos de Facturación</legend>
        
        <p style="margin-bottom: 12px;">
            <label>Dirección:</label><br>
            <input type="text" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion'] ?? ''); ?>" placeholder="Calle y número" style="width: 95%;">
        </p>
        <p style="margin-bottom: 12px;">
            <label>Provincia:</label><br>
            <input type="text" name="provincia" value="<?php echo htmlspecialchars($usuario['provincia'] ?? ''); ?>" placeholder="Ej: Buenos Aires" style="width: 95%;">
        </p>
        <p style="margin-bottom: 12px;">
            <label>Ciudad:</label><br>
            <input type="text" name="ciudad" value="<?php echo htmlspecialchars($usuario['ciudad'] ?? ''); ?>" placeholder="Ej: Chacabuco" style="width: 95%;">
        </p>
        <p style="margin-bottom: 12px;">
            <label>Código Postal:</label><br>
            <input type="text" name="codigo_postal" value="<?php echo htmlspecialchars($usuario['codigo_postal'] ?? ''); ?>" placeholder="Ej: 6740" style="width: 95%;">
        </p>
    </fieldset>

    <button type="submit" style="padding: 10px 20px; font-size: 15px;">Guardar Cambios</button>
</form>

<?php 
include __DIR__ . '/../../includes/footer.php'; 
?>