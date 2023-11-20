<?php
session_start();
if (isset($_SESSION['id_cliente'])) {
      
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $idCliente=$_SESSION['id_cliente'];
            $id_factura=$_SESSION['idFactura'];
            include("../../db.php");
            $metodo_pago=$_POST['metodo-pago'];
            $insertarFactura = "UPDATE factura set metodo=? where idFactura=?";

            // Preparar la consulta
            $stmt = $conexion->prepare($insertarFactura);

            // Enlazar los parámetros
            $stmt->bind_param("si", $metodo_pago, $id_factura);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Guardar el idFactura en la sesión para su uso posterior
                $_SESSION['idFactura'] = $idFactura;
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Factura creada con éxito']);
                exit();
            
        }
    }else {
        // La solicitud no es ni POST ni GET, puedes manejarla según tus necesidades
        header('HTTP/1.1 405 Method Not Allowed');
        exit('Método no permitido');
    }
}

?>