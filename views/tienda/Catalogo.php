<?php 
$tituloPagina = "Catálogo";
include __DIR__ . '/../../includes/head.php';
include __DIR__ . '/../../includes/header.php';
?>

<!-- Slider / Banner Carousel -->
<div id="bannerCarousel" class="carousel slide my-2" data-bs-ride="carousel">

  <!-- Contenido de las diapositivas -->
  <div class="carousel-inner rounded-2
   shadow-sm">
    <!-- Slide 1 -->
    <div class="carousel-item active" data-bs-interval="4000">
        <a href="listado.php?categoria[]=2&categoria[]=3&categoria[]=5">
            <img src="/../assets/img/banner1.jpg" class="d-block w-100 object-fit-cover" style="height: 200px;" alt="Cartas sueltas">
        </a> 
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item" data-bs-interval="4000">
        <a href="listado.php?categoria[]=1&categoria[]=4&categoria[]=6&categoria[]=7">
            <img src="/../assets/img/banner2.jpg" class="d-block w-100 object-fit-cover" style="height: 200px;" alt="Accesorios">
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
    <div class="d-flex align-items-center gap-2">
    <button type="submit" class="btn btn-primary">Buscar</button>
    <input type="text" id="buscar" name="buscar" class="form-control"
           value="<?php echo htmlspecialchars($termino); ?>" 
           placeholder="Ej: forbidden droplet...">
</div>

    <!-- Select múltiple de Categorías -->
<div>
    <label for="categoria" class="form-label fw-bold mb-1">Categoría:</label>
    <select id="categoria" name="categoria[]" multiple size="1" class="form-select" style="min-width: 170px;">
        <?php foreach ($listaCategorias as $cat): ?>
            <option value="<?php echo $cat['id']; ?>"
                <?php echo in_array($cat['id'], $categorias) ? 'selected' : ''; ?>>
                <?php echo ucfirst(htmlspecialchars($cat['nombre'])); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

    <!-- Select múltiple de Rarezas -->
    <div>
        <label for="rareza" class="form-label fw-bold mb-1">Rareza:</label>
        <select id="rareza" name="rareza[]" multiple size="1" class="form-select" style="min-width: 170px;">
            <?php foreach ($listaRarezas as $r): ?>
                <option value="<?php echo htmlspecialchars($r['rareza']); ?>"
                    <?php echo in_array($r['rareza'], $rarezas) ? 'selected' : ''; ?>>
                    <?php echo ucfirst(htmlspecialchars($r['rareza'])); ?>
                </option>
            <?php endforeach; ?>
        </select>
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
                <button type="button" 
        class="btn btn-sm btn-dark w-100 mt-2" 
        onclick="agregarProducto(<?php echo $prod['id']; ?>, '<?php echo addslashes($prod['nombre']); ?>', <?php echo $prod['precio']; ?>, <?php echo $prod['stock']; ?>)">
    Agregar al Carrito
</button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<!-- CONTROLES DE PAGINACIÓN -->
<?php if ($totalPaginas > 1): ?>
    <nav aria-label="Navegación de páginas" class="my-4">
        <ul class="pagination justify-content-center">

            <!-- Botón Anterior -->
            <li class="page-item <?php echo ($paginaActual <= 1) ? 'disabled' : ''; ?>">
                <?php 
                    $parametrosUrl['p'] = $paginaActual - 1;
                    $urlAnterior = 'listado.php?' . http_build_query($parametrosUrl);
                ?>
                <a class="page-link" href="<?php echo htmlspecialchars($urlAnterior); ?>">« Anterior</a>
            </li>

            <!-- Números de Página -->
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <?php 
                    $parametrosUrl['p'] = $i;
                    $urlPagina = 'listado.php?' . http_build_query($parametrosUrl);
                ?>
                <li class="page-item <?php echo ($i === $paginaActual) ? 'active' : ''; ?>">
                    <a class="page-link" href="<?php echo htmlspecialchars($urlPagina); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Botón Siguiente -->
            <li class="page-item <?php echo ($paginaActual >= $totalPaginas) ? 'disabled' : ''; ?>">
                <?php 
                    $parametrosUrl['p'] = $paginaActual + 1;
                    $urlSiguiente = 'listado.php?' . http_build_query($parametrosUrl);
                ?>
                <a class="page-link" href="<?php echo htmlspecialchars($urlSiguiente); ?>">Siguiente »</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<?php 
include __DIR__ . '/../../includes/footer.php'; 
?>