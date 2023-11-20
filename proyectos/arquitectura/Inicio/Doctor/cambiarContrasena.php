<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Verificamos si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array('error' => 'No se ha iniciado sesión'));
    exit;
}

// Verificamos si se recibieron los datos correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del doctor desde la sesión
    $idDoctor = $_SESSION['user_id'];

    // Leer los datos en formato JSON desde el cuerpo de la solicitud
    $postData = json_decode(file_get_contents('php://input'), true);

    // Obtener la nueva contraseña y confirmar contraseña del formulario
    $nuevaContrasena = $postData['nuevaContrasena'];
    $confirmarContrasena = $postData['confirmarContrasena'];

    // Verificar que las contraseñas ingresadas coincidan
    if (empty($confirmarContrasena) || $nuevaContrasena !== $confirmarContrasena) {
        echo json_encode(array('error' => 'Las contraseñas no coinciden'));
        exit;
    }

    include("../../db.php");
    // Preparar la consulta SQL para actualizar la contraseña
    $stmt = $conexion->prepare('UPDATE doctor SET contrasena = ? WHERE idDoctor = ?');
    $stmt->bind_param('si', $nuevaContrasena, $idDoctor);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(array('success' => 'Contraseña actualizada correctamente'));
    } else {
        echo json_encode(array('error' => 'Error al actualizar la contraseña'));
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conexion->close();
} else {
    // Si no se reciben datos o no es una solicitud POST válida, enviamos un mensaje de error
    echo json_encode(array('error' => 'Error: La solicitud es inválida'));
}
?>
