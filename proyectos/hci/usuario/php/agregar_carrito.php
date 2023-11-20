<?php
session_start();
if (isset($_SESSION['id_cliente'])) {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados mediante la solicitud AJAX
    $nombreProducto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];

    // Verificar si hay una sesión existente para el carrito y obtenerla
    $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

    // Agregar el producto al carrito con la cantidad
    $carrito[] = [
        'producto' => $nombreProducto,
        'cantidad' => $cantidad
    ];

    // Guardar el carrito actualizado en la sesión
    $_SESSION['carrito'] = $carrito;

    // Crear una respuesta JSON
    $response = ['message' => 'Producto agregado al carrito correctamente', 'nombre' => $nombreProducto];

    // Enviar la respuesta JSON al cliente
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // La solicitud no es ni POST ni GET, puedes manejarla según tus necesidades
    header('HTTP/1.1 405 Method Not Allowed');
    exit('Método no permitido');
}}

?>