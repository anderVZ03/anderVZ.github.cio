<?php
// Datos de la base de datos
include("../../../../db.php");
// Variable para almacenar el mensaje de resultado de la inserción
$mensaje = "";

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el valor del campo "area" del formulario
    $area = $_POST["area"];

    // Intentar conectar a la base de datos
    try {

        // Consulta SQL para insertar el área en la tabla 'area'
        $sql = "INSERT INTO area (area) VALUES ('$area')";

        // Ejecutar la consulta
        if ($conexion->query($sql)) {
            $mensaje = "Registro completado. Área agregada correctamente.";
            // Redirigir al usuario a la página principal después de 3 segundos
            echo "<meta http-equiv='refresh' content='2;url=../../paginaInicio.html'>";
        } else {
            $mensaje = "Error al agregar el área: " . $conexion->error;
        }

        // Cerrar la conexión
        $conexion->close();
    } catch (Exception $e) {
        // Capturar cualquier excepción que pueda surgir
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Agregar Área</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="area">Área:</label>
            <input type="text" id="area" name="area" required>
            <input type="submit" value="Agregar"><br>
        </form>

    <?php
    // Mostrar el mensaje de resultado de la inserción, si existe
    if (!empty($mensaje)) {
        echo "<br><p>$mensaje</p>";
    }
    ?>
</body>

</html>
