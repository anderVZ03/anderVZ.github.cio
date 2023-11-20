<?php
session_start();
if (isset($_SESSION['id_administrador'])) {
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $fechaNacimiento = $_POST['fecha'];
    $telefono=$_POST['telefono'];
    $contrasena = $_POST['contrasena'];
    $nivel = $_POST['nivel'];

    // Ejemplo de conexión a la base de datos (ajusta las credenciales según tu configuración)
    $servername = "localhost";
    $username = "root";
    $password = "Ander2003.";
    $dbname = "restaurante";

    $conexion = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    // Preparar una consulta para insertar datos en la tabla "cliente"
    $sql = "INSERT INTO cliente (nombre, apellido,telefono, fechaNacimiento, usuario, contrasena, nivel) VALUES (?, ?,?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssssi", $nombre, $apellido,$telefono, $fechaNacimiento, $usuario, $contrasena, $nivel);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        if ($nivel==1){
            header("Location: ../cocinero.php");
        }elseif($nivel==2){
            header("Location: ../repartidor.php");
        }else{
            header("Location: ../usuario.php");
        }
        exit();
    } else {
        echo 'Error al registrar al cocinero: ' . $stmt->error;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    // La solicitud no es de tipo POST, puedes manejarlo según tus necesidades
    header('HTTP/1.1 405 Method Not Allowed');
    exit('Método no permitido');
}
}else{
    echo json_encode(array("error" => "No se ha iniciado sesión"));
}
?>
