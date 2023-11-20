
<!-- header.php -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/Header.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Llamar a la función de actualización cuando la página se carga y luego cada cierto intervalo de tiempo
        $(document).ready(function () {
            actualizarContadorCarrito();
            setInterval(actualizarContadorCarrito,600); // Actualiza cada minuto (ajusta el intervalo según tus necesidades)
        });
        $(document).ready(function () {
    // Función para actualizar el contador del carrito
        function actualizarContadorCarrito() {
            $.ajax({
                url: 'php/cantidad_carrito.php', // Archivo PHP para obtener la cantidad del carrito
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Actualizar el contador con la cantidad recibida del servidor
                    $('#cart-count').text(data.cantidad);
                },
                error: function () {
                    console.error('Error al obtener la cantidad del carrito.');
                }
            });
        }

        // Llamar a la función de actualización cuando la página se carga y luego cada cierto intervalo de tiempo
        actualizarContadorCarrito();
        setInterval(actualizarContadorCarrito, 600); // Actualiza cada minuto (ajusta el intervalo según tus necesidades)
        });
        
        
    document.addEventListener('DOMContentLoaded', function () {
        const registerForm = document.querySelector('.login-form');
        const nombreInput = document.querySelector('input[name="nombre"]');
        const correoInput = document.querySelector('input[name="correo"]');
        const fechaInput = document.querySelector('input[name="fecha"]');
        const emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com)$/;
        const nombreRegex = /^[A-Za-z]+$/;

        registerForm.addEventListener('submit', function (event) {
            if (!emailRegex.test(correoInput.value)) {
                alert('Por favor, introduce una dirección de correo electrónico válida de Gmail o Hotmail.');
                event.preventDefault(); // Evita que el formulario se envíe
            }

            if (!nombreRegex.test(nombreInput.value)) {
                alert('El nombre solo debe contener letras y no números.');
                event.preventDefault(); // Evita que el formulario se envíe
            }

            const fechaNacimiento = new Date(fechaInput.value);
            const fechaActual = new Date();

            if (fechaNacimiento >= fechaActual) {
                alert('La fecha de nacimiento debe ser menor que la fecha actual.');
                event.preventDefault(); // Evita que el formulario se envíe
            }
        });

        nombreInput.addEventListener('input', function () {
            if (!nombreRegex.test(nombreInput.value)) {
                nombreInput.setCustomValidity('El nombre solo debe contener letras y no números.');
            } else {
                nombreInput.setCustomValidity('');
            }
        });

        fechaInput.addEventListener('input', function () {
            const fechaNacimiento = new Date(fechaInput.value);
            const fechaActual = new Date();

            if (fechaNacimiento >= fechaActual) {
                fechaInput.setCustomValidity('La fecha de nacimiento debe ser menor que la fecha actual.');
            } else {
                fechaInput.setCustomValidity('');
            }
        });
    });



    </script>
    
    <title><?php echo $pageTitle; ?></title>
