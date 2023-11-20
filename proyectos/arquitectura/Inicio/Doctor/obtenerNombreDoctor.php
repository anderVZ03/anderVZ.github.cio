<?php
include("../../db.php");
// Obtener el doctor_id del usuario autenticado desde la sesión
session_start(); // Asegúrate de haber iniciado la sesión antes de usar variables de sesión

// Verificar si el usuario tiene una sesión activa y si la variable doctor_id está definida
// ...
// Verificar si el usuario tiene una sesión activa y si la variable doctor_id está definida
if (isset($_SESSION['user_id'])) {
    $doctor_id = $_SESSION['user_id'];


    // Consulta para obtener el nombre del doctor según su doctor_id
    $sqlDoctor = "SELECT nombre FROM doctor WHERE idDoctor = ?";
    $stmtDoctor = $conexion->prepare($sqlDoctor);
    $stmtDoctor->bind_param("i", $doctor_id);
    $stmtDoctor->execute();
    $resultDoctor = $stmtDoctor->get_result();

    // Verificar si se encontró el doctor
    if ($resultDoctor->num_rows > 0) {
        $row = $resultDoctor->fetch_assoc();
        $doctorName = $row["nombre"];

        // Devolver el nombre del doctor como respuesta JSON
        header('Content-Type: application/json');
        echo json_encode(array("doctorName" => $doctorName));
    } else {
        // Si no se encontró el doctor, devolver una respuesta de error como JSON
        header('Content-Type: application/json');
        echo json_encode(array("error" => "No se encontró el doctor con el doctor_id: $doctor_id"));
    }

    // Cerrar los statements y la conexión
    $stmtDoctor->close();
    $conexion->close();
} else {
    // Si no hay sesión activa o no se definió el doctor_id en la sesión, devolver una respuesta de error como JSON
    header('Content-Type: application/json');
    echo json_encode(array("error" => "No se encontró el doctor en la sesión."));
}

?>
