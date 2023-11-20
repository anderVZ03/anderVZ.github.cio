<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Función para obtener los datos del perfil del doctor
function obtenerPerfilDoctor($idDoctor) {
    // Conectarse a la base de datos (Asegúrate de cambiar estos valores a los de tu servidor)
    include("../../db.php");
    // Preparar la consulta SQL para obtener los datos del doctor
    $stmt = $conexion->prepare('SELECT nombre, apellidoPaterno, apellidoMaterno,idArea, especialidad, correo, nacimiento FROM doctor WHERE idDoctor = ?');
    $stmt->bind_param('i', $idDoctor);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Verificar si se encontraron datos
        if ($result->num_rows > 0) {
            // Obtener los datos del doctor
            $row = $result->fetch_assoc();
            $perfilDoctor = array(
                'nombre' => $row['nombre'],
                'apellidoPaterno' => $row['apellidoPaterno'],
                'apellidoMaterno' => $row['apellidoMaterno'],
                'idArea' => $row['idArea'],
                'especialidad' => $row['especialidad'],
                'correo' => $row['correo'],
                'fechaNacimiento' => $row['nacimiento']
            );

            // Devolver los datos del perfil del doctor en formato JSON
            echo json_encode($perfilDoctor);
        } else {
            echo json_encode(array('error' => 'No se encontraron datos del doctor'));
        }
    } else {
        echo json_encode(array('error' => 'Error al obtener los datos del doctor'));
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conexion->close();
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array('error' => 'No se ha iniciado sesión'));
    exit;
}

// Obtener el ID del doctor desde la sesión
$idDoctor = $_SESSION['user_id'];

// Verificar si se recibió una solicitud de obtener el perfil del doctor
if (isset($_GET['accion']) && $_GET['accion'] === 'perfil') {
    // Obtener y devolver los datos del perfil del doctor
    obtenerPerfilDoctor($idDoctor);
    exit;
}

// Si no se recibió ninguna acción válida, enviar un mensaje de error
echo json_encode(array('error' => 'Acción inválida'));
?>
