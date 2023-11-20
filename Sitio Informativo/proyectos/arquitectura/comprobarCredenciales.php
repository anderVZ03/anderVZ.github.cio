<?php
include("db.php");
// Obtener los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Consulta para buscar las credenciales en la tabla "paciente"
    $sql_paciente = "SELECT idPaciente, contrasena FROM paciente WHERE correo = ?";
    $stmt_paciente = $conexion->prepare($sql_paciente);
    $stmt_paciente->bind_param("s", $correo);
    $stmt_paciente->execute();
    $resultado_paciente = $stmt_paciente->get_result();

    // Consulta para buscar las credenciales en la tabla "doctor"
    $sql_doctor = "SELECT idDoctor, contrasena FROM doctor WHERE correo = ?";
    $stmt_doctor = $conexion->prepare($sql_doctor);
    $stmt_doctor->bind_param("s", $correo);
    $stmt_doctor->execute();
    $resultado_doctor = $stmt_doctor->get_result();

    // Consulta para buscar las credenciales en la tabla "admin"
    $sql_admin = "SELECT idAdmin, contrasena FROM administrador WHERE correo = ?";
    $stmt_admin = $conexion->prepare($sql_admin);
    $stmt_admin->bind_param("s", $correo);
    $stmt_admin->execute();
    $resultado_admin = $stmt_admin->get_result();

    // Verificar si se encontraron datos en alguna tabla
    if ($resultado_paciente->num_rows === 1) {
        $fila = $resultado_paciente->fetch_assoc();
        $id_entidad = $fila["idPaciente"];
        $contraseñaAlmacenada = $fila["contrasena"];

        // Verificar la contraseña ingresada con la contraseña almacenada
        if ($contrasena === $contraseñaAlmacenada) {
            // Contraseña correcta para paciente, redirigir al usuario a página de paciente
            header("Location: Inicio/Paciente/paginaInicio.html?id=" . $id_entidad);
            exit();
        } else {
            echo "El usuario o la contraseña son incorrectos.";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'InicioSesion.html';
                    }, 2000);
                 </script>";
            exit();
        }
    } elseif ($resultado_doctor->num_rows === 1) {
        $fila = $resultado_doctor->fetch_assoc();
        $contraseñaAlmacenada = $fila["contrasena"];
        $doctor_id = $fila["idDoctor"]; // Almacenar el ID del doctor en una variable
        $doctor_nombre = $fila["nombre"]; // Obtener el nombre del doctor
      
        // Verificar la contraseña ingresada con la contraseña almacenada
        if ($contrasena === $contraseñaAlmacenada) {
            session_start(); // Iniciar sesión
            $_SESSION['user_id'] = $doctor_id; // Almacenar el ID del doctor en la variable de sesión
            // Mostrar mensaje y redirigir al usuario a la página de inicio de doctor
            echo "¡Bienvenido, $doctor_nombre, $doctor_id!";
            header("Location: Inicio/Doctor/paginaInicio.html");
            exit();
            //header("Location: Inicio/Doctor/paginaInicio.html?id=" . $id_entidad);
            //exit();
        } else {
            echo "El usuario o la contraseña son incorrectos.";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'InicioSesion.html';
                    }, 2000);
                 </script>";
            exit();
        }
    } elseif ($resultado_admin->num_rows === 1) {
        $fila = $resultado_admin->fetch_assoc();
        $id_entidad = $fila["idAdmin"];
        $contraseñaAlmacenada = $fila["contrasena"];

        // Verificar la contraseña ingresada con la contraseña almacenada
        if ($contrasena === $contraseñaAlmacenada) {
            // Contraseña correcta para admin, redirigir al usuario a página de admin
            header("Location: Inicio/Admin/paginaInicio.html?id=" . $id_entidad);
            exit();
        } else {
            echo "El usuario o la contraseña son incorrectos.";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'InicioSesion.html';
                    }, 2000);
                 </script>";
            exit();
        }
    } else {
        echo "El usuario o la contraseña son incorrectos.";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'InicioSesion.html';
                }, 2000);
             </script>";
        exit();
    }

    // Cerrar los statements y la conexión
    $stmt_paciente->close();
    $stmt_doctor->close();
    $stmt_admin->close();
    $conexion->close();
}
?>
