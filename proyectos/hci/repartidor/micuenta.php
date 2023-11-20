<?php
                session_start();
                if (isset($_SESSION['id_repartidor'])){
                        $id_cliente = $_SESSION['id_repartidor'];
                        include("../db.php");
                        $sql = "SELECT nombre, apellido, telefono,fechaNacimiento, usuario, contrasena, direccion FROM cliente WHERE idCliente = ?";
                        $consulta = $conexion->prepare($sql);
                        $consulta->bind_param("i", $id_cliente);
                        $consulta->execute();
                        $resultado = $consulta->get_result();

                        // Verifica si se encontraron registros
                        if ($fila = $resultado->fetch_assoc()) {
                            $nombre = $fila['nombre'];
                            $apellido = $fila['apellido'];
                            $fechaNacimiento = $fila['fechaNacimiento'];
                            $usuario = $fila['usuario'];
                            $contrasena = $fila['contrasena'];
                            $direccion = $fila['direccion'];
                            $telefono=$fila['telefono'];
                        }
                }
                ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Perfil</title>
    <link rel="stylesheet" href="css/micuenta.css">
    </link>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    </link>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </link>

</head>

<body>
    <div class="profile-container">
        <button class="regresar-button" onclick="window.history.back();">
            <i class="fas fa-arrow-left"></i> Regresar
        </button>
        <div class="user-profile">
            <div class="profile-image">
                
                <span id="profilePic" contenteditable="false">
                    <img src="images/<?php echo $nombre;?>.jpg" alt="Foto de perfil" id="profileImage">
                </span>
                <input type="file" id="imageInput" accept="image/*" style="display: none;"
                    onchange="updateProfileImage(event)">

                <div class="edit-profile-icon" onclick="enableEditing()">
                    <i class="fas fa-pencil-alt"></i>
                </div>
                <div class="upload-image-icon" style="display: none;" onclick="openImageInput()">
                    <i class="fas fa-camera"></i>
                </div>
            </div>
            <h2 class="profile-name"><?php echo $nombre.' '.$apellido;?></h2>
            <form class="profile-details" id="profileForm" >
    <p><i class="fas fa-user"></i> Nombre: <span id="nombre" class="editable" contenteditable="false"><?php echo $nombre; ?></span></p>
    <p><i class="fas fa-user"></i> Cargo: <span id="apellido" class="editable" contenteditable="false"><?php echo $apellido; ?></span></p>
    <p><i class="fas fa-calendar-alt"></i> Fecha de integración: <span id="dob" class="editable" contenteditable="false"><?php echo $fechaNacimiento; ?></span></p>
    <p><i class="fas fa-envelope"></i> Usuario: <span id="email" class="editable" contenteditable="false"><?php echo $usuario; ?></span></p>
    <p><i class="fas fa-phone"></i> Teléfono: <span id="phone" class="editable" contenteditable="false"><?php echo $telefono; ?></span></p>
    <p><i class="fas fa-lock"></i> Contraseña: <span id="password" class="editable" contenteditable="false"><?php echo $contrasena; ?></span></p>
    <button type="submit" id="saveButton" class="edit-button hidden" style="display: none;">Guardar</button>
