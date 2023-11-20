<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap">

    <title>Administrador Urban Food</title>
    <link rel="stylesheet" href="/admin/css/cocinero.css">
</head>
<body>
    <!-- Panel de Navegación -->
  
    <?php include'header.php'; ?>
    <!-- Título llamativo -->
<div class="titulo-llamativo">
    <h1>Cocinero</h1>
</div>

    <div class="botones-accion">
        <button class="agregar-cocinero"> 
            <i class="fas fa-plus"></i> 
            Agregar </button>
        

    </div>
    <!-- Modal de Agregar Plato (inicialmente oculto) -->
    <div id="modal-agregar" class="modal">
        <div class="modal-contenido">
            <span class="cerrar-modal" id="cerrar-modal">&times;</span>
            <h2>Agregar Cocinero</h2>
            <form id="formulario-agregar-cocinero" method="post" action="php/registrar_usuario.php" enctype="multipart/form-data">
                <input type="text" name="nombre" id="Nombre" placeholder="Nombre Sector" required>
                <input type="text" name="apellido" id="Apellido" placeholder="# de Sección" required>
                <input type="text" name="usuario" id="Usuario" placeholder="Usuario" required>
                <input type="date" name="fecha" id="Fecha"  placeholder="Usuario"required>
                <input type="hidden" name="telefono" id="telefono_editar" placeholder="Teléfono" value="0000000000">

                <input type="password" name="contrasena" id="Contrasena" placeholder="Contraseña" required>
                <input type="hidden" name="nivel" value="1"> <!-- Campo hidden para el nivel -->
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Sección de Platos -->
    <section class="seccion-cocina">
        <div class="table-responsive">
            
                    <?php
                    session_start();
                    if (isset($_SESSION['id_administrador'])) {
                        $servername = "localhost";
                        $username = "root";
                        $password = "Ander2003.";
                        $dbname = "restaurante";
                        $nivel=1;

                        $conexion = new mysqli($servername, $username, $password, $dbname);

                        // Verificar la conexión
                        if ($conexion->connect_error) {
                            die("Error de conexión: " . $conexion->connect_error);
                        }
                        
                        $sql = "SELECT idCliente, nombre, apellido, fechaNacimiento, usuario, contrasena, direccion FROM cliente WHERE nivel = ?";
                        $consulta = $conexion->prepare($sql);
                        $nivel = 1; // Nivel 1 para cocineros
                        $consulta->bind_param("i", $nivel);
                        $consulta->execute();
                        $resultado = $consulta->get_result();

                        // Verifica si se encontraron registros
                        if ($resultado->num_rows > 0) {
                        echo '<table class="tabla-cocineros">
                        <thead>
                            <tr>
                                
                                <th>Nombre Sector</th>
                                <th>N° de Sección</th>
                                <th>Usuario</th>
                                <th>Fecha de apertura</th>
                                <th>Contraseña</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';    
                            while ($fila = $resultado->fetch_assoc()) {
                                $idCliente = $fila["idCliente"];
                                $nombre = $fila["nombre"];
                                $apellido = $fila["apellido"];
                                $fechaNacimiento = $fila["fechaNacimiento"];
                                $usuario = $fila["usuario"];
                                $contrasena = $fila["contrasena"];
                                $direccion = $fila["direccion"];
                                
                                // Genera la fila HTML con los datos
                                echo '<tr class="cocinar">';
                                echo '<td class="celda-nombre">' . $nombre . '</td>';
                                echo '<td class="celda-apellido">' . $apellido . '</td>';
                                echo '<td class="celda-usuario">' . $usuario . '</td>';
                                echo '<td class="celda-fecha">' . $fechaNacimiento . '</td>';
                                echo '<td class="contraseña">' . $contrasena . '</td>';
                                echo '<td class="celda-acciones">';
                                echo '<button class="editar-cocina">Editar</button>';
                                echo '<button class="eliminar-cocina" data-id="'.$idCliente.'">Eliminar</button>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>
               
                            </table>';
                        } else {
                            // No se encontraron registros
                            echo 'No hay registros de Cocinero.';
                        }

                    }else{
                        echo json_encode(array("error" => "No se ha iniciado sesión"));
                    }
                    ?>
                
        </div>
    </section>
   
    <?php include'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="javascript/js.js"></script>

    
</body>
</html>
