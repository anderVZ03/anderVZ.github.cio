<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estiloIndex.css">
    <link href="https://fonts.googleapis.com/css2?family=Nombre+de+la+Fuente&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    
    <title>Menú</title>
</head>

<body onload="obtenerCategorias();">
    
    <div class="user-panel">
        <i class="fas fa-user">
         <!-- Aquí mostramos el nombre de usuario obtenido de la base de datos -->
         <?php
         include("../db.php");
         session_start();
         // Obtenemos el id del usuario desde la variable de sesión
         $idUsuario = $_SESSION['user_id'];
         // Consultamos la base de datos para obtener el nombre del usuario
         $sql = "SELECT nombre FROM cliente WHERE idCliente = ?";
         $stmt = $conexion->prepare($sql);
         $stmt->bind_param("i", $idUsuario);
         $stmt->execute();
         $stmt->bind_result($nombreUsuario);
         $stmt->fetch();
         $stmt->close();
         // Mostramos el nombre del usuario
         echo "$nombreUsuario";
         ?>
        </i>

        <div class="user-dropdown">
            <a href="usuario/index.html"  class="user-action"><i class="fas fa-edit"></i>Editar perfil</a>
            <a href="../login/login.html"  id="logout-link" class="user-action"><i class="fas fa-arrow-circle-right"></i>Salir</a>
        </div>
        
    </div>
    </div>
    
    <div class="contenedor">
        <div class="cart-container">
            <div class="cart">
                <img src="images/Carrito.png" alt="Carrito de compras">
                <span class="cart-count">0</span>
            </div>
        </div>
        
        <div id="menu-titulo">Menú</div>
        
        <div id="categorias"></div>
    </div>

    <script src="javascript/javaCategoria.js"></script>
</body>

</html>