</form>
        </div>
    </div>

    <div class="modal" id="confirmationModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>¿Desea guardar los cambios?</p>
            <button class="confirm-button" onclick="saveProfile()">Guardar</button>
            <button class="cancel-button" onclick="closeModal()">Cancelar</button>
        </div>
    </div>

    <div class="orders-container">
        <button class="orders-button" style="display: none;" data-id="<?php echo $id_cliente; ?>">
            Ver Historial
        </button>
        <div class="orders-list" id="ordersList">
        <?php
            $sql = "SELECT idFactura, fecha, total, direccion FROM factura WHERE idCliente = $id_cliente";
            $resultadoFacturas = $conexion->query($sql);

            if ($resultadoFacturas->num_rows > 0) {
                while ($factura = $resultadoFacturas->fetch_assoc()) {
                    $idFactura = $factura['idFactura'];
                    $fecha = $factura['fecha'];
                    $total = $factura['total'];
                    $direccion = $factura['direccion'];
                    // Comienza a construir la estructura HTML para mostrar los pedidos
                    echo '<div class="order-item">';
                    echo '<div class="order-info">';
                    echo "<p><strong>Pedido #$idFactura</strong> - Fecha: $fecha - Total: $$total</p>";
                    echo '</div>';
                    // Consulta para obtener los productos asociados a esta factura desde la tabla facpro
                    $sqlProductos = "SELECT p.nombre AS producto, fp.cantidadProducto, p.precio FROM facpro fp INNER JOIN producto p ON fp.idProducto = p.idProducto
                    WHERE fp.idFactura = ?";

                    $consultaProductos = $conexion->prepare($sqlProductos);
                    $consultaProductos->bind_param("i", $idFactura);
                    $consultaProductos->execute();
                    $resultadoProductos = $consultaProductos->get_result();

                    if ($resultadoProductos->num_rows > 0) {

                    // Muestra los detalles del pedido en una tabla
                    echo '<div class="order-details" >';
                    echo '<table class="order-table">';
                    echo '<tr><th>Producto</th><th>Cantidad</th><th>Precio</th></tr>';
                    while ($producto = $resultadoProductos->fetch_assoc()) {
                        $nombreProducto = $producto['producto'];
                        $cantidadProducto = $producto['cantidadProducto'];
                        $precioProducto = $producto['precio'];
                        echo "<tr><td>$nombreProducto</td><td>$cantidadProducto</td><td>$$precioProducto</td></tr>";
                    }

                    echo '<tr class="total-row"><td colspan="2"><strong></strong></td><td>'.$total.'</td></tr>';
                    echo '</table>';
                    echo '</div>';

                    // Cierra el div de order-item
                    
                }echo '</div>';
                }
            } else {
                echo '<p>No hay pedidos disponibles.</p>';
            }
            ?>
        </div>
    </div>
    <!-- ... (código HTML) ... -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
// Función para mostrar u ocultar la lista de facturas
function toggleOrdersList() {
    const ordersList = document.getElementById('ordersList');
    if (ordersList.style.display === 'none' || ordersList.style.display === '') {
        ordersList.style.display = 'block';
    } else {
        ordersList.style.display = 'none';
    }
}

// Obtener el botón "Ver Historial" por su clase y agregar un evento de clic
const verHistorialButton = document.querySelector('.orders-button');
verHistorialButton.addEventListener('click', toggleOrdersList);

const orderItems = document.querySelectorAll('.order-item');

// Agregar eventos de clic a las filas de factura
orderItems.forEach(orderItem => {
    // Encontrar la factura y los detalles de productos asociados a esta factura
    const orderInfo = orderItem.querySelector('.order-info');
    const orderDetails = orderItem.querySelector('.order-details');

    // Agregar evento de clic a la información de la factura para mostrar/ocultar detalles
    orderInfo.addEventListener('click', () => {
        // Alternar la visibilidad de los detalles de productos
        if (orderDetails.style.display === 'none' || orderDetails.style.display === '') {
            orderDetails.style.display = 'block';
        } else {
            orderDetails.style.display = 'none';
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const editableFields = document.querySelectorAll('.editable');
    const saveButton = document.getElementById('saveButton');

    // Función para habilitar la edición de campos
    function enableEditing() {
        editableFields.forEach(field => {
            field.contentEditable = 'true';
            field.classList.add('editable-field', 'active');
        });
        saveButton.style.display = 'block';
    }

    $(document).ready(function () {
    // Función para guardar los cambios en el perfil
    function saveProfileChanges() {
        // Recopila los datos editados
        const nombre = $('#nombre').text();
        const apellido = $('#apellido').text();
        const fechaNacimiento = $('#dob').text();
        //const usuario = $('#email').text();
        const telefono = $('#phone').text();
        const contrasena = $('#password').text();
        

        // Realiza una solicitud AJAX para enviar los datos al servidor (PHP)
        $.ajax({
            url: 'editar_datos.php', // URL del archivo PHP que manejará la actualización
            method: 'POST',
            data: {
                nombre: nombre,
                apellido: apellido,
                fechaNacimiento: fechaNacimiento,
                telefono: telefono,
                contrasena: contrasena
            },
            success: function (response) {
                if (response.success) {
                    alert('Perfil actualizado con éxito');
                    location.reload();

                } else {
                    alert('Error al actualizar el perfil');
                }
            },
            error: function () {
                alert('Error en la solicitud AJAX');
            }
        });
    }

    // Escucha el evento de clic en el botón "Guardar"
    $('#saveButton').click(function (e) {
        e.preventDefault(); // Previene la acción predeterminada del formulario
        saveProfileChanges(); // Llama a la función para guardar los cambios
    });
});   

    // Agrega eventos a los botones para habilitar la edición y guardar los cambios
    const editButton = document.querySelector('.edit-profile-icon');
    editButton.addEventListener('click', enableEditing);

    saveButton.addEventListener('click', saveProfileChanges);
});

</script>
</body>

</html>