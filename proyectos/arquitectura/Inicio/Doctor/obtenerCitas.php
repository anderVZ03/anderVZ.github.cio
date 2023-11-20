<?php
// Datos de conexión a la base de datos
include("../../db.php");
// Verificar la conexión
// Obtener el doctor_id del usuario autenticado desde la sesión
session_start();
$doctor_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idCita'])) {
        $idCita = $_POST['idCita'];
        $sqlEliminarCita = "DELETE FROM cita WHERE idCitas = $idCita";
        if ($conexion->query($sqlEliminarCita) === TRUE) {
            // Si la eliminación se realizó correctamente, enviar una respuesta de éxito
            echo "Registro eliminado correctamente";
            exit;
        } else {
            // Si hubo un error al eliminar la cita, enviar una respuesta de error
            echo "Error al eliminar la cita." . $conexion->error;
            exit;
        }
    }
}

// Consulta para obtener las citas pendientes del doctor actual
$sqlPendientes = "SELECT c.idCitas, c.fechaHora, p.nombre, p.apellidoPaterno, c.estado FROM cita c
        INNER JOIN paciente p ON c.idPaciente = p.idPaciente
        WHERE c.estado = 'Pendiente' AND c.idDoctor = $doctor_id";

$resultPendientes = $conexion->query($sqlPendientes);

// Consulta para obtener las citas realizadas del doctor actual
$sqlRealizadas = "SELECT c.idCitas, c.fechaHora, p.nombre, p.apellidoPaterno, c.estado FROM cita c
        INNER JOIN paciente p ON c.idPaciente = p.idPaciente
        WHERE c.estado = 'Realizado' AND c.idDoctor = $doctor_id";

$resultRealizadas = $conexion->query($sqlRealizadas);

// Preparar los datos para enviarlos a JavaScript
$response = array(
    "pendientes" => array(),
    "realizados" => array()
);

if ($resultPendientes->num_rows > 0) {
    while ($row = $resultPendientes->fetch_assoc()) {
        $response["pendientes"][] = array(
            "idCita" => $row["idCitas"],
            "fechaHora" => $row["fechaHora"],
            "paciente" => $row["nombre"] . " " . $row["apellidoPaterno"],
            "estado" => $row["estado"]
        );
    }
}

if ($resultRealizadas->num_rows > 0) {
    while ($row = $resultRealizadas->fetch_assoc()) {
        $response["realizados"][] = array(
            "idCita" => $row["idCitas"],
            "fechaHora" => $row["fechaHora"],
            "paciente" => $row["nombre"] . " " . $row["apellidoPaterno"],
            "estado" => $row["estado"]
        );
    }
}

// Enviar los datos como JSON
header('Content-Type: application/json');
echo json_encode($response);

// Cerrar la conexión
$conexion->close();
?>
