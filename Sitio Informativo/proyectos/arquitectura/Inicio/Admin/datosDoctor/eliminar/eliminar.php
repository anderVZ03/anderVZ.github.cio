<?php
// Datos de la base de datos
include("../../../../db.php");

try {

    // Obtener el ID del doctor a eliminar desde el parámetro GET
    $idDoctor = $_GET['idDoctor'];

    // Consulta SQL para eliminar el registro del doctor
    $sql = "DELETE FROM doctor WHERE idDoctor = $idDoctor";

    // Ejecutar la consulta
    if ($conexion->query($sql)) {
        // El registro se eliminó correctamente
        echo "Registro eliminado con éxito.";
    } else {
        // Hubo un error al eliminar el registro
        echo "Error al eliminar el registro: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
} catch (Exception $e) {
    // Capturar cualquier excepción que pueda surgir
    die("Error: " . $e->getMessage());
}
?>
