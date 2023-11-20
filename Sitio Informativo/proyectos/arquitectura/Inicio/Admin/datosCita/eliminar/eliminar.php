<?php
include("../../../../db.php");
// Obtener el ID del registro a eliminar desde la solicitud AJAX
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {

        // Consulta SQL para eliminar el registro con el ID especificado
        $sql = "DELETE FROM cita WHERE idCitas = $id";

        // Ejecutar la consulta
        if ($conexion->query($sql) === TRUE) {
            echo "Registro eliminado correctamente";
        } else {
            echo "Error al eliminar el registro: " . $conexion->error;
        }

        // Cerrar la conexión
        $conexion->close();
    } catch (Exception $e) {
        // Capturar cualquier excepción que pueda surgir
        die("Error: " . $e->getMessage());
    }
}
?>
