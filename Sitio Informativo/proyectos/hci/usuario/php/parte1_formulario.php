<?php
session_start();
if (isset($_SESSION['id_cliente'])) {
    if (isset($_SESSION['idFactura'])) {
        // La factura ya existe, no es necesario crear una nueva
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Factura existente']);
        exit();
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCliente = $_SESSION['id_cliente'];
            include("../../db.php");

            $tipoCompra = $_POST['tipo-compra'];
            if ($tipoCompra === 'domicilio') {
                // Recopilar datos de entrega
                $direccion = $_POST['direccion'];
                $ciudad = $_POST['ciudad'];
                $telefono = $_POST['telefono'];
                $instrucciones = ''; // Asegúrate de obtener las instrucciones del formulario

                // Crear un registro de factura con los datos disponibles
                $insertarFactura = "INSERT INTO factura (idCliente, instrucciones, direccion, metodo,estado) 
                                    VALUES (?, ?, ?, ?,0)";

                // Preparar la consulta
                $stmt = $conexion->prepare($insertarFactura);

                // Enlazar los parámetros
                $stmt->bind_param("isss", $idCliente, $ciudad, $direccion, $tipoCompra);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    // Obtener el idFactura generado después de la inserción
                    $idFactura = $stmt->insert_id;

                    // Actualizar el número de teléfono en la tabla cliente
                    $actualizarTelefono = "UPDATE cliente SET telefono = ? WHERE idCliente = ?";
                    $stmt = $conexion->prepare($actualizarTelefono);

                    // Enlazar los parámetros
                    $stmt->bind_param("si", $telefono, $idCliente);

                    // Ejecutar la consulta de actualización
                    $stmt->execute();

                    // Guardar el idFactura en la sesión para su uso posterior
                    $_SESSION['idFactura'] = $idFactura;

                    // Obtener el carrito de la sesión
                    $carrito = $_SESSION['carrito'];

                    // Inicializar el total de la compra
                    $totalCompra = 0;
                    // Recorrer el carrito y agregar productos a la tabla facpro
                    foreach ($carrito as $producto) {
                        $nombreProducto = $producto['producto'];
                        $cantidad = $producto['cantidad'];

                        // Consultar la tabla producto para obtener el idProducto
                        $consultaProducto = "SELECT idProducto, precio FROM producto WHERE nombre = ?";
                        $stmt = $conexion->prepare($consultaProducto);
                        $stmt->bind_param("s", $nombreProducto);
                        $stmt->execute();
                        $stmt->bind_result($idProducto, $precioProducto);
                        $stmt->fetch();
                        $stmt->close();

                        // Insertar detalles del producto en la tabla facpro
                        $insertarFacpro = "INSERT INTO facpro (idFactura, idProducto, cantidadProducto, estado) 
                                        VALUES (?, ?, ?,1)";
                        $stmt = $conexion->prepare($insertarFacpro);
                        $stmt->bind_param("iii", $idFactura, $idProducto, $cantidad);
                        $stmt->execute();

                        // Calcular el total del producto y agregarlo al total de la compra
                        $totalProducto = $precioProducto * $cantidad;
                        $totalCompra += $totalProducto;
                    }

                    // Actualizar el total de la factura
                    $actualizarTotalFactura = "UPDATE factura SET total = ? WHERE idFactura = ?";
                    $stmt = $conexion->prepare($actualizarTotalFactura);
                    $stmt->bind_param("di", $totalCompra, $idFactura);
                    $stmt->execute();

                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Factura creada con éxito']);
                    exit();
                }
            } else if ($tipoCompra === 'para-llevar' || $tipoCompra === 'consumir-en-local') {
                $insertarFactura = "INSERT INTO factura (idCliente, direccion, metodo,estado) 
                VALUES (?, 'Local', ?,0)";

                $stmt = $conexion->prepare($insertarFactura);

                // Enlazar los parámetros
                $stmt->bind_param("is", $idCliente, $tipoCompra);

                // Ejecutar la consulta
                    $stmt->execute();
                    $idFactura = $stmt->insert_id;
                    $_SESSION['idFactura'] = $idFactura;
                    
                    // Guardar el idFactura en la sesión para su uso posterior
                    // Obtener el carrito de la sesión
                    $carrito = $_SESSION['carrito'];

                    // Inicializar el total de la compra
                    $totalCompra = 0;
                    // Recorrer el carrito y agregar productos a la tabla facpro
                    foreach ($carrito as $producto) {
                        $nombreProducto = $producto['producto'];
                        $cantidad = $producto['cantidad'];

                        // Consultar la tabla producto para obtener el idProducto
                        $consultaProducto = "SELECT idProducto, precio FROM producto WHERE nombre = ?";
                        $stmt = $conexion->prepare($consultaProducto);
                        $stmt->bind_param("s", $nombreProducto);
                        $stmt->execute();
                        $stmt->bind_result($idProducto, $precioProducto);
                        $stmt->fetch();
                        $stmt->close();

                        // Insertar detalles del producto en la tabla facpro
                        $insertarFacpro = "INSERT INTO facpro (idFactura, idProducto, cantidadProducto, estado) 
                                        VALUES (?, ?, ?, 1)";
                        $stmt = $conexion->prepare($insertarFacpro);
                        $stmt->bind_param("iii", $idFactura, $idProducto, $cantidad);
                        $stmt->execute();

                        // Calcular el total del producto y agregarlo al total de la compra
                        $totalProducto = $precioProducto * $cantidad;
                        $totalCompra += $totalProducto;
                    }

                    // Actualizar el total de la factura
                    $actualizarTotalFactura = "UPDATE factura SET total = ? WHERE idFactura = ?";
                    $stmt = $conexion->prepare($actualizarTotalFactura);
                    $stmt->bind_param("di", $totalCompra, $idFactura);
                    $stmt->execute();

                    
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Factura creada con éxito']);
                    exit();
                
                // Es una compra diferente de entrega, puedes hacer lo necesario
                // para manejar esta situación, como crear el registro de factura
                // sin información de dirección de entrega y redirigir al siguiente paso.
                }
                // Tu código para estas opciones
            
        } else {
            // La solicitud no es ni POST ni GET, puedes manejarla según tus necesidades
            header('HTTP/1.1 405 Method Not Allowed');
            exit('Método no permitido');
        }
    }
} else {
    echo "No se ha podido encontrar el idFactura " . $_SESSION['idFactura'];
}
?>
