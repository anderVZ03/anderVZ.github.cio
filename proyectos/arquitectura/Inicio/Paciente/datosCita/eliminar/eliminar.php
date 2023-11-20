<?php
include("../../../../db.php");
try {
    // Verificar si se ha enviado el ID de la cita a eliminar desde la solicitud AJAX
    if (isset($_POST['id'])) {
        $idCita = $_POST['id'];

        // Consulta SQL para eliminar la cita
        $sqlDelete = "DELETE FROM cita WHERE idCitas = $idCita";

        // Ejecutar la consulta de eliminación
        if ($conexion->query($sqlDelete) === TRUE) {
            echo "Cita eliminada con éxito.";
        } else {
            echo "Error al eliminar la cita: " . $conexion->error;
        }

        // Cerrar la conexión
        $conexion->close();
    } else {
        echo "ID de cita no especificado.";
        exit;
    }
} catch (Exception $e) {
    // Capturar cualquier excepción que pueda surgir
    die("Error: " . $e->getMessage());
}
?>
