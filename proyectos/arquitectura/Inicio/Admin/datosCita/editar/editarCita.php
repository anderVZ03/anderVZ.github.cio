<?php
// Datos de la base de datos
include("../../../../db.php");
try {

    // Verificar si se ha enviado el formulario para actualizar la cita
    if (isset($_POST['idCitas']) && isset($_POST['fechaHora']) && isset($_POST['estado'])) {
        $idCitas = $_POST['idCitas'];
        $fechaHora = $_POST['fechaHora'];
        $estado = $_POST['estado'];

        // Actualizar la cita en la base de datos
        $sqlUpdate = "UPDATE cita SET fechaHora = '$fechaHora', estado = '$estado' WHERE idCitas = $idCitas";

        if ($conexion->query($sqlUpdate) === TRUE) {
            echo '<script>alert("Cita actualizada con éxito."); window.location.href = "../../paginaInicio.html";</script>';
            exit;
        } else {
            echo "Error al actualizar la cita: " . $conexion->error;
        }
    }

    // Obtener el ID de la cita a editar desde la URL
    if (isset($_GET['id'])) {
        $idCitas = $_GET['id'];

        // Consulta SQL para obtener los datos de la cita y sus claves foráneas
        $sql = "SELECT c.idCitas, c.idPaciente, c.idDoctor, c.fechaHora, c.estado, p.nombre AS nombrePaciente, p.apellidoPaterno AS apellidoPaternoPaciente, d.nombre AS nombreDoctor, d.apellidoPaterno AS apellidoPaternoDoctor, d.especialidad 
                FROM cita c
                INNER JOIN paciente p ON c.idPaciente = p.idPaciente
                INNER JOIN doctor d ON c.idDoctor = d.idDoctor
                WHERE c.idCitas = $idCitas";

        // Ejecutar la consulta y obtener el resultado
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            // Obtener datos de la cita
            $idPaciente = $fila['idPaciente'];
            $idDoctor = $fila['idDoctor'];
            $fechaHora = $fila['fechaHora'];
            $estado = $fila['estado'];

            // Obtener datos del paciente
            $nombrePaciente = $fila['nombrePaciente'];
            $apellidoPaternoPaciente = $fila['apellidoPaternoPaciente'];

            // Obtener datos del doctor
            $nombreDoctor = $fila['nombreDoctor'];
            $apellidoPaternoDoctor = $fila['apellidoPaternoDoctor'];
            $especialidadDoctor = $fila['especialidad'];

            // Concatenar apellido paterno con nombre para mostrarlos
            $nombreCompletoPaciente = $nombrePaciente . " " . $apellidoPaternoPaciente;
            $nombreCompletoDoctor = $nombreDoctor . " " . $apellidoPaternoDoctor;
        } else {
            echo "Cita no encontrada.";
            exit;
        }
    } else {
        echo "ID de cita no especificado.";
        exit;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();

} catch (Exception $e) {
    // Capturar cualquier excepción que pueda surgir
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Información de la Cita</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Información de la Cita</h2>
        <form action="" method="POST">
            <label for="paciente">Paciente:</label>
            <input type="text" id="paciente" name="paciente" value="<?php echo $nombreCompletoPaciente; ?>" readonly>

            <label for="doctor">Doctor:</label>
            <input type="text" id="doctor" name="doctor" value="<?php echo $nombreCompletoDoctor; ?>" readonly>

            <label for="fechaHora">Fecha y Hora:</label>
            <input type="datetime-local" id="fechaHora" name="fechaHora" value="<?php echo date('Y-m-d\TH:i', strtotime($fechaHora)); ?>" required min="" /><br><br>
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <option value="Pendiente" <?php echo ($estado === "Pendiente") ? "selected" : ""; ?>>Pendiente</option>
                <option value="Realizada" <?php echo ($estado === "Realizada") ? "selected" : ""; ?>>Realizada</option>
            </select>

            <input type="hidden" name="idCitas" value="<?php echo $idCitas; ?>">
            <input type="submit" value="Actualizar Cita">
        </form>
    </div>
    <script>
        // Obtener la fecha y hora actual
        const fechaActual = new Date();
        const anio = fechaActual.getFullYear();
        const mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0');
        const dia = fechaActual.getDate().toString().padStart(2, '0');
        const hora = fechaActual.getHours().toString().padStart(2, '0');
        const minutos = fechaActual.getMinutes().toString().padStart(2, '0');

        // Formatear la fecha y hora mínima como requerida por el atributo min
        const fechaMinima = `${anio}-${mes}-${dia}T${hora}:${minutos}`;

        // Establecer el valor del atributo min del input de fecha y hora
        document.getElementById('fecha_hora').min = fechaMinima;
    </script>
</body>
</html>
