<?php
// Declaramos las variables de conexión
$ServerName1 = "192.168.45.100";
$Username1 = "root";
$Password1 = "Ander2003.";
$NameBD1 = "arquitectura";

$ServerName2 = "192.168.45.101";
$Username2 = "root";
$Password2 = "Ander2003.";
$NameBD2 = "arquitectura";

try {
    // Intentar la primera conexión
    $conexion = new mysqli($ServerName1, $Username1, $Password1, $NameBD1);

    // Revisar la conexión MySQL
    if ($conexion->connect_error) {
            die("Ha fallado la conexión a la primera base de datos.");
    }
} catch (Exception $e) {
   // Intentar la segunda conexión
   try {
    $conexion = new mysqli($ServerName2, $Username2, $Password2, $NameBD2);

    // Revisar la conexión MySQL nuevamente
    if ($conexion->connect_error) {
        die("Ha fallado la conexión a ambas bases de datos.");
    }
    } catch (Exception $e) {
         die("Error en la conexión: " . $e->getMessage());
    }
}
?>
