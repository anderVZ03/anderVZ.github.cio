<?php
session_start();
if (isset($_SESSION['id_administrador'])) {

// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados por el formulario
    $idCliente = $_POST['idCliente'];
    $nuevoNombre = $_POST['nombre'];
    $nuevoApellido = $_POST['apellido'];
    $nuevoUsuario = $_POST['usuario'];
    $nuevaFechaNacimiento = $_POST['fechaNacimiento'];
    $nuevaContrasena = $_POST['contrasena'];

    // Realizar la conexión a la base de datos (ajusta las credenciales según tu configuración)
    $servername = "localhost";
    $username = "root";
    $password = "Ander2003.";
    $dbname = "restaurante";

    $conexion = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Preparar una consulta SQL para actualizar los datos del cocinero
    $sql = "UPDATE cliente SET nombre=?, apellido=?, fechaNacimiento=? WHERE usuario=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $nuevoNombre, $nuevoApellido, $nuevaFechaNacimiento, $nuevoUsuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Éxito al actualizar
        $response = array(
            "success" => true,
            "message" => "Datos del cocinero actualizados correctamente."
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Error al actualizar
        $response = array(
            "success" => false,
            "message" => "Error al actualizar los datos del cocinero: " . $stmt->error
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    // La solicitud no es de tipo POST, puedes manejarlo según tus necesidades
    header('HTTP/1.1 405 Method Not Allowed');
    exit('Método no permitido');
}

} else {
    header('Content-Type: application/json');
    echo json_encode(array("error" => "No se ha iniciado sesión"));
    exit();
}
?>