<?php

// Datos de la base de datos
$host = "192.168.45.100";
$usuario = "root";
$contraseña = "Ander2003.";
$nombreBaseDatos = "arquitectura";

// Variable para almacenar mensajes de resultado
$mensaje = "";

function agregarDoctor($datos) {
    global $host, $usuario, $contraseña, $nombreBaseDatos, $mensaje;

    try {
        // Conectar a la base de datos
        $conexion = new PDO("mysql:host=$host;dbname=$nombreBaseDatos", $usuario, $contraseña);

        // Formatear la fecha de nacimiento antes de insertar en la base de datos
        $fechaNacimiento = date('Y-m-d', strtotime($datos['nacimiento']));
        $datos['nacimiento'] = $fechaNacimiento;

        // Preparar la consulta SQL para insertar el doctor
        $sql = "INSERT INTO doctor (idArea, especialidad, correo, contrasena, nombre, apellidoPaterno, apellidoMaterno, nacimiento) 
                VALUES (:idArea, :especialidad, :correo, :contrasena, :nombre, :apellidoPaterno, :apellidoMaterno, :nacimiento)";

        $stmt = $conexion->prepare($sql);

        // Ejecutar la consulta con los datos del formulario
        $stmt->execute($datos);

        // Mostrar mensaje de éxito
        $mensaje = "Registro completado. Doctor agregado a la base de datos.";

        // Cerrar la conexión
        $conexion = null;
    } catch (PDOException $e) {
        // Mostrar mensaje de error en caso de fallo en la conexión o consulta
        $mensaje = "Error al agregar el doctor: " . $e->getMessage();
    }
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario
    $datosDoctor = array(
        "idArea" => $_POST["idArea"],
        "especialidad" => $_POST["especialidad"],
        "correo" => $_POST["correo"],
        "contrasena" => $_POST["contrasena"],
        "nombre" => $_POST["nombre"],
        "apellidoPaterno" => $_POST["apellidoPaterno"],
        "apellidoMaterno" => $_POST["apellidoMaterno"],
        "nacimiento" => $_POST["nacimiento"]
    );

    // Agregar el doctor a la base de datos
    agregarDoctor($datosDoctor);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Agregar Doctor</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="container">
        <h2>Agregar Doctor</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="idArea">Área:</label>
            <select name="idArea" id="idArea">
            <?php
            // Incluir el archivo de conexión a la base de datos
            include("../../../../db.php");

            try {
                // Obtener las áreas desde la base de datos
                $sql = "SELECT idArea, area FROM area";
                $resultado = $conexion->query($sql);

                // Generar las opciones del menú desplegable
                while ($area = $resultado->fetch_assoc()) {
                    echo "<option value='" . $area['idArea'] . "'>" . $area['area'] . "</option>";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
            </select><br><br>
            <label for="especialidad">Especialidad:</label>
            <input type="text" name="especialidad" required><br><br>
            <label for="correo">Correo:</label>
            <input type="email" name="correo" required><br><br>
            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" required minlength="8"><br><br>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required><br><br>
            <label for="apellidoPaterno">Apellido Paterno:</label>
            <input type="text" name="apellidoPaterno" required><br><br>
            <label for="apellidoMaterno">Apellido Materno:</label>
            <input type="text" name="apellidoMaterno"><br><br>
            <label for="nacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="nacimiento" required max="<?php echo date('Y-m-d'); ?>"><br><br>
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
