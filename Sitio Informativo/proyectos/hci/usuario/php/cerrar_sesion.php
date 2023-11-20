<?php
// Iniciar sesión o reanudar la sesión existente
session_start();


// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio o a donde desees después de cerrar sesión
header("Location: ../inicio.php");
exit();
?>