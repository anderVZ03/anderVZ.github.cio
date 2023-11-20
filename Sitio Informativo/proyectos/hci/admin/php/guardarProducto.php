<?php
// Datos de la base de datos
include("../../db.php");
session_start();

if (isset($_SESSION['user_id'])) {
    $idUsuario = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtener los datos del formulario
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $idCategoria = $_POST["categoria"];
        $descripcion = $_POST["descripcion"];

        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        
        // Preparar la consulta SQL para insertar el producto
        $sql = "INSERT INTO producto (nombre, precio, idCategoria, descripcion, disponibilidad,imagen) VALUES (?, ?, ?, ?, 1,?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssdsb", $nombre, $precio, $idCategoria, $descripcion,$imagen);
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // El producto se ha insertado correctamente en la base de datos
    
            // Cerrar el statement y la conexión
            $stmt->close();
            $conexion->close();
    
            // Ruta de destino donde quieres copiar la imagen (ajusta esto según tu estructura de carpetas)
            $rutaDestino = "/hola"; // Cambia la extensión según el formato de la imagen
            
            // Mover la imagen desde la ubicación temporal a la ruta de destino
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino."/".$nombre)) {
                // La imagen se ha copiado correctamente
                
                // Redireccionar a la página deseada después de guardar el producto (reemplaza "pagina_destino.php")
                header("Location: ../index.php");
                exit();
            } else {
                // Error al copiar la imagen
                echo "Error al copiar la imagen a la ruta de destino.";
            }
        } else {
            // Error al insertar el producto
            echo "Error al guardar el producto: " . $stmt->error;
            $stmt->close();
            $conexion->close();
        }
    }
} else {
    // Si no se ha iniciado sesión, devolvemos una respuesta JSON con un mensaje de error
    echo json_encode(array("error" => "No se ha iniciado sesión"));
}
?>
