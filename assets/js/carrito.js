// ==========================================
// 1. FUNCIONES AUXILIARES DE LOCALSTORAGE
// ==========================================

// Obtiene el array del carrito guardado en el navegador
function obtenerCarritoStorage() {
    var guardado = localStorage.getItem("carrito");
    if (guardado) {
        return JSON.parse(guardado);
    }
    return [];
}

// Guarda el array actual del carrito en localStorage
function guardarCarritoStorage(carrito) {
    localStorage.setItem("carrito", JSON.stringify(carrito));
}

// ==========================================
// 2. ACCIONES DEL CARRITO
// ==========================================

// Agrega un producto o incrementa su cantidad si ya existía
function agregarProducto(id, nombre, precio) {
    var carrito = obtenerCarritoStorage();
    var encontrado = false;

    // Recorremos el carrito para ver si ya fue agregado antes
    for (var i = 0; i < carrito.length; i++) {
        if (carrito[i].id === id) {
            carrito[i].cantidad += 1;
            encontrado = true;
            break;
        }
    }

    // Si es un producto nuevo en el carrito, lo insertamos
    if (!encontrado) {
        carrito.push({
            id: id,
            nombre: nombre,
            precio: parseFloat(precio),
            cantidad: 1
        });
    }

    // Persistimos el cambio y actualizamos la interfaz
    guardarCarritoStorage(carrito);
    actualizarContadorCarrito();
    alert("¡" + nombre + " agregado al carrito!");
}

// Elimina por completo un producto del carrito según su id
function eliminarProducto(id) {
    var carrito = obtenerCarritoStorage();
    var nuevoCarrito = [];

    for (var i = 0; i < carrito.length; i++) {
        if (carrito[i].id !== id) {
            nuevoCarrito.push(carrito[i]);
        }
    }

    guardarCarritoStorage(nuevoCarrito);
    actualizarContadorCarrito();

    // Si estamos en la página del carrito, repintamos la tabla
    if (document.getElementById("tabla-carrito")) {
        renderizarTablaCarrito();
    }
}

// Vacía todo el carrito
function vaciarCarrito() {
    localStorage.removeItem("carrito");
    actualizarContadorCarrito();

    if (document.getElementById("tabla-carrito")) {
        renderizarTablaCarrito();
    }
}

// ==========================================
// 3. ACTUALIZACIÓN VISUAL (DOM)
// ==========================================

// Actualiza el número de ítems visible en la barra de navegación
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

// Dibuja los productos en la tabla de la vista views/tienda/carrito.php
function renderizarTablaCarrito() {
    var cuerpoTabla = document.getElementById("cuerpo-tabla-carrito");
    var elementoTotal = document.getElementById("total-pagar");
    var inputCarritoJson = document.getElementById("input-carrito-datos");

    if (!cuerpoTabla) return;

    var carrito = obtenerCarritoStorage();
    cuerpoTabla.innerHTML = "";
    var total = 0;

    if (carrito.length === 0) {
        cuerpoTabla.innerHTML = "<tr><td colspan='5' style='text-align:center;'>El carrito está vacío.</td></tr>";
        if (elementoTotal) elementoTotal.textContent = "0.00";
        if (inputCarritoJson) inputCarritoJson.value = "[]";
        return;
    }

    for (var i = 0; i < carrito.length; i++) {
        var item = carrito[i];
        var subtotal = item.precio * item.cantidad;
        total += subtotal;

        var fila = document.createElement("tr");
        fila.innerHTML =
            "<td>" + item.nombre + "</td>" +
            "<td>$" + item.precio.toFixed(2) + "</td>" +
            "<td>" + item.cantidad + "</td>" +
            "<td>$" + subtotal.toFixed(2) + "</td>" +
            "<td><button type='button' onclick='eliminarProducto(" + item.id + ")'>Eliminar</button></td>";

        cuerpoTabla.appendChild(fila);
    }

    if (elementoTotal) {
        elementoTotal.textContent = total.toFixed(2);
    }

    // Asignamos el JSON al input hidden del formulario para enviarlo a PHP al pagar
    if (inputCarritoJson) {
        inputCarritoJson.value = JSON.stringify(carrito);
    }
}

// ==========================================
// 4. INICIALIZACIÓN AL CARGAR LA PÁGINA
// ==========================================
window.addEventListener("DOMContentLoaded", function() {
    actualizarContadorCarrito();

    // Si la página actual contiene la tabla del carrito, la dibujamos
    if (document.getElementById("tabla-carrito")) {
        renderizarTablaCarrito();
    }
});