</head>
    <header>
        <nav>
            <div class="logo">
                <img src="/usuario/images/Logo.png" alt="Logo">
            </div>
            <ul class="nav-menu">
                <li class="nav-item"><a class="nav-link <?php if ($paginaActual === 'inicio') echo 'active'; ?>" href="inicio.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link <?php if ($paginaActual === 'menu') echo 'active'; ?>" href="menu.php">Menú</a></li>
                <!-- Otros elementos del menú -->
                <li class="nav-item"><a class="nav-link <?php if ($paginaActual === 'Contacto') echo 'active'; ?>" href="Contacto.php">Contacto</a></li>
                <li class="nav-item"><a class="nav-link <?php if ($paginaActual === 'Nosotros') echo 'active'; ?>" href="Nosotros.php">Nosotros</a></li>

            </ul>

            
            <div class="header-icons">
                
                <div class="user-icon">
                
                    <?php
                    session_start();
                    // Verifica si el usuario ha iniciado sesión
                    if (isset($_SESSION['id_cliente'])) {
                        // El usuario ha iniciado sesión, muestra el nombre de usuario y un enlace para cerrar sesión
                        $idCliente = $_SESSION['id_cliente'];
                        $servername = "localhost";
                        $username = "root";
                        $password = "Ander2003.";
                        $dbname = "restaurante";
                        $conexion = new mysqli($servername, $username, $password, $dbname);

                        // Verificar la conexión
                        if ($conexion->connect_error) {
                            die("Error de conexión: " . $conexion->connect_error);
                        }
                        $sql = "SELECT nombre FROM cliente WHERE idCliente = $idCliente";
                        $resultado = $conexion->query($sql);
                        $fila = $resultado->fetch_assoc();
                        $nombreUsuario = $fila['nombre'];
                        echo $nombreUsuario."  ";
                        echo '<i class="fas fa-user"></i>
                        <div class="user-dropdown">';
                        echo '<a href="micuenta.php">Mi Cuenta</a>'; // Agrega el enlace "Mi Cuenta" aquí
                        echo '<li><a href="php/cerrar_sesion.php">Cerrar Sesión</a></li>';

                    } else {
                        // El usuario no ha iniciado sesión, muestra los enlaces "Iniciar Sesión" y "Registrarse"
                        echo '<i class="fas fa-user"></i>
                        <div class="user-dropdown">';
                        echo '<a href="#" id="openModal">Iniciar Sesión</a>';
                        echo '<li><a href="#" id="registerLink">Registrarse</a></li>';
                    }
                    ?>
                    </div>

                </div>

                <a href="carrito.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count" class="cart-count">0</span>
                </a>
            </div>

                
               
                <div id="modal" class="modal">
                    <div class="modal-content">

                        <span id="close" class="close">&times;</span>
                        <form class="login-for" method="post" action="php/login.php">
                            <h2 class="modal-title">Iniciar Sesión</h2>

                            <div class="input-container">
                                <i class="input-icon fas fa-user"></i>
                                <input class="input-field" type="text" placeholder="Usuario" name="username" required>
                            </div>
                            <div class="input-container">
                                <i class="input-icon fas fa-lock"></i>

                                <input class="input-field password-field" type="password" minlength="8"
                                    placeholder="Contraseña" name="password" required>
                                <span class="password-toggle" id="password-toggle">
                                   
                                </span>
                            </div>
                            <p class="forgot-password"><a href="#" class="modal-link">¿Has olvidado la contraseña?</a></p>
           
                            <div class="modal-button-container">
                                <button type="submit" class="modal-button">Ingresar</button>
                            </div>
                            <p class="modal-text">¿No tienes cuenta? <a id="openRegisterModalButton" href="#"
                                    class="modal-link">Regístrate</a></p>
                        </form>
                        

                        <div class="modal" id="registerModal">
                            <div class="modal-content">
                                <span class="close" id="closeRegisterModal">&times;</span>
                                <h2 class="modal-title">Registro</h2>
                                <form class="login-form" method="post" action="php/registro.php">
                                    <!-- Agrega los campos del formulario de registro aquí -->
                                    <div class="input-container">
                                        <i class="icon fas fa-user"></i>
                                        <input type="text" placeholder="Nombre de usuario" name="nombre">
                                    </div>
                                    <div class="input-container">
                                        <i class="icon fas fa-calendar"></i>
                                        <input type="date" placeholder="Fecha de nacimiento" name="fecha" required>
                                    </div>
                                    <div class="input-container">
                                        <i class="icon fas fa-envelope"></i>
                                        <input type="email" placeholder="Correo electrónico" name="correo" required>
                                    </div>
                                    <div class="input-container">
                                        <i class="icon fas fa-lock"></i>
                                        <input type="password" placeholder="Contraseña" name="password" minlength="8" required >
                                    </div>
                                    <div class="input-container">
                                        <i class="icon fas fa-lock"></i>
                                        <input type="password" placeholder="Confirmación de contraseña" minlength="8" required>
                                    </div>


                                    <!-- Agrega más campos si es necesario -->
                                    <button class="modal-button" type="submit">Registrarse</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>




        </nav>


    </header>

   

