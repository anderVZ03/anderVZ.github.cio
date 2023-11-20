<?php
// Datos de la base de datos
$host = "localhost";
$usuario = "root";
$contraseña = "Ander2003.";
$nombreBaseDatos = "restaurante";

    // Intentar conectar a la base de datos
    $conexion = new mysqli($host, $usuario, $contraseña, $nombreBaseDatos);

    // Verificar si hubo algún error durante la conexión
    if ($conexion->connect_errno) {
        die("Conexion fallida: ". $conn->connection_error);
    }
?>