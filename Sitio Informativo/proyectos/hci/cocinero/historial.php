
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cocinero/css/pedidos.css">
    <title>Historial de Pedidos</title>
</head>
<?php include 'header.php'; ?>
<body>
    
    <h1>Historial de Pedidos</h1>
    <div class="orders-container" id="ordersContainer">
        <!-- No incluimos el botón "Ver Historial" aquí -->
        <?php
            session_start();
            if (isset($_SESSION['id_cocinero'])){
            // Consulta para obtener las facturas pagadas (estado = true)
            include ("../db.php");

            $sql = "SELECT idFactura, fecha, total, direccion FROM factura WHERE estado = true";
            $resultadoFacturas = $conexion->query($sql);

            if ($resultadoFacturas->num_rows > 0) {
                while ($factura = $resultadoFacturas->fetch_assoc()) {
                    $idFactura = $factura['idFactura'];
                    $fecha = $factura['fecha'];
                    $total = $factura['total'];
                    $direccion = $factura['direccion'];
                    // Comienza a construir la estructura HTML para mostrar los pedidos
                    echo '<div class="order-item">';
                    echo '<div class="order-info">';
                    echo "<p><strong>Pedido #$idFactura</strong> - Fecha: $fecha - Total: $$total</p>";
                    echo '</div>';
                    echo '<div class="order-actions">';
                    echo '</div>';
                    // Consulta para obtener los productos asociados a esta factura desde la tabla facpro
                    $sqlProductos = "SELECT p.nombre AS producto, fp.cantidadProducto, p.precio FROM facpro fp INNER JOIN producto p ON fp.idProducto = p.idProducto
                    WHERE fp.idFactura = ?";

                    $consultaProductos = $conexion->prepare($sqlProductos);
                    $consultaProductos->bind_param("i", $idFactura);
                    $consultaProductos->execute();
                    $resultadoProductos = $consultaProductos->get_result();

                    if ($resultadoProductos->num_rows > 0) {

                    // Muestra los detalles del pedido en una tabla
                    echo '<div class="order-details">';
                    echo '<table class="order-table">';
                    echo '<tr><th>Producto</th><th>Cantidad</th><th>Precio</th></tr>';
                    while ($producto = $resultadoProductos->fetch_assoc()) {
                        $nombreProducto = $producto['producto'];
                        $cantidadProducto = $producto['cantidadProducto'];
                        $precioProducto = $producto['precio'];
                        echo "<tr><td>$nombreProducto</td><td>$cantidadProducto</td><td>$$precioProducto</td></tr>";
                    }

                    echo '<tr class="total-row"><td colspan="2"><strong></strong></td><td>'.$total.'</td></tr>';
                    echo '</table>';
                    echo '</div>';

                    // Cierra el div de order-item
                    
                }echo '</div>';
                }
            } else {
                echo '<p>No hay pedidos disponibles.</p>';
            }}else{
                echo "No se ha iniciado sesion adecuadamente";
            }
            ?>
            </div>            
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/pedidosencurso.js"></script>


</body>
<?php include 'footer.php'; ?>
</html>

