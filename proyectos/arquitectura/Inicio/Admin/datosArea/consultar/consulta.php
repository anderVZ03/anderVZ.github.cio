<?php
// Datos de la base de datos
include("../../../../db.php");
try {
    // Consulta SQL para obtener los datos de la tabla 'area'
    $sql = "SELECT area FROM area";

    // Ejecutar la consulta y obtener el resultado
    $resultado = $conexion->query($sql);

    // Generar el HTML con los datos obtenidos
    echo "<div class='table'>";
    echo "<div class='table-header'>";
    echo "<div class='header-item'>Área</div>";
    echo "<div class='header-item'>Acciones</div>";
    echo "</div>";

    while ($fila = $resultado->fetch_assoc()) {
        echo "<div class='table-row'>";
        echo "<div class='table-data'>" . $fila['area'] . "</div>";
        echo "<div class='table-data'>
              <button onclick=\"eliminarArea('" . $fila['area'] . "')\">Eliminar</button>
            </div>";
        echo "</div>";
    }

    echo "</div>";

    // Cerrar el resultado y la conexión
    $resultado->close();
    $conexion->close();
} catch (Exception $e) {
    // Capturar cualquier excepción que pueda surgir
    die("Error: " . $e->getMessage());
}
?>
