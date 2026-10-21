<?php 
$tituloPagina = "Catálogo";
include __DIR__ . '/../../includes/head.php';
include __DIR__ . '/../../includes/header.php';
?>

<!-- Slider / Banner Carousel -->
<div id="bannerCarousel" class="carousel slide my-4" data-bs-ride="carousel">
  <!-- Indicadores inferiores -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>

  <!-- Contenido de las diapositivas -->
  <div class="carousel-inner rounded-3 shadow-sm">
    <!-- Slide 1 -->
    <div class="carousel-item active" data-bs-interval="4000">
      <img src="/../assets/img/banner1.jpg" class="d-block w-100 banner-img" alt="Cartas sueltas">
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item" data-bs-interval="4000">
      <img src="/../assets/img/banner2.jpg" class="d-block w-100 banner-img" alt="Accesorios">
    </div>

    <!-- Slide 3 -->
    <div class="carousel-item" data-bs-interval="4000">
      <img src="img/banner3.jpg" class="d-block w-100 banner-img" alt="Lotes y promociones">
    </div>
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

<!-- FORMULARIO DE FILTROS -->
<form method="GET" action="listado.php">

    <label for="buscar">Buscar:</label>
    <input type="text" id="buscar" name="buscar" value="<?php echo htmlspecialchars($termino); ?>" placeholder="Ej: forbidden droplet...">

    <label for="categoria">Categoría:</label>
    <select id="categoria" name="categoria">
        <option value="">-- Todas --</option>
        <?php foreach ($categorias as $cat): ?>
            <option value="<?php echo htmlspecialchars($cat['categoria']); ?>"
                <?php echo ($categoria === $cat['categoria']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cat['categoria']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="rareza">Rareza:</label>
    <select id="rareza" name="rareza">
        <option value="">-- Todas las rarezas --</option>
        <?php foreach ($rarezas as $r): ?>
            <option value="<?php echo htmlspecialchars($r['rareza']); ?>"
                <?php echo ($rareza === $r['rareza']) ? 'selected' : ''; ?>>
                <?php echo ucfirst(htmlspecialchars($r['rareza'])); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Filtrar</button>
    <!-- Botón para limpiar que recarga listado.php sin parámetros -->
    <a href="listado.php">Limpiar</a>
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