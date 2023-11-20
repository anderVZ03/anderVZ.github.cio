// Función para mostrar detalles de un pedido en el modal
function mostrarDetallePedido(pedidoId) {
    // Realiza una solicitud AJAX para obtener los datos del pedido desde PHP
    $.ajax({
        type: 'POST',
        url: 'php/pedido.php', // Ruta al archivo PHP que obtiene los datos del pedido
        data: { pedidoId: pedidoId }, // Envía el ID del pedido al PHP
        dataType: 'json', // Espera una respuesta JSON

        success: function (pedido) {
            console.log(pedido);
            // Llena los campos del modal con los datos del pedido
            document.getElementById("clienteNombre").textContent = pedido.clienteNombre;
            document.getElementById("clienteTelefono").textContent = pedido.clienteTelefono;
            document.getElementById("numeroPedido").textContent = "#" + pedido.idFactura; // Usamos el ID de factura
            document.getElementById("fechaHora").textContent = pedido.fecha;
            document.getElementById("metodoPago").textContent = pedido.metodo; // Utilizamos el método de pago
            document.getElementById("totalPedido").textContent = pedido.total;
            document.getElementById("instruccionesEntrega").textContent = pedido.instrucciones;
            document.getElementById("direccion").textContent = pedido.direccion; // Agregamos la dirección

            // Guardamos el ID del pedido en un atributo data en el botón de confirmar
            var botonConfirmarEntrega = document.getElementById("confirmarEntrega");
            botonConfirmarEntrega.setAttribute("data-pedido-id", pedido.idFactura);

            // Muestra el modal
            document.getElementById("detallePedidoModal").style.display = "block";
        },
        error: function () {
            console.error('Error al obtener los datos del pedido desde PHP.');
        }
    });
}

// Agrega un event listener a las filas de pedido (igual que en tu código original)
var filasPedido = document.querySelectorAll(".pedido-fila");
filasPedido.forEach(function (fila) {
    fila.addEventListener("click", function () {
        var pedidoId = this.getAttribute("data-pedido-id");
        mostrarDetallePedido(pedidoId);
    });
});

// Función para cerrar el modal (igual que en tu código original)
function cerrarModal() {
    document.getElementById("detallePedidoModal").style.display = "none";
}

// Función para confirmar la entrega
function confirmarEntrega() {
    // Obtenemos el ID del pedido desde el botón de confirmar
    var botonConfirmarEntrega = document.getElementById("confirmarEntrega");
    var pedidoId = botonConfirmarEntrega.getAttribute("data-pedido-id");

    // Realiza una solicitud AJAX para confirmar la entrega en PHP
    $.ajax({
        type: 'POST',
        url: 'php/pedido.php', // Ruta al archivo PHP que confirma la entrega
        data: { confirmarEntrega: true, pedidoId: pedidoId }, // Envía el ID del pedido para confirmación
        dataType: 'json', // Espera una respuesta JSON

        success: function (response) {
            if (response.success) {
                alert(response.success); // Muestra un mensaje de éxito
                cerrarModal(); // Cierra el modal después de la confirmación
                location.reload();
            } else {
                alert(response.error); // Muestra un mensaje de error si falla la confirmación
            }
        },
        error: function () {
            console.error('Error al confirmar la entrega desde PHP.');
        }
    });
}
