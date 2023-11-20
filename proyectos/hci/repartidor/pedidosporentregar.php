<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Agrega los enlaces a tus archivos CSS y JavaScript -->
    <link rel="stylesheet" href="/repartidor/css/pedidosporentregar.css">
    
</head>
<?php include 'header.php'; ?>
<body>
<title>Pedidos Por entregar</title>
<h1>Pedidos por entregar</h1>

<?php
session_start();
if (isset($_SESSION['id_repartidor'])) {
    // Incluir el archivo de conexión a la base de datos
    include("../db.php");

    // Consulta para obtener las facturas con datos de cliente
    $sql = "SELECT f.idFactura, f.fecha, f.total, f.direccion, c.nombre AS nombreCliente, c.apellido AS apellidoCliente
            FROM factura f
            INNER JOIN cliente c ON f.idCliente = c.idCliente
            WHERE f.estadoEntrega = false"; // Cambia el estado según tus necesidades

    $resultadoFacturas = $conexion->query($sql);

    if ($resultadoFacturas->num_rows > 0) {
        echo'<div class="titulo-fila">
        <div class="titulo-dato">Número de Pedido</div>
        <div class="titulo-dato">Fecha y Hora</div>
        <div class="titulo-dato">Total</div>
        <div class="titulo-dato">Direccion</div>
        <div class="titulo-dato">Nombre Cliente</div>
    </div>';
        while ($factura = $resultadoFacturas->fetch_assoc()) {
            $idFactura = $factura['idFactura'];
            $fecha = $factura['fecha'];
            $total = $factura['total'];
            $direccion = $factura['direccion'];
            $nombreCliente = $factura['nombreCliente'];
            $apellidoCliente = $factura['apellidoCliente'];

            // Comienza a construir la estructura HTML para mostrar los pedidos
            echo '<div class="pedido-fila" data-pedido-id="' . $idFactura . '">';
            echo '<div class="pedido-dato">#' . $idFactura . '</div>';
            echo '<div class="pedido-dato">' . $fecha . '</div>';
            echo '<div class="pedido-dato">' . $total . '</div>';
            echo '<div class="pedido-dato">' . $direccion . '</div>';
            echo '<div class="pedido-dato">' . $nombreCliente . ' ' . $apellidoCliente . '</div>';
            echo '</div>';

            
        }
    } else {
        echo '<p>No hay pedidos disponibles.</p>';
    }
} else {
    echo "No se ha iniciado sesión adecuadamente";
}
?>


 <!-- Modal para mostrar los detalles del pedido -->
<div id="detallePedidoModal" class="modal">
<div class="modal-contenido">
    <!-- Aquí se mostrarán los detalles del pedido seleccionado -->
    <h2>Detalles del Pedido</h2>
    <div class="detalle-item">
        <span class="detalle-etiqueta">Cliente:</span>
        <span class="detalle-dato" id="clienteNombre"></span>
    </div>
    <div class="detalle-item">
        <span class="detalle-etiqueta">Teléfono:</span>
        <span class="detalle-dato" id="clienteTelefono"></span>
    </div>
    <div class="detalle-item">
        <span class="detalle-etiqueta">Número de Pedido:</span>
        <span class="detalle-dato" id="numeroPedido"></span>
    </div>
    <div class="detalle-item"> 
        <span class="detalle-etiqueta">Fecha y Hora:</span>
        <span class="detalle-dato" id="fechaHora"></span>
    </div>
    <div class="detalle-item">
        <span class="detalle-etiqueta">Método de Pago:</span>
        <span class="detalle-dato" id="metodoPago"></span>
    </div>
    <div class="detalle-item">
        <span class="detalle-etiqueta">Total del Pedido:</span>
        <span class="detalle-dato" id="totalPedido"></span>
    </div>
    <div class="detalle-item">
        <span class="detalle-etiqueta">Instrucciones de Entrega:</span>
        <span class="detalle-dato" id="instruccionesEntrega"></span>
    </div>
    <!-- Agrega la dirección aquí -->
    <div class="detalle-item">
        <span class="detalle-etiqueta">Dirección:</span>
        <span class="detalle-dato" id="direccion"></span>
    </div>
    <!-- Botón para confirmar la entrega y botón para cerrar el modal -->
    <button  id="confirmarEntrega" onclick="confirmarEntrega()">Confirmar Entrega</button>
    <span class="cerrar-modal" onclick="cerrarModal()">&times;</span>
</div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="enorden.js"></script>
</body>
<?php include 'footer.php'; ?>
</html>
