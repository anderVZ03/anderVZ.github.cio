<?php
session_start();

// Destruir la variable de sesión que contiene el carrito
unset($_SESSION['carrito']);
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gracias por tu compra</title>
    <link rel="stylesheet" href="/usuario/css/gracias.css">
</head>
<body>
    <div class="container">
        <div class="thank-you">
            <h1>¡Gracias por tu compra!</h1>
            <p>Tu pedido está en camino.</p>

            <a href="inicio.php" class="btn">Volver a la página principal</a>
        </div>
    </div>
</body>
</html>
