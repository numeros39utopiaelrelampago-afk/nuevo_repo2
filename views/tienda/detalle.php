<?php 
$tituloPagina = $producto['nombre'] . " - Detalle";
include __DIR__ . '/../../includes/head.php';
include __DIR__ . '/../../includes/header.php';

$rutaImagen = "assets/img/productos/" . $producto['id'] . ".jpg";
if (!file_exists($rutaImagen)) {
    $rutaImagen = "assets/img/productos/default.jpg";
}
?>

<section style="display: flex; gap: 40px; margin-top: 20px; background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; max-width: 800px;">
    
    <!-- Imagen grande de la carta -->
<div style="flex: 1; text-align: center;">
    
    <!-- Al hacer clic en la foto, se abre en pestaña nueva -->
    <a href="<?php echo $rutaImagen; ?>" target="_blank" title="Hacé clic para ver la imagen completa">
        <img src="<?php echo $rutaImagen; ?>" 
             alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
             style="max-width: 100%; max-height: 400px; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); cursor: zoom-in;">
    </a>

    <!-- Botón secundario visible abajo de la foto -->
    <div style="margin-top: 15px;">
        <a href="<?php echo $rutaImagen; ?>" target="_blank" 
           style="display: inline-block; padding: 8px 16px; background-color: #475569; color: white; text-decoration: none; border-radius: 6px; font-size: 13px; font-weight: bold;">
            🔍 Ver carta en detalle
        </a>
    </div>

</div>

    <!-- Información detallada y compra -->
    <div style="flex: 1.2; display: flex; flex-direction: column; justify-content: center;">
        <h2 style="font-size: 24px; margin-bottom: 10px;"><?php echo htmlspecialchars($producto['nombre']); ?></h2>
        
        <p style="margin: 8px 0; font-size: 15px;">
            <strong>Categoría:</strong> 
            <span><?php echo htmlspecialchars($producto['categoria']); ?></span>
        </p>
        
        <p style="margin: 8px 0; font-size: 15px;">
            <strong>Rareza:</strong> 
            <span style="text-transform: uppercase; color: #b45309; font-weight: bold; background: #fef3c7; padding: 2px 8px; border-radius: 4px;">
                <?php echo htmlspecialchars($producto['rareza']); ?>
            </span>
        </p>

        <p style="margin: 8px 0; font-size: 15px;">
            <strong>Disponibilidad:</strong> 
            <span style="color: #16a34a; font-weight: bold;"><?php echo $producto['stock']; ?> unidades</span>
        </p>

        <h3 style="font-size: 28px; color: #0f172a; margin: 20px 0 15px 0;">
            $<?php echo number_format($producto['precio'], 2); ?>
        </h3>

        <!-- Botón que invoca la función JS nativa ya creada -->
        <button type="button" 
                onclick="agregarProducto(<?php echo $producto['id']; ?>, '<?php echo addslashes($producto['nombre']); ?>', <?php echo $producto['precio']; ?>)"
                style="padding: 12px 24px; font-size: 16px; background-color: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; width: fit-content;">
            🛒 Agregar al Carrito
        </button>
    </div>

</section>

<?php 
include __DIR__ . '/../../includes/footer.php'; 
?>