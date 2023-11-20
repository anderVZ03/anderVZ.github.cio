<?php
if (isset($_POST['submit'])) {
    try {
        include("../../../../db.php");
        $idPaciente = $_POST['paciente'];
        $idDoctor = $_POST['doctor'];
        $fechaHora = $_POST['fecha_hora'];
        $estado = "Pendiente"; // Estado predeterminado para una nueva cita

        // Verificar si los valores de idPaciente y idDoctor son numéricos válidos
        if (!is_numeric($idPaciente) || !is_numeric($idDoctor)) {
            throw new Exception("Los valores de idPaciente y idDoctor deben ser numéricos.");
        }

        // Consultar si existen los idPaciente y idDoctor en sus respectivas tablas
        $sql_verificar_paciente = "SELECT idPaciente FROM paciente WHERE idPaciente = ?";
        $stmt_verificar_paciente = $conexion->prepare($sql_verificar_paciente);
        $stmt_verificar_paciente->bind_param('i', $idPaciente);
        $stmt_verificar_paciente->execute();
        $stmt_verificar_paciente->store_result();

        $sql_verificar_doctor = "SELECT idDoctor FROM doctor WHERE idDoctor = ?";
        $stmt_verificar_doctor = $conexion->prepare($sql_verificar_doctor);
        $stmt_verificar_doctor->bind_param('i', $idDoctor);
        $stmt_verificar_doctor->execute();
        $stmt_verificar_doctor->store_result();

        if (!$stmt_verificar_paciente->num_rows || !$stmt_verificar_doctor->num_rows) {
            throw new Exception("El idPaciente o el idDoctor seleccionados no existen en la base de datos.");
        }

        // Realizar la inserción en la tabla cita
        $sql = "INSERT INTO cita (idPaciente, idDoctor, fechaHora, estado) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('iiss', $idPaciente, $idDoctor, $fechaHora, $estado);
        $stmt->execute();

        // Redireccionar a la página de inicio con un mensaje de éxito
        header('Location: ../../paginaInicio.html?mensaje=1');
        $conexion->close();
        exit(); // Asegurarse de que el script se detenga después de la redirección
    } catch (PDOException $e) {
        echo "Error de conexión con la base de datos: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "HOLA";
}
?>
