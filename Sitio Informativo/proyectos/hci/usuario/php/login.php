<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Ander2003.";
$dbname = "restaurante";

// Obtener los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["username"];
    $contrasena = $_POST["password"];

    // Crear conexión con la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta para buscar las credenciales en la tabla "cliente"
    $sql_cliente = "SELECT idCliente, nivel, contrasena FROM cliente WHERE usuario = ?";
    $stmt_cliente = $conn->prepare($sql_cliente);
    $stmt_cliente->bind_param("s", $correo);
    $stmt_cliente->execute();
    $resultado_cliente = $stmt_cliente->get_result();

    // Verificar si se encontraron datos en alguna tabla
    if ($resultado_cliente->num_rows === 1) {
        if ($resultado_cliente->num_rows === 1) {
            $fila = $resultado_cliente->fetch_assoc();
            $id_cliente = $fila["idCliente"];
            $contraseñaAlmacenada = $fila["contrasena"];
            $nivelUsuario = $fila["nivel"];
        
            if ($contrasena === $contraseñaAlmacenada && $nivelUsuario === 0) {
                session_start();
                $_SESSION["id_administrador"] = $fila["idCliente"];
                header("Location: ../../admin/producto.php");
                exit();
            } elseif ($contrasena === $contraseñaAlmacenada && $nivelUsuario === 1) {
                session_start();
                $_SESSION["id_cocinero"] = $fila["idCliente"];
                header("Location: ../../cocinero/pedidosencurso.php");
                exit();
            } elseif ($contrasena === $contraseñaAlmacenada && $nivelUsuario === 2) {
                session_start();
                $_SESSION["id_repartidor"] = $fila["idCliente"];
                header("Location: ../../repartidor/pedidosporentregar.php");
                exit();
            } elseif ($contrasena === $contraseñaAlmacenada) {
                // Aquí, usa la variable correcta para el cliente
                session_start();
                $_SESSION["id_cliente"] = $fila["idCliente"];
                header("Location: ../menu.php");
                exit();
            }
        }
    }         else {
        echo "El usuario o la contraseña son incorrectos.";
        echo "<script>
                setTimeout(function() {
                    window.location.href = '../menu.php';
                }, 2000);
             </script>";
        exit();
    }

    // Cerrar los statements y la conexión
    $stmt_cliente->close();
    $conn->close();
}
?>