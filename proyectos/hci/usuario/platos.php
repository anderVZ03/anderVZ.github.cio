<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Categoria.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <?php include'funcions.php'; ?>
     
</head>

<?php include'Header.php'; ?>
<body class="paginacategorias">

</div>


        <div id="menu-titulo">
        
            <?php       
                        session_start();
                        try{
                            // Datos de la base de datos
                            include("../db.php");
                            $idCategoria=$_GET['id'];
                            // Consulta para la categoria
                            $sql_categoria="SELECT nombre from categoria where idCategoria=?";
                            $consulta_categoria=$conexion->prepare($sql_categoria);
                            $consulta_categoria->bind_param("i", $idCategoria);
                            $consulta_categoria->execute();
                            $consulta_categoria->bind_result($nombreCategoria);
                            $consulta_categoria->fetch();
                            $consulta_categoria->close();    
                            echo $nombreCategoria;
                        }catch(Exception $e){
                            echo "Error al cargar".$e;
                        }
  
        ?>
        </div>
        <div id="categorias">
        <a class="mobile-exit-button" href="javascript:history.back()">
    <i class="fas fa-arrow-left"></i>
</a>
                <?php
                        session_start();
                        try{
                            // Consulta para los productos
                            $sql_producto = "SELECT idProducto, nombre, precio, disponibilidad, descripcion FROM producto WHERE idCategoria =?";
                            $consulta=$conexion->prepare($sql_producto);
                            $consulta->bind_param("i", $idCategoria);
                            $consulta->execute();
                            $resultado = $consulta->get_result();
                            while ($fila = $resultado->fetch_assoc()) {
                                echo "<a  class='menu'>";
                                echo "<img src='images/".$nombreCategoria."/" . $fila['nombre'] . ".png' alt='".$fila['nombre'].">";
                                echo "<p class='menu-text'>" . $fila['nombre'] . "</p>";
                                echo "<p class='menu-description'>" . $fila['descripcion'] . "</p>";
                                echo "<p class='menu-price'> Precio: $" . $fila['precio'] . "</p>";
                                echo "<div class='menu-action'>";
                                echo "<button class='add-to-cart-button' data-producto= '".$fila['nombre']."'>Añadir al carrito</button>";
                                echo "<input type='number' class='cantidad-input' min='0' max='15' value='0' data-producto='". $fila['nombre']."'>";
                                echo "</div>";
                                echo "</a>";
                            }
                            $resultado->close();
                            $conexion->close();
                        }catch(Exception $e){
                            echo "Error al cargar".$e;
                        }
                    ?>
        
        </div>
    </div>

    
    
<script>
document.querySelectorAll('.add-to-cart-button').forEach(function(button) {
  button.addEventListener('click', function() {
    // Obtener el nombre del producto y la cantidad desde los elementos HTML
    var nombreProducto = this.getAttribute('data-producto');
    var cantidad = this.parentElement.querySelector('.cantidad-input').value;

    // Crear un objeto FormData para enviar los datos al servidor
    var formData = new FormData();
    formData.append('producto', nombreProducto); // Cambiado a 'producto' en lugar de 'producto[]'
    formData.append('cantidad', cantidad); // Cambiado a 'cantidad' en lugar de 'cantidad[]'

    // Crear una nueva solicitud AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/agregar_carrito.php', true);

    // Configurar una función para manejar la respuesta del servidor
    xhr.onload = function() {
      if (xhr.status === 200) {
        // La solicitud se completó correctamente, aquí puedes realizar acciones adicionales si es necesario.
        console.log('Producto agregado al carrito: ', nombreProducto);
      } else {
        console.error('Error al agregar el producto al carrito');
      }
    };
    // Enviar la solicitud con los datos del formulario
    xhr.send(formData);

    // Reiniciar la cantidad a 1 después de enviar los datos
    this.parentElement.querySelector('.cantidad-input').value = 1;
  });
});

</script>

    
</body>
<?php include 'Footer.php'; ?>
</html>