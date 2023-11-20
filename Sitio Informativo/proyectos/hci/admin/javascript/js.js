

// Obtener elementos del DOM
const modalAgregar = document.getElementById("modal-agregar");
const btnAgregarCocinero = document.querySelector(".agregar-cocinero");
const cerrarModal = document.getElementById("cerrar-modal");
const formularioAgregarCocinero = document.getElementById("formulario-agregar-cocinero");
const listadoCocineros = document.querySelector(".tabla-cocineros");
function toggleMenu() {
    var menuContenido = document.querySelector('.menu-contenido');
    menuContenido.classList.toggle('oculto');
}
// Agrega un evento de clic al botón de menú (menu-btn)
var menuBtn = document.querySelector('.menu-btn');
menuBtn.addEventListener('click', toggleMenu);
// Función para abrir el modal
function abrirModal() {
    modalAgregar.style.display = "block";
}

// Función para cerrar el modal
function cerrarModalFunc() {
    modalAgregar.style.display = "none";
}

// Evento para abrir el modal al hacer clic en "Agregar"
btnAgregarCocinero.addEventListener("click", abrirModal);

// Evento para cerrar el modal al hacer clic en la "X"
cerrarModal.addEventListener("click", cerrarModalFunc);

// Evento para cerrar el modal si se hace clic fuera del contenido del modal
window.addEventListener("click", (event) => {
    if (event.target === modalAgregar) {
        cerrarModalFunc();
    }
});

// Selecciona todos los botones "Eliminar" por su clase
$(document).ready(function () {
    // Captura el clic en un botón "Eliminar"
    $(".eliminar-cocina").click(function () {
        // Obtiene el valor de data-id del botón clickeado
        var idCliente = $(this).data("id");

        // Muestra un cuadro de diálogo de confirmación
        var confirmacion = confirm("¿Seguro que deseas eliminar este registro?");

        if (confirmacion) {
            // El usuario confirmó, realiza la solicitud AJAX para eliminar el cliente
            $.ajax({
                url: "php/eliminar_usuario.php", // Reemplaza esto con la URL correcta de tu PHP
                method: "POST",
                data: { idCliente: idCliente },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // Éxito al eliminar, puedes realizar acciones adicionales aquí si es necesario
                        alert("Registro eliminado con éxito");
                        location.reload();
                    } else {
                        // Error al eliminar, muestra un mensaje de error
                        alert("Error al eliminar el registro: " + response.message);
                    }
                },
                error: function () {
                    // Error en la solicitud AJAX
                    alert("Error en la solicitud AJAX");
                }
            });
        }
    });
});


$(document).ready(function () {
    // Captura el clic en un botón "Editar"
    $(".editar-cocina").click(function () {
        const cocinero = $(this).closest(".cocinar");

        // Verifica si el cocinero ya está en modo de edición
        if (cocinero.hasClass("editando")) {
            guardarEdicionCocinero(cocinero);
        } else {
            habilitarEdicionCocinero(cocinero);
        }
    });
});

