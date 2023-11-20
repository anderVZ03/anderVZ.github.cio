<?php
include("../../../../db.php");
try {

    // Consulta SQL para obtener los datos de la tabla 'paciente' y calcular la edad
    $sql = "SELECT idPaciente, CONCAT(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno) AS NombreCompleto, canton, direccion,
            TIMESTAMPDIFF(YEAR, nacimiento, CURDATE()) AS Edad FROM paciente";

    // Ejecutar la consulta y obtener el resultado
    $resultado = $conexion->query($sql);

    // Generar el HTML con los datos obtenidos
    echo "<div class='table'>";
    echo "<div class='table-header'>";
    echo "<div class='header-item'>ID Paciente</div>";
    echo "<div class='header-item'>Nombre</div>"; // Nueva columna para mostrar el nombre completo del paciente
    echo "<div class='header-item'>Cantón</div>";
    echo "<div class='header-item'>Dirección</div>";
    echo "<div class='header-item'>Edad</div>";
    echo "<div class='header-item'>Acciones</div>"; // Nueva columna para los botones de "Editar" y "Eliminar"
    echo "</div>";

    while ($fila = $resultado->fetch_assoc()) {
        echo "<div class='table-row'>";
        echo "<div class='table-data'>" . $fila['idPaciente'] . "</div>";
        echo "<div class='table-data'>" . $fila['NombreCompleto'] . "</div>";
        echo "<div class='table-data'>" . $fila['canton'] . "</div>";
        echo "<div class='table-data'>" . $fila['direccion'] . "</div>";
        echo "<div class='table-data'>" . $fila['Edad'] . " años</div>";
        echo "<div class='table-data'>
                  <button onclick=\"editarPaciente(" . $fila['idPaciente'] . ")\">Editar</button>
                  <button onclick=\"eliminarPaciente(" . $fila['idPaciente'] . ")\">Eliminar</button>
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
