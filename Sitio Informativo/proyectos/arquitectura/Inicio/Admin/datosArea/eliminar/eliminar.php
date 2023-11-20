<?php
include("../../../../db.php");
// Obtener el parámetro 'area' enviado por GET
if (isset($_GET['area'])) {
    $area = $_GET['area'];
} else {
    die("Error: Parámetro 'area' no recibido.");
}

try {
    // Consulta SQL para eliminar el registro de la tabla 'area'
    $sql = "DELETE FROM area WHERE area = '" . $conexion->real_escape_string($area) . "'";

    // Ejecutar la consulta
    if ($conexion->query($sql)) {
        echo "Área eliminada correctamente.";
    } else {
        echo "Error al eliminar el área: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
} catch (Exception $e) {
    // Capturar cualquier excepción que pueda surgir
    die("Error: " . $e->getMessage());
}
?>
