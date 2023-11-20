<?php
// Datos de la base de datos
include("../../../../db.php");
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["idPaciente"])) {
    $idPaciente = $_GET["idPaciente"];

    try {
        // Consulta SQL para eliminar el paciente de la tabla 'paciente'
        $sql = "DELETE FROM paciente WHERE idPaciente = $idPaciente";

        // Ejecutar la consulta
        if ($conexion->query($sql)) {
            // El paciente se eliminó correctamente
            echo "Paciente eliminado con éxito.";
        } else {
            // Hubo un error al eliminar el paciente
            echo "Error al eliminar el paciente: " . $conexion->error;
        }

        // Cerrar la conexión
        $conexion->close();
    } catch (Exception $e) {
        // Capturar cualquier excepción que pueda surgir
        die("Error: " . $e->getMessage());
    }
} else {
    // Si no se proporcionó el ID del paciente, mostrar un mensaje de error
    echo "No se proporcionó el ID del paciente.";
}
?>
