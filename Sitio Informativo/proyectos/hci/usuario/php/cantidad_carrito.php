<?php
session_start();
if (isset($_SESSION['id_cliente'])) {
// Verificar si hay una sesión existente para el carrito y obtenerla
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

// Calcular la cantidad total de elementos en el carrito
$cantidadCarrito = count($carrito);

// Crear una respuesta JSON con la cantidad
$response = ['cantidad' => $cantidadCarrito];

// Enviar la respuesta JSON al cliente
header('Content-Type: application/json');
echo json_encode($response);
}
?>