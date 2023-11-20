<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Compra</title>
    <link rel="stylesheet" href="css/compra.css">
   
</head>
<body>
    <form id="formulario-paso1" action="php/parte1_formulario.php" method="post">
        <h2>Paso 1: Tipo de Compra</h2>
        <label for="tipo-compra">Tipo de Compra:</label>
        <select id="tipo-compra" name="tipo-compra">
            <option value="consumir-en-local">Consumir en el Local</option>
            <option value="para-llevar">Para Llevar</option>
            <option value="domicilio">Domicilio</option>
        </select>

        <div id="direccion-section" style="display: none;">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion">
            <label for="ciudad">Indicaciones:</label>
            <input type="text" id="ciudad" name="ciudad">
            
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono">
        </div>
        
        <button id="paso1-siguiente">Siguiente</button>
    </form>

    <form id="formulario-paso2" style="display: none;" action="php/parte2_formulario.php" method="post">
        <h2>Paso 2: Método de Pago</h2>
        <label for="metodo-pago">Método de Pago:</label>
        <select id="metodo-pago" name="metodo-pago">
            <option value="efectivo">Efectivo</option>
            <option value="tarjeta">Tarjeta</option>
        </select>
        <input type="hidden" name="idFactura" value="<?php echo $_SESSION['idFactura']; ?>"/>

        <div id="tarjeta-section" style="display: none;">
            <label for="numero-tarjeta">Número de Tarjeta:</label>
            <input type="text" id="numero-tarjeta" name="numero-tarjeta">
            <!-- Agregar más campos de tarjeta aquí -->
        </div>
        
        <button id="paso2-finalizar">Finalizar Compra</button>
    </form>

    <div id="gracias-page" style="display: none;">
        <h2>¡Gracias por tu compra!</h2>
    </div>  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    const tipoCompraSelect = document.getElementById('tipo-compra');
    const direccionSection = document.getElementById('direccion-section');
    const metodoPagoSelect = document.getElementById('metodo-pago');
    const tarjetaSection = document.getElementById('tarjeta-section');
    const graciasPage = document.getElementById('gracias-page');

    tipoCompraSelect.addEventListener('change', function () {
        if (this.value === 'domicilio') {
            direccionSection.style.display = 'block';
        } else {
            direccionSection.style.display = 'none';
        }
    });

    metodoPagoSelect.addEventListener('change', function () {
        if (this.value === 'tarjeta') {
            tarjetaSection.style.display = 'block';
        } else {
            tarjetaSection.style.display = 'none';
        }
    });
    $(document).ready(function() {
    // Escuchar el evento submit del formulario
    $('#formulario-paso1').submit(function(event) {
        event.preventDefault(); // Evitar el envío del formulario tradicional

        // Obtener los datos del formulario
        var formData = new FormData(this);

        // Realizar la solicitud AJAX para enviar el formulario
        $.ajax({
            url: 'php/parte1_formulario.php', // URL del script PHP que procesa el formulario
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    // Si la factura se creó con éxito, ocultar el formulario de paso 1
                    $('#formulario-paso1').hide();

                    // Mostrar el formulario de paso 2 o redirigir al usuario
                    if (data.message === 'Factura creada con éxito') {
                        $('#formulario-paso2').show();
                    } else {
                        window.location.href = 'php/destruir_factura.php'; // Redirección
                    }
                } else {
                    // Manejar errores si la creación de factura falla
                    console.error(data.message);
                }
            },
            error: function(xhr, status, error) {
                // Manejar errores de AJAX
                console.error(error);
            }
        });
    });
});
$(document).ready(function () {
    // Escuchar el evento submit del formulario
    $('#formulario-paso2').submit(function (event) {
        event.preventDefault(); // Evitar el envío del formulario tradicional

        // Obtener los datos del formulario
        var formData = new FormData(this);

        // Realizar la solicitud AJAX para enviar el formulario
        $.ajax({
            url: 'php/parte2_formulario.php', // URL del script PHP que procesa el formulario
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    window.location.href = 'gracias.php';
                } else {
                    // Manejar errores si la operación falla
                    console.error(data.message);
                }
            },
            error: function (xhr, status, error) {
                // Manejar errores de AJAX
                console.error(error);
            }
        });
    });
});



</script>

</body>
</html>
