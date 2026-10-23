// ==========================================
// 1. CLAVE DINÁMICA POR USUARIO
// ==========================================
function obtenerClaveStorage() {
    // Si hay un usuario logueado usa "carrito_5", si no "carrito_invitado"
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

    // Validación 1: El producto directamente no tiene stock
    if (stockMaximo <= 0) {
        alert("Este producto no tiene stock disponible.");
        return;
    }

    var carrito = obtenerCarritoStorage();
    var encontrado = false;

    for (var i = 0; i < carrito.length; i++) {
        if (carrito[i].id === id) {
            // Validación 2: No permitir agregar más del stock existente
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

function eliminarProducto(id) {
    id = parseInt(id);
    var carrito = obtenerCarritoStorage();
    var nuevoCarrito = [];

    for (var i = 0; i < carrito.length; i++) {
        if (carrito[i].id !== id) {
            nuevoCarrito.push(carrito[i]);
        }
    }

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
        var subtotal = item.precio * item.cantidad;
        total += subtotal;

        var fila = document.createElement("tr");
        fila.className = "align-middle";
        fila.innerHTML =
            "<td><strong>" + item.nombre + "</strong></td>" +
            "<td>$" + item.precio.toFixed(2) + "</td>" +
            "<td>" + item.cantidad + "</td>" +
            "<td>$" + subtotal.toFixed(2) + "</td>" +
            "<td><button type='button' class='btn btn-sm btn-outline-danger' onclick='eliminarProducto(" + item.id + ")'>Eliminar</button></td>";

        cuerpoTabla.appendChild(fila);
    }

    if (elementoTotal) {
        elementoTotal.textContent = total.toFixed(2);
    }

    if (inputCarritoJson) {
        inputCarritoJson.value = JSON.stringify(carrito);
    }
}

// Inicialización automática al cargar cualquier pantalla
window.addEventListener("DOMContentLoaded", function() {
    actualizarContadorCarrito();
    renderizarTablaCarrito();
});