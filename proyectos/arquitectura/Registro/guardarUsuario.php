<?php
// Datos de conexión a la base de datos
include("../db.php");
// Obtener los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $correo = $_POST["correo"];
  $contrasena = $_POST["contraseña"];
  $nombre = $_POST["nombre"];
  $apellidoPaterno = $_POST["apellidoPaterno"];
  $apellidoMaterno = $_POST["apellidoMaterno"];
  $canton = $_POST["canton"];
  $direccion = $_POST["direccion"];
  $nacimiento = $_POST["nacimiento"];


  // Consulta preparada para insertar los datos en la tabla "paciente"
  $sql = "INSERT INTO paciente (correo, contrasena, nombre, apellidoPaterno, apellidoMaterno, canton, direccion, nacimiento) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conexion->prepare($sql);

  if ($stmt) {
    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("ssssssss", $correo, $contrasena, $nombre, $apellidoPaterno, $apellidoMaterno, $canton, $direccion, $nacimiento);

    if ($stmt->execute()) {
      header("Location: ../Inicio/Paciente/paginaInicio.html");
      exit();
    } else {
      echo "Error al registrar el usuario: " . $stmt->error;
    }

    // Cerrar el statement
    $stmt->close();
  } else {
    echo "Error en la consulta preparada: " . $conexion->error;
  }

  // Cerrar la conexión
  $conexion->close();
}
?>
