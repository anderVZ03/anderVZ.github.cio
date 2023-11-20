<?php
include("../../../db.php");
try {

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
                echo "<script>alert('Actualizado correctamente.'); window.location.href = '../paginaInicio.html?id=" . $idPaciente . "';</script>";
                exit;
            } else {
                echo "<p class='mensaje-fracaso'>Registro no actualizado.</p>";
                header("refresh:3;url=editar.html");
                exit;
            }
        }
    }

    $conexion->close();
} catch (Exception $e) {
    echo "Error en la conexión: " . $e->getMessage();
    exit;
}
?>
