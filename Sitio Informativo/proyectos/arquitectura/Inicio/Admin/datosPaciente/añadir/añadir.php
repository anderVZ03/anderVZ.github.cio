<?php
// Datos de la base de datos
$host = "192.168.45.100";
$usuario = "root";
$contraseña = "Ander2003.";
$nombreBaseDatos = "arquitectura";

// Variable para almacenar mensajes de resultado
$mensaje = "";

// Función para agregar un paciente a la base de datos
function agregarPaciente($datos) {
    global $host, $usuario, $contraseña, $nombreBaseDatos, $mensaje;

    try {
        // Conectar a la base de datos
        $conexion = new PDO("mysql:host=$host;dbname=$nombreBaseDatos", $usuario, $contraseña);

        // Preparar la consulta SQL para insertar el paciente
        $sql = "INSERT INTO paciente (correo, contrasena, nombre, apellidoPaterno, apellidoMaterno, canton, direccion, nacimiento) 
                VALUES (:correo, :contrasena, :nombre, :apellidoPaterno, :apellidoMaterno, :canton, :direccion, :nacimiento)";

        $stmt = $conexion->prepare($sql);

        // Ejecutar la consulta con los datos del formulario
        $stmt->execute($datos);

        // Mostrar mensaje de éxito
        $mensaje = "Registro completado. Paciente agregado a la base de datos.";

        // Cerrar la conexión
        $conexion = null;
    } catch (PDOException $e) {
        // Mostrar mensaje de error en caso de fallo en la conexión o consulta
        $mensaje = "Error al agregar el paciente: " . $e->getMessage();
    }
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario
    $datosPaciente = array(
        "correo" => $_POST["correo"],
        "contrasena" => $_POST["contrasena"],
        "nombre" => $_POST["nombre"],
        "apellidoPaterno" => $_POST["apellidoPaterno"],
        "apellidoMaterno" => $_POST["apellidoMaterno"],
        "canton" => $_POST["canton"],
        "direccion" => $_POST["direccion"],
        "nacimiento" => $_POST["nacimiento"]
    );

    // Agregar el paciente a la base de datos
    agregarPaciente($datosPaciente);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Agregar Paciente</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <div class="container">
        <h2>Agregar Paciente</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required minlength="8>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellidoPaterno">Apellido Paterno:</label>
            <input type="text" id="apellidoPaterno" name="apellidoPaterno" required>

            <label for="apellidoMaterno">Apellido Materno:</label>
            <input type="text" id="apellidoMaterno" name="apellidoMaterno">

            <label for="canton">Cantón:</label>
            <input type="text" id="canton" name="canton" required>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="nacimiento" name="nacimiento" required max="<?php echo date('Y-m-d'); ?>"><br><br>

            <input type="submit" value="Agregar">
        </form>

        <!-- Mensaje de resultado de la inserción -->
        <?php
        if (!empty($mensaje)) {
            echo "<div class='message'>$mensaje</div>";
            echo "<script>setTimeout(function() { window.location.href = '../../paginaInicio.html'; }, 2000);</script>";
        }
        ?>
    </div>
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
