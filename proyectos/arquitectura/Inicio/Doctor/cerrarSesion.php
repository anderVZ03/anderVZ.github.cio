Copy code
<?php
session_start();

// Verificamos si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    // Destruimos la sesión para cerrarla
    session_destroy();
}

// Redireccionamos a la página de inicio de sesión después de cerrar la sesión
header("Location: ../../InicioSesion.html");
exit;
?>