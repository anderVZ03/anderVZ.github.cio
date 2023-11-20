<?php
$servername = "192.168.45.100";
$username = "root";
$password = "Ander2003.";
$dbname = "arquitectura";

try {
    $conexion = new mysqli($servername, $username, $password, $dbname);
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Procesar los datos enviados por el formulario de edición
        if (isset($_POST['idPaciente']) && isset($_POST['nombre']) && isset($_POST['apellidoPaterno']) && isset($_POST['apellidoMaterno']) && isset($_POST['canton']) && isset($_POST['direccion']) && isset($_POST['nacimiento'])) {
            $idPaciente = $_POST['idPaciente'];
            $nombre = $_POST['nombre'];
            $apellidoPaterno = $_POST['apellidoPaterno'];
            $apellidoMaterno = $_POST['apellidoMaterno'];
            $canton = $_POST['canton'];
            $direccion = $_POST['direccion'];
            $nacimiento = $_POST['nacimiento'];

            $sql = "UPDATE paciente SET nombre='$nombre', apellidoPaterno='$apellidoPaterno', apellidoMaterno='$apellidoMaterno', canton='$canton', direccion='$direccion', nacimiento='$nacimiento' WHERE idPaciente='$idPaciente'";

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

    if (isset($_GET['idPaciente'])) {
        $idPacienteEditar = $_GET['idPaciente'];

        // Consultar los datos del paciente a editar
        $sql = "SELECT * FROM paciente WHERE idPaciente='$idPacienteEditar'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
            $idPaciente = $fila['idPaciente'];
            $nombre = $fila['nombre'];
            $apellidoPaterno = $fila['apellidoPaterno'];
            $apellidoMaterno = $fila['apellidoMaterno'];
            $canton = $fila['canton'];
            $direccion = $fila['direccion'];
            $nacimiento = $fila['nacimiento'];
        } else {
            echo "<p class='mensaje-error'>No se encontró el paciente con ID: $idPacienteEditar</p>";
            exit;
        }
    } else {
        echo "<p class='mensaje-error'>No se especificó un ID de paciente para editar.</p>";
        exit;
    }
} catch (Exception $e) {
    echo "<p class='mensaje-error'>Error en la conexión: " . $e->getMessage() . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <h1>Editar Paciente</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="idPaciente" value="<?php echo $idPaciente; ?>">
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
        <input type="date" name="nacimiento" value="<?php echo $nacimiento; ?>" required max="<?php echo date('Y-m-d'); ?>"><br><br>
        <input type="submit" value="Guardar Cambios">
    </form>
    <script>
  // Obtener el elemento del input de fecha de nacimiento
  var inputFechaNacimiento = document.getElementById('fechaNacimiento');

  // Obtener la fecha actual
  var fechaActual = new Date();

  // Formatear la fecha actual para que coincida con el formato del input de fecha
  var fechaActualFormateada = fechaActual.toISOString().slice(0, 10);

  // Establecer la fecha actual como el valor máximo para el input de fecha
  inputFechaNacimiento.setAttribute('max', fechaActualFormateada);

  // Validar la fecha de nacimiento cada vez que cambia el valor del input
  inputFechaNacimiento.addEventListener('change', function() {
    var fechaSeleccionada = new Date(this.value);
    if (fechaSeleccionada > fechaActual) {
      alert('La fecha de nacimiento no puede ser posterior a la fecha actual.');
      this.value = ''; // Limpiar el valor si es inválido
    }
  });
</script>
</body>

</html>
