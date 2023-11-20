<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está autenticado, si no, redirigir o mostrar un mensaje de error
if (!isset($_SESSION['id_repartidor'])) {
    echo json_encode(["error" => "No se ha iniciado sesión adecuadamente"]);
    exit;
}

// Incluir el archivo de conexión a la base de datos (reemplaza con tu ruta)
include("../../db.php");
if (isset($_POST['confirmarEntrega']) && isset($_POST['pedidoId'])) {
    $pedidoId = $_POST['pedidoId'];

    // Consulta SQL para actualizar el estado de entrega
    $sqlActualizarEntrega = "UPDATE factura SET estadoEntrega = 1 WHERE idFactura = ?";
    $stmtActualizarEntrega = $conexion->prepare($sqlActualizarEntrega);
    $stmtActualizarEntrega->bind_param("i", $pedidoId);

    if ($stmtActualizarEntrega->execute()) {
        echo json_encode(["success" => "Entrega confirmada con éxito"]);
    } else {
        echo json_encode(["error" => "Error al confirmar la entrega"]);
    }

    // Cierra la conexión a la base de datos
    $stmtActualizarEntrega->close();
    $conexion->close();
    exit;
}
// Obtén el ID del pedido desde la solicitud POST (debes validar y sanitizar esto)
$pedidoId = $_POST['pedidoId'];

// Consulta SQL para obtener los datos del pedido y del cliente asociado, incluyendo el método de pago
$sql = "SELECT f.idFactura, f.fecha, f.total, f.direccion, f.estado, f.estadoEntrega, f.instrucciones, f.metodo, 
               c.nombre AS clienteNombre, c.apellido AS clienteApellido, c.telefono AS clienteTelefono
        FROM factura f
        INNER JOIN cliente c ON f.idCliente = c.idCliente
        WHERE f.idFactura = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $pedidoId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pedido = $result->fetch_assoc();

    // Devuelve los datos del pedido como una respuesta JSON
    echo json_encode($pedido);
} else {
    echo json_encode(["error" => "Pedido no encontrado"]);
}

// Cierra la conexión a la base de datos
$stmt->close();
$conexion->close();
?>
