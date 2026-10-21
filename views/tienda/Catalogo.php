<?php 
$tituloPagina = "Catálogo";
include __DIR__ . '/../../includes/head.php';
include __DIR__ . '/../../includes/header.php';
?>

<!-- Slider / Banner Carousel -->
<div id="bannerCarousel" class="carousel slide my-4" data-bs-ride="carousel">

  <!-- Contenido de las diapositivas -->
  <div class="carousel-inner rounded-2
   shadow-sm">
    <!-- Slide 1 -->
    <div class="carousel-item active" data-bs-interval="4000">
        <a href="listado.php?categoria[]=cartas+sueltas&categoria[]=cartas+OCG&categoria[]=lotes">
            <img src="/../assets/img/banner1.jpg" class="d-block w-100 banner-img" alt="Cartas sueltas">
        </a> 
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item" data-bs-interval="4000">
        <a href="listado.php?categoria[]=binders&categoria[]=deckbox&categoria[]=playmats&categoria[]=tins">
            <img src="/../assets/img/banner2.jpg" class="d-block w-100 banner-img" alt="Accesorios">
        </a>
    </div>

  <!-- Flechas de navegación -->
  <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Siguiente</span>
  </button>
</div>

<!-- FORMULARIO DE FILTROS MÚLTIPLES -->
<form method="GET" action="listado.php" class="d-flex flex-wrap align-items-center gap-3 p-3 bg-white rounded border mb-4">

    <!-- Búsqueda por texto -->
    <div>
        <label for="buscar" class="form-label fw-bold mb-1">Buscar carta:</label>
        <input type="text" id="buscar" name="buscar" class="form-control"
               value="<?php echo htmlspecialchars($termino); ?>" 
               placeholder="Ej: forbidden droplet...">
    </div>

    <!-- Select múltiple de Categorías -->
    <div>
        <label for="categoria" class="form-label fw-bold mb-1">Categorías:</label>
        <select id="categoria" name="categoria[]" multiple size="3" class="form-select" style="min-width: 170px;">
            <?php foreach ($listaCategorias as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['categoria']); ?>"
                    <?php echo in_array($cat['categoria'], $categorias) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['categoria']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="text-muted d-block" style="font-size: 11px;">Ctrl + clic (selección múltiple)</small>
    </div>

    <!-- Select múltiple de Rarezas -->
    <div>
        <label for="rareza" class="form-label fw-bold mb-1">Rarezas:</label>
        <select id="rareza" name="rareza[]" multiple size="3" class="form-select" style="min-width: 170px;">
            <?php foreach ($listaRarezas as $r): ?>
                <option value="<?php echo htmlspecialchars($r['rareza']); ?>"
                    <?php echo in_array($r['rareza'], $rarezas) ? 'selected' : ''; ?>>
                    <?php echo ucfirst(htmlspecialchars($r['rareza'])); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="text-muted d-block" style="font-size: 11px;">Ctrl + clic (selección múltiple)</small>
    </div>

    <!-- Botones -->
    <div class="d-flex align-items-end gap-2 mt-3">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="listado.php" class="btn btn-outline-secondary">Limpiar</a>
    </div>

</form>

<hr>

<!-- LISTADO DE CARTAS -->
<section class="contenedor-productos">
    <?php if (empty($productos)): ?>
        <p>No se encontraron cartas disponibles con esos filtros.</p>
    <?php else: ?>
        <?php foreach ($productos as $prod): ?>
            <div class="tarjeta-producto">
                <?php 
                    $rutaImagen = "assets/img/productos/" . $prod['id'] . ".jpg";
                    if (!file_exists($rutaImagen)) {
                        $rutaImagen = "assets/img/productos/default.jpg";
                    }
                ?>

                <!-- Enlace en la imagen hacia el detalle -->
                <a href="index.php?accion=detalle&id=<?php echo $prod['id']; ?>">
                <img src="<?php echo $rutaImagen; ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>">
                </a>
                
                <!-- Enlace en el título hacia el detalle -->
                <h3>
                <a href="index.php?accion=detalle&id=<?php echo $prod['id']; ?>" style="text-decoration: none; color: inherit;">
                <?php echo htmlspecialchars($prod['nombre']); ?>
                </a>
               </h3>
                
                <!-- NUEVO: Etiqueta de rareza -->
                <p><strong>Rareza:</strong> <span style="text-transform: uppercase; color: #b45309; font-weight: bold; background: #fef3c7;"><?php echo htmlspecialchars($prod['rareza']); ?></span></p>
                <p><strong>Precio:</strong> $<?php echo number_format($prod['precio'], 2); ?></p>
                <p><small>Stock: <?php echo $prod['stock']; ?></small></p>

                <!-- Botón directo de agregar rápido al carrito -->
                <button type="button" onclick="agregarProducto(<?php echo $prod['id']; ?>, '<?php echo addslashes($prod['nombre']); ?>', <?php echo $prod['precio']; ?>)">
                    Agregar al Carrito
                </button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?php 
include __DIR__ . '/../../includes/footer.php'; 
?>