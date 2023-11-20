<?php
// Inicia la sesión si aún no está iniciada
session_start();

// Verifica si el usuario ha iniciado sesión (ajusta según tu lógica de autenticación)
if (!isset($_SESSION['id_cocinero'])) {
    $response = array(
        'status' => 'error',
        'message' => 'No se ha iniciado sesión adecuadamente.'
    );
} else {
    // Verifica si se proporcionó el ID de la factura a través de POST
    if (isset($_POST['idFactura'])) {
        // Obtiene el ID de la factura desde la solicitud AJAX
        $idFactura = $_POST['idFactura'];

        // Realiza la actualización del estado en la base de datos
        // Supongamos que tienes una tabla llamada "factura" con una columna "estado"
        // Aquí utilizamos un valor 1 para "listo" y 0 para "pendiente" (ajusta según tu base de datos)
        include("../../db.php"); // Asegúrate de incluir tu archivo de conexión a la base de datos

        // Consulta SQL para actualizar el estado de la factura
        $sqlActualizarEstado = "UPDATE factura SET estado = 1 WHERE idFactura = ?";

        // Preparar la consulta
        $stmt = $conexion->prepare($sqlActualizarEstado);

        // Vincular el parámetro $idFactura a la consulta
        $stmt->bind_param("i", $idFactura);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // La actualización se realizó con éxito
            $response = array(
                'status' => 'success',
                'message' => 'Estado cambiado con éxito.'
            );
        } else {
            // Hubo un error en la actualización
            $response = array(
                'status' => 'error',
                'message' => 'Error al cambiar el estado del pedido.'
            );
        }

        // Cierra la conexión a la base de datos
        $stmt->close();
        $conexion->close();
    } else {
        // Si no se proporcionó el ID de la factura en la solicitud AJAX
        $response = array(
            'status' => 'error',
            'message' => 'Error: No se proporcionó el ID de la factura.'
        );
    }
}

// Devuelve la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
