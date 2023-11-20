<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">

    <title>Administrador Urban Food</title>
    <link rel="stylesheet" href="css/producto.css">
    
</head>
<body>
    <!-- Panel de Navegación -->
  
    <?php include'header.php'; ?>

    <div class="titulo-llamativo">
    <h1>Producto</h1>
</div>


    <div class="botones-accion">
        <button class="agregar-plato"> 
            <i class="fas fa-plus"></i> 
            Agregar </button>
        <button id="btn-filtrar">Filtrar
            <i class="fas fa-filter"></i>
        </button>

    </div>
    
   
    <!-- Modal de Agregar Plato (inicialmente oculto) -->
    <div id="modal-agregar" class="modal">
        <div class="modal-contenido">
            <span class="cerrar-modal" id="cerrar-modal">&times;</span>
            <h2>Agregar Plato</h2>
            <form id="formulario-agregar-plato" method='post' action='php/agregar_producto.php'  enctype="multipart/form-data">
                <label for="imagen">Elegir Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" >
                <?php
                // Datos de la base de datos
                include("../db.php");
                session_start();

                if (isset($_SESSION['id_administrador'])) {
                    $id_admin = $_SESSION['id_administrador'];

                    // Obtener todas las categorías
                    $sql_categoria = "SELECT idCategoria, nombre FROM categoria";
                    $resultado = $conexion->query($sql_categoria);

                    // Crear una lista desplegable
                    echo '<select id="Categoria" name="categoria" required>';
                    while ($fila = $resultado->fetch_assoc()) {
                        echo '<option value="' . $fila['idCategoria'] . '">' . $fila['nombre'] . '</option>';
                    }
                    echo '</select>';

                    $resultado->close();
                    $conexion->close();
                } else {
                    echo json_encode(array("error" => "No se ha iniciado sesión"));
                    exit();
                }
                ?>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre del Plato" required>
                <textarea id="descripcion" name="descripcion" placeholder="Descripción del Plato" required></textarea>
                <input type="number" id="precio" name="precio" placeholder="Precio del Plato" step="" required>
                <input type="hidden" id="ruta-imagen" name="ruta-imagen" value="">
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>
<!-- Agrega el botón de Filtrar -->


<!-- Sección de Opciones de Filtrado (inicialmente oculta) -->
<div id="opciones-filtrado" style="display: none;">
    <label for="categoria">Categoría:</label>
    <select id="categoria">
        <option value="Todos">Todos</option>
        <option value="Papas">Papas</option>
        <option value="Hamburguesas">Hamburguesas</option>
        <option value="Salsas">Salsas</option>
        <option value="Bebidas">Bebidas</option>
        <option value="Extras">Extras</option>
        
    </select>
    <label>Ordenar por:</label>
    <input type="radio" id="precioMenor" name="filtro" value="precioMenor">
    <label for="precioMenor">Precio Menor</label>
    <input type="radio" id="precioMayor" name="filtro" value="precioMayor">
    <label for="precioMayor">Precio Mayor</label>
    <input type="radio" id="alfabeticamente" name="filtro" value="alfabeticamente">
    <label for="alfabeticamente">Alfabéticamente</label>
   

    <button id="filtrar">Buscar filtro</button>
    <button id="limpiarFiltro" class="btn-limpiar-filtro">Limpiar filtro</button>

  </div>

   
    
    <section class="seccion-platos">
        <div class="table-responsive">
                   
    
        <?php
                    session_start();
                    if (isset($_SESSION['id_administrador'])) {
                        include("../db.php");
                        $sql = "SELECT p.idProducto, p.nombre AS nombre_plato, c.nombre AS nombre_categoria, p.descripcion, p.precio FROM producto p INNER JOIN categoria c ON c.idCategoria = p.idCategoria";
                        $consulta = $conexion->prepare($sql);
                        $consulta->execute();
                        $resultado = $consulta->get_result();

                        // Verifica si se encontraron registros
                        if ($resultado->num_rows > 0) {
                        echo '<table class="tabla-platos">
                        <thead>
                            <tr>
                                
                                <th>Imagen</th>
                                <th>Categoria</th>
                                <th>Nombre Producto</th>
                                <th>Descripción</th>
                                <th>Precio ($)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';    
                            while ($fila = $resultado->fetch_assoc()) {
                                $idProducto = $fila["idProducto"];
                                $nombrePlato = $fila["nombre_plato"];
                                $categoria = $fila["nombre_categoria"];
                                $descripcion = $fila["descripcion"];
                                $precio = $fila["precio"];
                            
                                // Genera la fila HTML con los datos
                                echo '<tr class="plato">';
                                echo '<td class="celda-imagen"><img src="images/' . $categoria . '/'.$nombrePlato.'.png" alt="' . $nombrePlato . '"></td>';
                                echo '<td class="celda-categoria">' . $categoria . '</td>';
                                echo '<td class="celda-nombre">' . $nombrePlato . '</td>';
                                echo '<td class="celda-descripcion">' . $descripcion . '</td>';
                                echo '<td class="celda-precio">' . number_format($precio, 2) . '</td>';
                                echo '<td class="celda-acciones">';
                                echo '<button class="editar-plato" data-id="'.$idProducto.'">Editar</button>';
                                echo '<button class="eliminar-plato" data-id="'.$idProducto.'">Eliminar</button>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>
               
                            </table>';
                        } else {
                            // No se encontraron registros
                            echo 'No hay registros de Productos.';
                        }

                    }else{
                        echo json_encode(array("error" => "No se ha iniciado sesión"));
                    }
                    ?>
  
    
        </div>
    </section>
   
    <?php include'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="javascript/producto.js"></script>
</body>
</html>
