// ==========================================
// 1. CLAVE DINÁMICA POR USUARIO
// ==========================================
function obtenerClaveStorage() {
    var id = (typeof USUARIO_ID_ACTUAL !== "undefined") ? USUARIO_ID_ACTUAL : "invitado";
    return "carrito_" + id;
}

function obtenerCarritoStorage() {
    var clave = obtenerClaveStorage();
    var guardado = localStorage.getItem(clave);
    if (guardado) {
        try {
            return JSON.parse(guardado);
        } catch (e) {
            return [];
        }
    }
    return [];
}

function guardarCarritoStorage(carrito) {
    var clave = obtenerClaveStorage();
    localStorage.setItem(clave, JSON.stringify(carrito));
}

// ==========================================
// 2. ACCIONES CON CONTROL DE STOCK
// ==========================================
function agregarProducto(id, nombre, precio, stockMaximo) {
    id = parseInt(id);
    precio = parseFloat(precio);
    stockMaximo = parseInt(stockMaximo);

    if (stockMaximo <= 0) {
        alert("Este producto no tiene stock disponible.");
        return;
    }

    var carrito = obtenerCarritoStorage();
    var encontrado = false;

    for (var i = 0; i < carrito.length; i++) {
        if (carrito[i].id === id) {
            if (carrito[i].cantidad >= stockMaximo) {
                alert("No podés agregar más unidades. El stock máximo disponible es: " + stockMaximo);
                return;
            }
            carrito[i].cantidad += 1;
            encontrado = true;
            break;
        }
    }

    if (!encontrado) {
        carrito.push({
            id: id,
            nombre: nombre,
            precio: precio,
            cantidad: 1,
            stockMaximo: stockMaximo
        });
    }

    guardarCarritoStorage(carrito);
    actualizarContadorCarrito();
    alert("¡" + nombre + " agregado al carrito!");
}

function sumarCantidad(idProducto) {
    idProducto = parseInt(idProducto);
    var carrito = obtenerCarritoStorage();
    var item = carrito.find(function(p) { return p.id === idProducto; });

    if (item) {
        if (item.stockMaximo !== undefined && item.cantidad >= item.stockMaximo) {
            alert("No hay más stock disponible. Máximo: " + item.stockMaximo);
            return;
        }

        item.cantidad++;
        guardarCarritoStorage(carrito);
        actualizarContadorCarrito();
        renderizarTablaCarrito();
    }
}

function restarCantidad(idProducto) {
    idProducto = parseInt(idProducto);
    var carrito = obtenerCarritoStorage();
    var item = carrito.find(function(p) { return p.id === idProducto; });

    if (item) {
        if (item.cantidad > 1) {
            item.cantidad--;
        } else {
            carrito = carrito.filter(function(p) { return p.id !== idProducto; });
        }
        guardarCarritoStorage(carrito);
        actualizarContadorCarrito();
        renderizarTablaCarrito();
    }
}

function eliminarProducto(id) {
    id = parseInt(id);
    var carrito = obtenerCarritoStorage();
    var nuevoCarrito = carrito.filter(function(item) { return item.id !== id; });

    guardarCarritoStorage(nuevoCarrito);
    actualizarContadorCarrito();
    renderizarTablaCarrito();
}

function vaciarCarrito() {
    var clave = obtenerClaveStorage();
    localStorage.removeItem(clave);
    actualizarContadorCarrito();
    renderizarTablaCarrito();
}

// ==========================================
// 3. ACTUALIZACIÓN VISUAL (DOM)
// ==========================================
function actualizarContadorCarrito() {
    var elementoContador = document.getElementById("cantidad-carrito");
    if (!elementoContador) return;

    var carrito = obtenerCarritoStorage();
    var totalItems = 0;

    for (var i = 0; i < carrito.length; i++) {
        totalItems += carrito[i].cantidad;
    }

    elementoContador.textContent = totalItems;
}

function renderizarTablaCarrito() {
    var cuerpoTabla = document.getElementById("cuerpo-tabla-carrito");
    var elementoTotal = document.getElementById("total-pagar");
    var inputCarritoJson = document.getElementById("input-carrito-datos");

    if (!cuerpoTabla) return;

    var carrito = obtenerCarritoStorage();
    cuerpoTabla.innerHTML = "";
    var total = 0;

    if (carrito.length === 0) {
        cuerpoTabla.innerHTML = "<tr><td colspan='5' class='text-center py-4 text-muted'>El carrito está vacío.</td></tr>";
        if (elementoTotal) elementoTotal.textContent = "0.00";
        if (inputCarritoJson) inputCarritoJson.value = "[]";
        return;
    }

    for (var i = 0; i < carrito.length; i++) {
        var item = carrito[i];
        var precioUnitario = parseFloat(item.precio);
        var subtotal = precioUnitario * item.cantidad;
        total += subtotal;

        var fila = document.createElement("tr");
        fila.className = "align-middle";
        fila.innerHTML = `
            <td>${item.nombre}</td>
            <td>$${precioUnitario.toFixed(2)}</td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0 fw-bold" onclick="restarCantidad(${item.id})">-</button>
                    <span class="fw-bold px-1">${item.cantidad}</span>
                    <button type="button" class="btn btn-sm btn-outline-primary px-2 py-0 fw-bold" onclick="sumarCantidad(${item.id})">+</button>
                </div>
            </td>
            <td>$${subtotal.toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(${item.id})">Eliminar</button>
            </td>
        `;

        cuerpoTabla.appendChild(fila);
    }

    if (elementoTotal) {
        elementoTotal.textContent = total.toFixed(2);
    }

    if (inputCarritoJson) {
        inputCarritoJson.value = JSON.stringify(carrito);
    }
}

// Inicialización automática al cargar
window.addEventListener("DOMContentLoaded", function() {
    actualizarContadorCarrito();
    renderizarTablaCarrito();
});