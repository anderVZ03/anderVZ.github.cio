<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">

</title>
    <link rel="stylesheet" href="/repartidor/css/header.css">
    
</head>

    <!-- Panel de Navegación -->
    <header>
        <nav class="panel-navegacion">
            <div class="logo">
                <a href="#">
                    <img src="/usuario/images/Logo.png" alt="Logo de tu sitio web">
                </a>
            </div>
            <ul>
                <li><a href="/repartidor/pedidosporentregar.php">Pedidos por entregar </a></li>
            
               
            </ul>
            <div class="menu-usuario">
            <?php
                    session_start();
                    // Verifica si el usuario ha iniciado sesión
                    if (isset($_SESSION['id_repartidor'])) {
                        // El usuario ha iniciado sesión, muestra el nombre de usuario y un enlace para cerrar sesión
                        $idrepartidor = $_SESSION['id_repartidor'];
                        echo '<div class="nombre-usuario"> <i class="fas fa-motorcycle"></i>   Repartidor</div>';
                        echo '<div class="menu-dropdown">';
                        echo '<button class="menu-btn">☰</button>';
                        echo '<div class="menu-contenido">';
                        echo '<a href="/repartidor/historial.php">Historial</a>'; // Agrega el enlace "Mi Cuenta" aquí
                        echo '<a href="micuenta.php">Mi Cuenta</a><br>'; // Agrega el enlace "Mi Cuenta" aquí
                        echo '<a href="../usuario/php/cerrar_sesion.php">Cerrar Sesión</a>';

                    }
            ?>
                
            </div>
           
        </nav>
    </header>