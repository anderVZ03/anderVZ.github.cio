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
        if (isset($_POST['nombre']) && isset($_POST['apellidoPaterno']) && isset($_POST['apellidoMaterno']) && isset($_POST['nacimiento']) && isset($_POST['especialidad']) && isset($_POST['area'])) {
            $idDoctor = $_POST['idDoctor'];
            $nombre = $_POST['nombre'];
            $apellidoPaterno = $_POST['apellidoPaterno'];
            $apellidoMaterno = $_POST['apellidoMaterno'];
            $nacimiento = $_POST['nacimiento'];
            $especialidad = $_POST['especialidad'];
            $idArea = $_POST['area'];

            $sql = "UPDATE doctor SET nombre='$nombre', apellidoPaterno='$apellidoPaterno', apellidoMaterno='$apellidoMaterno', nacimiento='$nacimiento', especialidad='$especialidad', idArea='$idArea' WHERE idDoctor='$idDoctor'";

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

    if (isset($_GET['id'])) {
        $idDoctorEditar = $_GET['id'];

        // Consultar los datos del doctor a editar, incluyendo el nombre del área
        $sql = "SELECT doctor.*, area.area FROM doctor JOIN area ON doctor.idArea = area.idArea WHERE idDoctor='$idDoctorEditar'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
            $idDoctor = $fila['idDoctor'];
            $nombre = $fila['nombre'];
            $apellidoPaterno = $fila['apellidoPaterno'];
            $apellidoMaterno = $fila['apellidoMaterno'];
            $nacimiento = $fila['nacimiento'];
            $especialidad = $fila['especialidad'];
            $idArea = $fila['idArea'];
            $area = $fila['area'];
        } else {
            echo "<p class='mensaje-error'>No se encontró el doctor con ID: $idDoctorEditar</p>";
            exit;
        }
    } else {
        echo "<p class='mensaje-error'>No se especificó un ID de doctor para editar.</p>";
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
    <title>Editar Doctor</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <h1>Editar Doctor</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="idDoctor" value="<?php echo $idDoctor; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>" required>
        <label for="apellidoPaterno">Apellido Paterno:</label>
        <input type="text" name="apellidoPaterno" value="<?php echo $apellidoPaterno; ?>" required>
        <label for="apellidoMaterno">Apellido Materno:</label>
        <input type="text" name="apellidoMaterno" value="<?php echo $apellidoMaterno; ?>">
        <label for="nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="nacimiento" value="<?php echo $nacimiento; ?>" required max="<?php echo date('Y-m-d'); ?>"><br><br>
        <label for="especialidad">Especialidad:</label>
        <input type="text" name="especialidad" value="<?php echo $especialidad; ?>" required>
        <label for="area">Área:</label>
        <select name="area" required>
            <?php
            $sql = "SELECT idArea, area FROM area";
            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    $selected = ($idArea == $fila['idArea']) ? 'selected' : '';
                    echo "<option value='" . $fila['idArea'] . "' $selected>" . $fila['area'] . "</option>";
                }
            }
            ?>
        </select>
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