// Evento para habilitar la edición de un cocinero
function habilitarEdicionCocinero(cocinero) {
    const nombreElement = cocinero.find(".celda-nombre");
    const apellidoElement = cocinero.find(".celda-apellido");
    //const usuarioElement = cocinero.find(".celda-usuario");
    const fechaNacimientoElement = cocinero.find(".celda-fecha");
    const contrasenaElement = cocinero.find(".celda-contraseña");
    const editarBoton = cocinero.find(".editar-cocina");

    // Agregar clases para resaltar campos editables
    nombreElement.addClass("campo-editable");
    apellidoElement.addClass("campo-editable");
    //usuarioElement.addClass("campo-editable");
    fechaNacimientoElement.addClass("campo-editable");
    contrasenaElement.addClass("campo-editable");

    // Guardar los valores originales en atributos data-
    nombreElement.data("originalValue", nombreElement.text());
    apellidoElement.data("originalValue", apellidoElement.text());
    //usuarioElement.data("originalValue", usuarioElement.text());
    fechaNacimientoElement.data("originalValue", fechaNacimientoElement.text());
    contrasenaElement.data("originalValue", contrasenaElement.text());
// Reemplazar la contraseña con asteriscos
const contrasena = contrasenaElement.text();
const contrasenaAsteriscos = "*".repeat(contrasena.length);
contrasenaElement.text(contrasenaAsteriscos);

    // Habilitar campos de edición
    nombreElement.attr("contenteditable", true);
    apellidoElement.attr("contenteditable", true);
    //usuarioElement.attr("contenteditable", true);
    fechaNacimientoElement.attr("contenteditable", true);

    // Cambiar el botón de editar a guardar
    editarBoton.text("Guardar");
    editarBoton.off("click");
    editarBoton.on("click", function () {
        guardarEdicionCocinero(cocinero);
    });

    // Agregar una clase para indicar que está en modo de edición
    cocinero.addClass("editando");
}
// Función para guardar los cambios de edición de un cocinero
function guardarEdicionCocinero(cocinero) {
    const nombreElement = cocinero.find(".celda-nombre");
    const apellidoElement = cocinero.find(".celda-apellido");
    const usuarioElement = cocinero.find(".celda-usuario");
    const fechaNacimientoElement = cocinero.find(".celda-fecha");
    const contrasenaElement = cocinero.find(".celda-contraseña");


    // ... (código para restaurar campos y valores originales)

    // Obtener los nuevos valores editados
    const nuevoNombre = nombreElement.text();
    const nuevoApellido = apellidoElement.text();
    const nuevoUsuario = usuarioElement.text();
    const nuevaFechaNacimiento = fechaNacimientoElement.text();
    const nuevaContrasena = contrasenaElement.text();

    // Obtener el idCliente del cocinero
    var idCliente = cocinero.data("id");

    // Realizar una solicitud AJAX para actualizar los datos en la base de datos
    $.ajax({
        url: "php/editar_usuario.php", // Reemplaza esto con la URL correcta de tu PHP para editar
        method: "POST",
        data: {
            idCliente: idCliente,
            nombre: nuevoNombre,
            apellido: nuevoApellido,
            usuario: nuevoUsuario,
            fechaNacimiento: nuevaFechaNacimiento,
            contrasena: nuevaContrasena
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                console.log(idCliente, nuevoNombre, nuevoApellido, nuevoUsuario, nuevaFechaNacimiento, nuevaContrasena);
                alert("Registro editado con éxito");
                location.reload();
            } else {
                // Error al editar, muestra un mensaje de error
                alert("Error al editar el registro: " + response.message);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            // Error en la solicitud AJAX
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        }
    });
}


    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formulario-agregar-cocinero');
        const nombreInput = document.getElementById('Nombre');
        const apellidoInput = document.getElementById('Apellido');
        const usuarioInput = document.getElementById('usuario_editar');
        const fechaInput = document.getElementById('Fecha');
        const telefonoInput = document.getElementById('telefono_editar');
        const emailRegex = /^(.*@gmail\.com|.*@hotmail\.com)$/;

        form.addEventListener('submit', function (event) {
            let valid = true;

            if (!nombreInput.value.match(/^[A-Za-z]+$/)) {
                alert('El nombre debe contener solo letras.');
                valid = false;
            }

            

            if (!emailRegex.test(usuarioInput.value)) {
                alert('El usuario debe terminar en @gmail.com o @hotmail.com.');
                valid = false;
            }

            const fechaNacimiento = new Date(fechaInput.value);
            const fechaActual = new Date();

            if (fechaNacimiento >= fechaActual) {
                alert('La fecha de nacimiento debe ser menor que la fecha actual.');
                valid = false;
            }

            if (telefonoInput.value.length >= 10) {
                alert('El número de teléfono debe tener menos de 10 caracteres.');
                valid = false;
            }

            if (!valid) {
                event.preventDefault(); // Evita que el formulario se envíe si hay errores
            }
        });

        // Validación en tiempo real para el campo de usuario
        usuarioInput.addEventListener('input', function () {
            if (!emailRegex.test(usuarioInput.value)) {
                usuarioInput.setCustomValidity('El usuario debe terminar en @gmail.com o @hotmail.com.');
            } else {
                usuarioInput.setCustomValidity('');
            }
        });
    });

