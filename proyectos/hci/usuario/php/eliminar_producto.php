<?php
session_start();
if (isset($_SESSION['id_cliente'])) {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreProducto = $_POST['producto'];

    // Verificar si hay una sesión existente para el carrito y obtenerla
    $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

    // Buscar el producto por su nombre y eliminarlo del carrito
    foreach ($carrito as $indice => $item) {
        if ($item['producto'] === $nombreProducto) {
            unset($carrito[$indice]);
            break; // Rompe el bucle una vez que se ha eliminado el producto
        }
    }

    // Guardar el carrito actualizado en la sesión
    $_SESSION['carrito'] = array_values($carrito); // Reindexa el array para eliminar los espacios vacíos

    // Puedes enviar una respuesta JSON si lo deseas
    $response = ['success' => true];
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // La solicitud no es de tipo POST, puedes manejarlo según tus necesidades
    header('HTTP/1.1 405 Method Not Allowed');
    exit('Método no permitido');
}}
?>
