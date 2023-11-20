// Simula una lista de pedidos (esto debería obtenerse de una base de datos en la práctica)

console.log("El archivo JavaScript se ha cargado correctamente.");


  

// Función para mostrar los detalles de un pedido en el modal
function mostrarDetallePedido(pedidoId) {
    // Obtén el pedido correspondiente al pedidoId
    // Arreglo de pedidos simulados
var listaDePedidos = [
    {
        id: 1,
        clienteNombre: "Cliente Ejemplo 1",
        clienteTelefono: "123-456-7890",
        fechaHora: "2023-09-01 14:30:00",
        metodoPago: "Tarjeta de crédito",
        totalPedido: 50.49,
        instruccionesEntrega: "Dejar en la puerta"
    },
    {
        id: 2,
        clienteNombre: "Cliente Ejemplo 2",
        clienteTelefono: "987-654-3210",
        fechaHora: "2023-09-02 10:15:00",
        metodoPago: "Efectivo",
        totalPedido: 30.25,
        instruccionesEntrega: "Entregar en persona"
    },
    // Agrega más pedidos aquí
];

// Función para obtener un pedido por su ID
function obtenerPedidoPorId(pedidoId) {
    for (var i = 0; i < listaDePedidos.length; i++) {
        if (listaDePedidos[i].id === pedidoId) {
            return listaDePedidos[i];
        }
    }
    return null; // Retorna null si no se encuentra el pedido con el ID dado
}

// Ejemplo de cómo usar la función para obtener un pedido por su ID
var pedidoId = 2; // ID del pedido que deseas obtener
var pedido = obtenerPedidoPorId(pedidoId);

if (pedido !== null) {
    console.log("Pedido encontrado:", pedido);
} else {
    console.log("Pedido no encontrado.");
}

    console.log("Mostrando detalles para el pedido con ID:", pedidoId);

    // Llena los campos del modal con los detalles del pedido
    document.getElementById("clienteNombre").textContent = "Cliente Ejemplo";
    document.getElementById("clienteTelefono").textContent = "123-456-7890";
    document.getElementById("numeroPedido").textContent = "#" + pedidoId;
    document.getElementById("fechaHora").textContent = "2023-09-01 14:30:00";
    document.getElementById("metodoPago").textContent = "Tarjeta de crédito";
    document.getElementById("totalPedido").textContent = "50.49";
    document.getElementById("instruccionesEntrega").textContent = "Dejar en la puerta";

    // Muestra el modal
    document.getElementById("detallePedidoModal").style.display = "block";
}

// Agrega un event listener a las filas de pedido
var filasPedido = document.querySelectorAll(".pedido-fila");
filasPedido.forEach(function (fila) {
    fila.addEventListener("click", function () {
        var pedidoId = this.getAttribute("data-pedido-id");
        mostrarDetallePedido(pedidoId);
    });
});
  // Función para cerrar el modal
  function cerrarModal() {
    document.getElementById("detallePedidoModal").style.display = "none";
}
// Función para confirmar la entrega de un pedido
function confirmarEntrega(pedidoId) {
    // Realiza las acciones necesarias para confirmar la entrega (puede incluir actualizaciones en la base de datos)
    
    // Cierra el modal
    cerrarModal();
}

