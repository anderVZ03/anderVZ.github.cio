<?php
// Verificamos si la sesión está iniciada
session_start();
if (!isset($_SESSION['user_id'])) {
    // Si no hay una sesión iniciada, devolvemos un mensaje de error
    echo json_encode(array('error' => 'No se ha iniciado sesión'));
    exit;
}

include("../../db.php");
// Verificamos si se ha recibido el ID del horario a eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idDisponibilidad'])) {
        $idDisponibilidad = $_POST['idDisponibilidad'];
        $sqlEliminarHorario = "DELETE FROM disponibilidad WHERE idDisponibilidad = $idDisponibilidad";
        if ($conexion->query($sqlEliminarHorario) === TRUE) {
            // Si la eliminación se realizó correctamente, enviar una respuesta de éxito
            echo json_encode(array('success' => 'Horario eliminado exitosamente'));
            exit;
        } else {
            // Si hubo un error al eliminar el horario, enviar una respuesta de error
            echo json_encode(array('error' => 'Error al eliminar el horario.' . $conexion->error));
            exit;
        }
    }
}

// Consulta SQL para obtener los horarios del doctor actual
$idDoctor = $_SESSION['user_id'];
$sql = "SELECT * FROM disponibilidad WHERE idDoctor = $idDoctor";

$result = $conexion->query($sql);

// Creamos un array para almacenar los horarios
$horarios = array();

// Verificamos si hay resultados y los agregamos al array
if ($result->num_rows > 0) {
    // Array para mapear números de días a nombres de días
    $diasSemanaNumeros = array(
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo'
    );

    while ($row = $result->fetch_assoc()) {
        $diaSemana = $diasSemanaNumeros[intval($row['diaSemana'])]; // Convertir número de día a nombre de día
        $horarios[] = array(
            'idDisponibilidad' => $row['idDisponibilidad'],
            'diaSemana' => $diaSemana,
            'tiempoInicio' => $row['tiempoInicio'],
            'tiempoFin' => $row['tiempoFin']
        );
    }
}

// Cerramos la conexión y liberamos recursos
$conexion->close();

// Devolvemos los horarios como respuesta en formato JSON
echo json_encode($horarios);
?>
