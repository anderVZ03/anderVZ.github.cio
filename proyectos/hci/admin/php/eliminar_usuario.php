<?php
session_start();
if (isset($_SESSION['id_administrador'])) {
// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el idCliente desde la solicitud POST
    $idCliente = isset($_POST['idCliente']) ? $_POST['idCliente'] : null;

    if ($idCliente === null) {
        // Manejar el caso en el que no se proporcionó un idCliente válido
        echo json_encode(['success' => false, 'message' => 'No se proporcionó un idCliente válido']);
        exit();
    }

    // Realizar la eliminación en la base de datos (ajusta esta parte según tu esquema de base de datos)
    $servername = "localhost";
    $username = "root";
    $password = "Ander2003.";
    $dbname = "restaurante";

    $conexion = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conexion->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
        exit();
    }

    // Preparar una consulta SQL para eliminar el cliente por su idCliente
    $sql = "DELETE FROM cliente WHERE idCliente = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idCliente);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Éxito al eliminar
        echo json_encode(['success' => true, 'message' => 'Cliente eliminado con éxito']);
    } else {
        // Error al eliminar
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el cliente']);
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    // Si la solicitud no es de tipo POST, devolvemos un mensaje de error
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
} else {
    echo json_encode(array("error" => "No se ha iniciado sesión"));
    exit();
}
?>
