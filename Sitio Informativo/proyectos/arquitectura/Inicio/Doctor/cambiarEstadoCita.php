<?php
include("../../db.php");
// Obtener el idCita enviado desde la solicitud AJAX
if (isset($_POST['idCita'])) {
    $idCita = $_POST['idCita'];


    // Verificar si la opción enviada es "eliminar"
    if (isset($_POST['option']) && $_POST['option'] === 'eliminar') {
        // Consulta para eliminar la cita
        $sqlEliminarCita = "DELETE FROM cita WHERE idCitas = $idCita";

        if ($conexion->query($sqlEliminarCita) === TRUE) {
            // Si la eliminación se realizó correctamente, enviar una respuesta de éxito
            echo json_encode(array("success" => true));
        } else {
            // Si hubo un error al eliminar la cita, enviar una respuesta de error
            echo json_encode(array("success" => false, "message" => "Error al eliminar la cita."));
        }
    } else {
        // Consulta para actualizar el estado de la cita a "Realizado"
        $sqlActualizarEstado = "UPDATE cita SET estado = 'Realizado' WHERE idCitas = $idCita";

        if ($conexion->query($sqlActualizarEstado) === TRUE) {
            // Si la actualización se realizó correctamente, enviar una respuesta de éxito
            echo json_encode(array("success" => true));
        } else {
            // Si hubo un error al actualizar el estado, enviar una respuesta de error
            echo json_encode(array("success" => false, "message" => "Error al actualizar el estado de la cita."));
        }
    }

    // Cerrar la conexión
    $conexion->close();
} else {
    // Si no se proporcionó el idCita, enviar una respuesta de error
    echo json_encode(array("success" => false, "message" => "ID de cita no proporcionado."));
}
?>
