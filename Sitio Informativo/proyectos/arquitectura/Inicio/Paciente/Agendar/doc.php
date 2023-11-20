<?php
// Verificar si se recibió el parámetro 'idArea' en la URL
if (isset($_GET['idArea'])) {
    $idArea = $_GET['idArea'];

    // Incluir el archivo de configuración y conexión de la base de datos
    include("../../../db.php");

    try {
        // Consulta SQL para obtener los doctores según el área seleccionada
        $sql = "SELECT idDoctor, nombre, apellidoPaterno FROM doctor WHERE idArea = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('i', $idArea);
        $stmt->execute();
        $result = $stmt->get_result();

        // Generar la lista de opciones para los doctores
        while ($fila = $result->fetch_assoc()) {
            echo "<option value='" . $fila['idDoctor'] . "'>" . $fila['nombre'] . " " . $fila['apellidoPaterno'] . "</option>";
        }

        $stmt->close();
        $conexion->close();
    } catch (Exception $e) {
        // Capturar cualquier excepción que pueda surgir
        echo "Error: " . $e->getMessage();
    }
}
?>
