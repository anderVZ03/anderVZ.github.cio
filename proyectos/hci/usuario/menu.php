<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/mimenu.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include'funcions.php'; ?>
</head>

<?php       
    include 'Header.php';
?>
        <body class="paginamenu">
        
            <div id="menu-titulo">Menú</div>
                <div id="categorias">
                    <?php
                        try{
                            session_start();
                            // Datos de la base de datos
                            include("../db.php");
                            $sql_categoria = "SELECT idCategoria,nombre FROM categoria";
                            $resultado = $conexion->query($sql_categoria);
                            while ($fila = $resultado->fetch_assoc()) {
                                echo "<a href='platos.php?id=".$fila['idCategoria']."' class='menu'>";
                                echo "<img src='images/" . $fila['nombre'] . ".png' alt='" . $fila['nombre'] . "'>";
                                echo "<p class='menu-text'>" . $fila['nombre'] . "</p>";
                                echo "</a>";
                            }
                            $resultado->close();
                            $conexion->close();
                        }catch(Exception $e){
                            echo "Error al cargar";
                        }
                    ?>
                </div>
            </div>

        </body>
    
        <?php include 'Footer.php'; ?>
</html>