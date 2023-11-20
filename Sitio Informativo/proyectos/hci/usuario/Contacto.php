<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <link rel="stylesheet" href="css/contacto.css">
    <?php include'funcions.php'; ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Seleccionar el formulario
        const formulario = document.querySelector("form");

        formulario.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevenir el envío predeterminado del formulario

            // Aquí puedes realizar el envío del formulario, por ejemplo, mediante una solicitud AJAX

            // Mostrar un mensaje emergente
            alert("Su correo ha sido enviado");

            // Redirigir a otra página
            window.location.href = "inicio.php";
        });
    });
</script>
</head>
<?php include 'Header.php'; ?>
<body>

    <div class="container">
        <h1>Contacto</h1>
        <form  method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" rows="4" required></textarea>

            <input type="submit" value="Enviar">
        </form>
    </div>

</body>
<?php include 'Footer.php'; ?>

</html>
