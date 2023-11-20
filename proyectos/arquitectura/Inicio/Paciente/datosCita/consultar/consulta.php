<?php
include("../../../../db.php");
try {
    
    // Verificar si se ha enviado el ID del paciente desde el método mostrarCitas() en el HTML
    if (isset($_GET['id'])) {
        $idPaciente = $_GET['id'];

        // Consulta SQL para obtener los datos de la tabla 'cita' con sus datos relacionados de 'doctor' y 'area'
        $sql = "SELECT c.idCitas, CONCAT(d.nombre, ' ', d.apellidoPaterno) AS nombreDoctor, 
        DATE_FORMAT(c.fechaHora, '%d/%m/%Y %H:%i') AS fechaHoraFormateada, c.estado AS estado, a.area AS nombreArea
        FROM cita c
        INNER JOIN doctor d ON c.idDoctor = d.idDoctor
        INNER JOIN area a ON d.idArea = a.idArea
        WHERE c.idPaciente = $idPaciente
        ORDER BY CASE c.estado
                 WHEN 'Pendiente' THEN 1
                 WHEN 'Realizado' THEN 2
                 ELSE 3
             END";

        // Ejecutar la consulta y obtener el resultado
        $resultado = $conexion->query($sql);

        // Generar el HTML con los datos obtenidos
        echo "<div class='table'>";
        echo "<div class='table-header'>";
        echo "<div class='header-item'>ID Cita</div>";
        echo "<div class='header-item'>Doctor</div>";
        echo "<div class='header-item'>Fecha y Hora</div>";
        echo "<div class='header-item'>Estado</div>";
        echo "<div class='header-item'>Área</div>";
        echo "<div class='header-item'>Acciones</div>";
        echo "</div>";

        while ($fila = $resultado->fetch_assoc()) {
            echo "<div class='table-row'>";
            echo "<div class='table-data'>" . $fila['idCitas'] . "</div>";
            echo "<div class='table-data'>" . $fila['nombreDoctor'] . "</div>";
            echo "<div class='table-data'>" . $fila['fechaHoraFormateada'] . "</div>";
            echo "<div class='table-data'>" . $fila['estado'] . "</div>";
            echo "<div class='table-data'>" . $fila['nombreArea'] . "</div>";
            echo "<div class='table-data'>
                  <button onclick=\"eliminarCita(" . $fila['idCitas'] . ")\">Eliminar</button>
                </div>";
            echo "</div>";
        }

        echo "</div>";

        // Cerrar el resultado y la conexión
        $resultado->close();
    } else {
        echo "ID de paciente no especificado.";
        exit;
    }

    $conexion->close();
} catch (Exception $e) {
    // Capturar cualquier excepción que pueda surgir
    die("Error: " . $e->getMessage());
}
?>
