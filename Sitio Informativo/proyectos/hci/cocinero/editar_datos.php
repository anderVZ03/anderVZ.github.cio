<?php
session_start();
if (isset($_SESSION['id_cocinero'])) {
    // Obtén los datos enviados por POST
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $telefono = $_POST['telefono'];
    $contrasena = $_POST['contrasena'];

    include("../db.php");

    // Actualiza los datos del cliente en la base de datos
    $id_cocinero = $_SESSION['id_cocinero'];
    $sql = "UPDATE cliente SET nombre=?, apellido=?, fechaNacimiento=?, telefono=?, contrasena=? WHERE idCliente=?";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("sssssi", $nombre, $apellido, $fechaNacimiento, $telefono, $contrasena, $id_cocinero);

    if ($consulta->execute()) {
        $respuesta = array('success' => true);
    } else {
        $respuesta = array('success' => false);
    }

    // Cierra la conexión a la base de datos
    $conexion->close();

    // Devuelve la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($respuesta);
} else {
    echo "Acceso no autorizado.";
}
?>
