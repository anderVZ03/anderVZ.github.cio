<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Ander2003.";
$dbname = "restaurante";
try{
    $conexion = new mysqli($servername, $username, $password, $dbname);
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $nombre=$_POST["nombre"];
        $fecha=$_POST["fecha"];
        $correo=$_POST["correo"];
        $contrasena=$_POST["password"];
        // Consulta SQL para insertar los datos en la tabla clientes
        $sql = "INSERT INTO cliente (nombre, fechaNacimiento, usuario, contrasena,nivel) VALUES (?, ?, ?, ?,3)";
        // Preparar la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $fecha, $correo, $contrasena);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $id_cliente = $conexion->insert_id; // Obtener el ID autoincremental del cliente
            session_start();
            $_SESSION["id_cliente"] = $id_cliente; // Guardar el ID en la sesión
            header("Location: ../menu.php");
            exit();
        } else {
            echo "Error al insertar el registro: " . $conexion->error;
        }

        // Cerrar la consulta
        $stmt->close();

    }
}catch(Exception $e){
    echo "Ha ocurrido el error".$e;
}
?>