<?php
include("../../../../db.php");
try {
    // Verificar si se ha enviado el ID del paciente desde el método mostrarCitas() en el HTML
    if (isset($_GET['id'])) {
        $idPaciente = $_GET['id'];

        // Convertir el ID recibido a un entero para evitar inyección SQL
        $idPaciente = intval($idPaciente);

        // Consultar los datos del paciente a editar
        $sql = "SELECT * FROM paciente WHERE idPaciente='$idPaciente'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
            $idPacienteEditar = $fila['idPaciente'];
            $nombre = $fila['nombre'];
            $apellidoPaterno = $fila['apellidoPaterno'];
            $apellidoMaterno = $fila['apellidoMaterno'];
            $canton = $fila['canton'];
            $direccion = $fila['direccion'];
            $nacimiento = $fila['nacimiento'];
            $contrasena = $fila['contrasena'];
        } else {
            echo "<p class='mensaje-error'>No se encontró el paciente con ID: $idPaciente</p>";
            exit;
        }
    } else {
        echo "<p class='mensaje-error'>No se especificó un ID de paciente para editar.</p>";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Procesar los datos enviados por el formulario de edición
        if (isset($_POST['idPaciente']) && isset($_POST['nombre']) && isset($_POST['apellidoPaterno']) && isset($_POST['apellidoMaterno']) && isset($_POST['canton']) && isset($_POST['direccion']) && isset($_POST['nacimiento']) && isset($_POST['contrasena'])) {
            $idPaciente = $_POST['idPaciente'];
            $nombre = $_POST['nombre'];
            $apellidoPaterno = $_POST['apellidoPaterno'];
            $apellidoMaterno = $_POST['apellidoMaterno'];
            $canton = $_POST['canton'];
            $direccion = $_POST['direccion'];
            $nacimiento = $_POST['nacimiento'];
            $contrasena = $_POST['contrasena']; // Nueva contraseña

            // Actualizar los datos del paciente en la base de datos (incluyendo la contraseña)
            $sql = "UPDATE paciente SET nombre='$nombre', apellidoPaterno='$apellidoPaterno', apellidoMaterno='$apellidoMaterno', canton='$canton', direccion='$direccion', nacimiento='$nacimiento', contrasena='$contrasena' WHERE idPaciente='$idPaciente'";

            if ($conexion->query($sql) === TRUE) {
                echo "<p class='mensaje-exito'>Registro actualizado correctamente.</p>";
                echo "<p>Redirigiendo a la página de inicio...</p>";
                header("refresh:3;url=../../paginaInicio.html");
                exit;
            } else {
                echo "<p class='mensaje-error'>Error al actualizar el registro: " . $conexion->error . "</p>";
            }
        }
    }

    $conexion->close();
} catch (Exception $e) {
    echo "<p class='mensaje-error'>Error en la conexión: " . $e->getMessage() . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="ModificarDatos/editar/estilo.css">
    <meta charset="UTF-8"> 
</head>

<body>
    <h1>Editar Paciente</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="idPaciente" value="<?php echo $idPacienteEditar; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>" required>
        <label for="apellidoPaterno">Apellido Paterno:</label>
        <input type="text" name="apellidoPaterno" value="<?php echo $apellidoPaterno; ?>" required>
        <label for="apellidoMaterno">Apellido Materno:</label>
        <input type="text" name="apellidoMaterno" value="<?php echo $apellidoMaterno; ?>" required>
        <label for="canton">Cantón:</label>
        <input type="text" name="canton" value="<?php echo $canton; ?>" required>
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" value="<?php echo $direccion; ?>" required>
        <label for="nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="nacimiento" value="<?php echo $nacimiento; ?>" required>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" value="<?php echo $contrasena; ?>" required>
        <input type="submit" value="Guardar Cambios">
    </form>
</body>

</html>
