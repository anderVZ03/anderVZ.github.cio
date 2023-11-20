<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se ha subido una imagen
        // Obtener datos del formulario
        $nombrePlato = $_POST['nombre'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $categoriaId = $_POST['categoria']; // Cambia esto según tu necesidad

        // Obtener información de la imagen
        $tipoImagen = $_FILES['imagen']['type'];
        $nombreImagen = $_FILES['imagen']['name'];
        $sizeImagen = $_FILES['imagen']['size'];
        $tmp=$_FILES['imagen']['tmp_name'];

        // Verificar si el tipo de imagen es válido (puedes ajustar los tipos permitidos según tus necesidades)
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($tipoImagen, $tiposPermitidos)) {
            echo 'El tipo de imagen no es válido. Se permiten imágenes JPEG, PNG y GIF.';
            exit();
        }
        $destino=$_SERVER['DOCUMENT_ROOT'].'/admin/images/temporales/';
        $rutaCompleta=$destino.$nombreImagen;
    
        /*if (copy($_FILES['imagen']['tmp_name'],'/')) {
            chmod($rutaCompleta, 0777);
            echo 'Imagen copiada con éxito a: ' . $rutaCompleta;
        } else {
            echo 'Error al copiar la imagen.';
        }
        // Leer el contenido de la imagen en un blob
        $imagenTemporal=fopen($rutaCompleta,"r");
        $contenido=fread($imagenTemporal,$sizeImagen);
        fclose($imagenTemporal);
        */
        // Ejemplo de conexión a la base de datos (ajusta las credenciales según tu configuración)
        $servername = "localhost";
        $username = "root";
        $password = "Ander2003.";
        $dbname = "restaurante";

        $conexion = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Preparar una consulta para insertar datos en la base de datos
        $sql = "INSERT INTO producto (nombre, precio, descripcion, idCategoria) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sdsi", $nombrePlato, $precio, $descripcion, $categoriaId);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            header('Location: ../producto.php');
        } else {
            echo 'Error al agregar el plato: ' . $stmt->error;
        }

        // Cerrar la conexión a la base de datos
        $conexion->close();
    
} else {
    // La solicitud no es de tipo POST, puedes manejarlo según tus necesidades
    header('HTTP/1.1 405 Method Not Allowed');
    exit('Método no permitido');
}
?>