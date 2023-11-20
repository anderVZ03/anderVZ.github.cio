
$(document).ready(function() {
    // Agregar un controlador de clic a cada elemento de factura
    $('.order-item').click(function() {
        // Encuentra los detalles del pedido dentro del elemento actual
        var orderDetails = $(this).find('.order-details');
        
        // Alternar la visibilidad de los detalles (mostrar/ocultar)
        orderDetails.toggle();
    });
});
$(document).ready(function() {
    // Agregar un controlador de clic a cada botón "Listo"
    $('.ready-button').click(function() {
        // Obtener el idFactura del atributo data-order-id
        var idFactura = $(this).data('order-id');

        // Mostrar un mensaje de confirmación
        var confirmar = confirm('¿Estás seguro de que deseas marcar este pedido como listo?');

        // Verificar si se confirmó la acción
        if (confirmar) {
            // Realizar una solicitud AJAX al archivo PHP
            $.ajax({
                type: 'POST', // Puedes usar 'POST' o 'GET' según tu preferencia y configuración del servidor
                url: 'php/cambiar_estado_pedido.php', // Nombre del archivo PHP que cambiará el estado
                data: { idFactura: idFactura }, // Enviar el idFactura como dato
                success: function(response) {
                    // Manejar la respuesta del servidor si es necesario
                    console.log('Estado cambiado con éxito');
                    // Puedes agregar aquí más acciones después de cambiar el estado
                                            location.reload();

                },
                error: function() {
                    console.error('Error al cambiar el estado del pedido');
                }
            });

            // Alternar la visibilidad de los detalles del pedido si es necesario
            var orderDetails = $(this).closest('.order-item').find('.order-details');
            orderDetails.toggle();
        }
    });
});


