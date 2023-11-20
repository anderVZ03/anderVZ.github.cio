<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/carro.css">
        <link rel="stylesheet" href="css/carritovacio.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include 'funcions.php'; ?>
    </head>

        <?php include 'Header.php'; ?>
    <body class="pagcarrito">
        <?php
        // Verificar si hay una sesión existente para el carrito y obtenerla
        $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
        if (empty($carrito)) {
            echo '<div class="carrito-vacio">';
            echo '<div class="carrito-icono">';
            echo '<i class="fas fa-shopping-cart"></i></div>';
            echo '<p>Tu carrito está vacío</p>';
            echo '<a href="menu.php" class="ver-menu-button">Ver Menú</a></div>';
        } else {
        // Puedes mostrar los productos del carrito en esta página
        echo '<table class="carrito-table">'; // Crear una tabla para organizar los productos en filas
          // Agregar una fila de títulos
          echo '<tr class="titulo-fila">';
          echo '<th>Imagen</th>';
          echo '<th>Producto</th>';
          echo '<th>Cantidad</th>';
          echo '<th>Precio Unitario</th>';
          echo '<th>Total</th>';
          echo '<th>Eliminar</th>';
          echo '</tr>';
        foreach ($carrito as $item) {
            $servername = "localhost";
            $username = "root";
            $password = "Ander2003.";
            $dbname = "restaurante";
            $conexion = new mysqli($servername, $username, $password, $dbname);
            // Verificar la conexión
            if ($conexion->connect_error) {
                 die("Error de conexión: " . $conn->connect_error);
            }
            try{
                $nombreProducto = $item['producto'];
                $cantidadProducto = $item['cantidad'];


                $sql = "SELECT p.precio, c.nombre as categoria FROM producto p inner join categoria c on c.idCategoria = p.idCategoria WHERE p.nombre = ?";
                $consulta = $conexion->prepare($sql);
                $consulta->bind_param("s", $nombreProducto);
                $consulta->execute();
                $resultado = $consulta->get_result();
                $precio=0;
                $categoria="";
                
                if ($fila = $resultado->fetch_assoc()) {
                    $precio = $fila['precio'];
                    $categoria=$fila['categoria'];
                }
                $total = $precio * $cantidadProducto;
               
                echo '<tr class="producto-fila">'; // Iniciar una fila para el producto
                echo '<td><img src="images/' .$categoria.'/'. $nombreProducto . '.png" alt="' . $nombreProducto . '"></td>'; // Columna para la imagen
                echo '<td>' . $nombreProducto . '</td>'; // Columna para el nombre
                echo '<td>' . $cantidadProducto . '</td>'; // Columna para la cantidad
                echo '<td>$' . number_format($precio, 2) . '</td>'; // Columna para el precio unitario
                echo '<td>$' . number_format($total, 2) . '</td>'; // Columna para el precio total
                echo '<td><button class="eliminar-producto" title="Eliminar producto" data-producto="' . $nombreProducto . '"><i class="fas fa-trash"></i></button></td>'; // Columna para el botón de eliminar
                echo '</tr>'; // Cerrar la fila del producto
            }catch(Exception $e){
                echo "Ocurrió el error: ".$e;
            }
        }
        echo '<tr class="boton-compra-fila">';
        echo '<td colspan="6" class="centrar-botones">';
        echo '<a href="finalizarCompra.php" class="realizar-compra-button">Realizar Compra</a>';
        echo '</td>';
        echo '</tr>';

        echo '</table>'; // Cerrar la tabla
            
         }
        ?>     
        </div>
        
        <script>
        $(document).ready(function() {
        // Manejar el clic en el botón "Eliminar"
        $(".eliminar-producto").on("click", function() {
        var nombreProducto = $(this).data("producto");

        // Realiza una solicitud AJAX para eliminar el producto del carrito
        $.ajax({
            type: "POST",
            url: "php/eliminar_producto.php", // Nombre del archivo PHP que manejará la eliminación
            data: { producto: nombreProducto },
            success: function(response) {
                // Realiza alguna acción si la eliminación es exitosa
                // Por ejemplo, actualizar la vista del carrito
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                // Maneja errores si es necesario
            }
        });
    });
});


        </script>
    </body>
</html>
