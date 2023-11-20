<?php
// Datos de la base de datos
include("../../../../db.php");
try {


    // Consulta SQL para obtener los datos de la tabla 'doctor' y el nombre del área desde la tabla 'area'
    $sql = "SELECT d.idDoctor, CONCAT(d.apellidoPaterno, ' ', d.apellidoMaterno) AS Apellidos, d.nombre, d.especialidad, a.area 
            FROM doctor d
            INNER JOIN area a ON d.idArea = a.idArea";

    // Ejecutar la consulta y obtener el resultado
    $resultado = $conexion->query($sql);

    // Generar el HTML con los datos obtenidos
    echo "<div class='table'>";
    echo "<div class='table-header'>";
    echo "<div class='header-item'>ID Doctor</div>";
    echo "<div class='header-item'>Apellidos</div>";
    echo "<div class='header-item'>Nombre</div>";
    echo "<div class='header-item'>Especialidad</div>";
    echo "<div class='header-item'>Área</div>";
    echo "<div class='header-item'>Acciones</div>";
    echo "</div>";

    while ($fila = $resultado->fetch_assoc()) {
        echo "<div class='table-row'>";
        echo "<div class='table-data'>" . $fila['idDoctor'] . "</div>";
        echo "<div class='table-data'>" . $fila['Apellidos'] . "</div>";
        echo "<div class='table-data'>" . $fila['nombre'] . "</div>";
        echo "<div class='table-data'>" . $fila['especialidad'] . "</div>";
        echo "<div class='table-data'>" . $fila['area'] . "</div>";
        echo "<div class='table-data'>
                  <button onclick=\"editarDoctor(" . $fila['idDoctor'] . ")\">Editar</button>
                  <button onclick=\"eliminarDoctor(" . $fila['idDoctor'] . ")\">Eliminar</button>
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
