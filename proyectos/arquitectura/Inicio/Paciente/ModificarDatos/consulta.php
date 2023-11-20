<?php
include("../../../db.php");
try {
    // Verificar si se ha enviado el ID del paciente desde el método mostrarCitas() en el HTML
    $idPaciente = $_GET['id'];
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
        echo $idPaciente ;
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
    <meta charset="UTF-8"> 
</head>

<body>

    <h1>Editar Paciente</h1>
    <a class="btn-regresar" href="../paginaInicio.html?id=<?php echo $idPacienteEditar; ?>">Regresar</a>
    <form method="post" action="modificar.php">
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
        <input type="date" name="nacimiento" value="<?php echo $nacimiento; ?>" required max="<?php echo date('Y-m-d'); ?>"><br><br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" value="<?php echo $contrasena; ?>" required>
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
