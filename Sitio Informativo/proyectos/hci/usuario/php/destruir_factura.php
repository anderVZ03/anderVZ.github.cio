<?php
session_start();

// Verificar si la variable de sesión idFactura existe
if (isset($_SESSION['idFactura'])) {
    // Guardar el valor de idFactura en una variable temporal si es necesario
    $idFactura = $_SESSION['idFactura'];

    // Destruir la variable de sesión idFactura
    unset($_SESSION['idFactura']);

    // Redirigir al usuario a la página de factura sin idFactura
    header('Location: ../finalizarCompra.php');
    exit();
} else {
    // Si no existe idFactura en la sesión, puedes manejarlo de acuerdo a tus necesidades
    // Por ejemplo, redireccionar a una página de error o mostrar un mensaje de error
    header('Location: error.php');
    exit();
}
?>
