<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificamos si se recibieron los datos correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
    // Conectarse a la base de datos (Asegúrate de cambiar estos valores a los de tu servidor)
    include("../../db.php");

    // Obtenemos los datos enviados desde el cliente y los decodificamos desde formato JSON
    $datos = json_decode($_POST['data'], true);
    $diasSemana = $datos['diasSemana'];
    $horaInicio = $datos['horaInicio'];
    $horaFin = $datos['horaFin'];

    // Preparamos la consulta SQL para insertar el horario en la base de datos
    $stmt = $conexion->prepare('INSERT INTO disponibilidad (idDoctor, diaSemana, tiempoInicio, tiempoFin) VALUES (?, ?, ?, ?)');

    // Obtenemos el idDoctor (asumiremos que ya lo tienes, reemplaza "TU_ID_DOCTOR" con el valor correcto)
    session_start();
    $idDoctor = $_SESSION['user_id'];

    // Asociamos los parámetros a la consulta
    $stmt->bind_param('isss', $idDoctor, $diaSemana, $horaInicio, $horaFin);

    // Iteramos sobre los días seleccionados y guardamos el horario para cada día
    foreach ($diasSemana as $diaSemana) {
        $stmt->execute();
    }

    // Cerramos la conexión y liberamos recursos
    $stmt->close();
    $conexion->close();

    // Enviamos una respuesta de éxito al cliente
    echo '¡Horario guardado correctamente!';
} else {
    // Si no se reciben datos o no es una solicitud POST válida, enviamos un mensaje de error
    echo 'Error: La solicitud es inválida.';
}
?>
