// Obtener elementos del DOM
const modalAgregar = document.getElementById("modal-agregar");
const btnAgregarPlato = document.querySelector(".agregar-plato");
const cerrarModal = document.getElementById("cerrar-modal");
const formularioAgregarPlato = document.getElementById("formulario-agregar-plato");
const listadoPlatos = document.querySelector(".tabla-platos");
const btnFiltrar = document.getElementById("btn-filtrar");
const opcionesFiltrado = document.getElementById("opciones-filtrado");

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
btnAgregarPlato.addEventListener("click", abrirModal);

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
    $(".eliminar-plato").click(function () {
        // Obtiene el valor de data-id del botón clickeado
        var idProducto = $(this).data("id");

        // Muestra un cuadro de diálogo de confirmación
        var confirmacion = confirm("¿Seguro que deseas eliminar este registro?");

        if (confirmacion) {
            // El usuario confirmó, realiza la solicitud AJAX para eliminar el cliente
            $.ajax({
                url: "php/eliminar_plato.php", // Reemplaza esto con la URL correcta de tu PHP
                method: "POST",
                data: { idProducto: idProducto },
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
    $(".editar-plato").click(function () {
        const plato = $(this).closest(".plato");
        if (plato.hasClass("editando")) {
            guardarEdicionPlato(plato);
        } else {
            habilitarEdicionPlato(plato);
        }
    });
});

// Evento para habilitar la edición de un plato
function habilitarEdicionPlato(plato) {
    const nombreElement = plato.find(".celda-nombre");
    const categoriaElement = plato.find(".celda-categoria");
    const descripcionElement = plato.find(".celda-descripcion");
    const precioElement = plato.find(".celda-precio");
    const editarBoton = plato.find(".editar-plato");

    // Agregar clases para resaltar campos editables
    nombreElement.addClass("campo-editable");
    categoriaElement.addClass("campo-editable");
    descripcionElement.addClass("campo-editable");
    precioElement.addClass("campo-editable");

    // Guardar los valores originales en atributos data-
    nombreElement.data("originalValue", nombreElement.text());
    categoriaElement.data("originalValue", categoriaElement.text());
    descripcionElement.data("originalValue", descripcionElement.text());
    precioElement.data("originalValue", precioElement.text());

    // Habilitar campos de edición
    nombreElement.attr("contenteditable", true);
    categoriaElement.attr("contenteditable", true);
    descripcionElement.attr("contenteditable", true);
    precioElement.attr("contenteditable", true);

    // Cambiar el botón de editar a guardar
    editarBoton.text("Guardar");
    editarBoton.off("click");
    editarBoton.on("click", function () {
        guardarEdicionPlato(plato);
    });

    // Agregar una clase para indicar que está en modo de edición
    plato.addClass("editando");
}

// Función para guardar los cambios de edición de un plato
function guardarEdicionPlato(plato, idProducto) {
    const nombreElement = plato.find(".celda-nombre");
    const categoriaElement = plato.find(".celda-categoria");
    const descripcionElement = plato.find(".celda-descripcion");
    const precioElement = plato.find(".celda-precio");
    const idProductoo = plato.find(".editar-plato").data("id");

    // ... (código para restaurar campos y valores originales)

    // Obtener los nuevos valores editados
    const nuevoNombre = nombreElement.text();
    const nuevaCategoria = categoriaElement.text();
    const nuevaDescripcion = descripcionElement.text();
    const nuevoPrecio = precioElement.text();
    // Realizar una solicitud AJAX para actualizar los datos en la base de datos
    console.log(idProductoo);    $.ajax({
        url: "php/editar_producto.php", // Reemplaza esto con la URL correcta de tu PHP para editar
        method: "POST",
        data: {
            idProducto:idProductoo,
            nombre:nuevoNombre,
            categoria:nuevaCategoria,
            descripcion:nuevaDescripcion,
            precio:nuevoPrecio
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                alert("Plato editado con éxito");
                location.reload();
            } else {
                // Error al editar, muestra un mensaje de error
                alert("Error al editar el plato: " + response.message);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            // Error en la solicitud AJAX
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        }
    });
}

// Resto del código para eliminar platos
// Variables para los elementos HTML
const categoriaSeleccionada = document.getElementById("categoria");
const precioMenor = document.getElementById("precioMenor");
const precioMayor = document.getElementById("precioMayor");
const alfabetico = document.getElementById("alfabeticamente");

// Almacenar los platos originales en una variable
const platosOriginales = Array.from(document.querySelectorAll(".plato"));

// Mostrar u ocultar opciones de filtrado al hacer clic en el botón "Filtrar"
btnFiltrar.addEventListener("click", () => {
    opcionesFiltrado.style.display = opcionesFiltrado.style.display === "none" || opcionesFiltrado.style.display === "" ? "block" : "none";
});

// Evento para manejar el clic en el botón de filtrado
document.getElementById("filtrar").addEventListener("click", () => {
    // Obtener el valor seleccionado de la categoría y el tipo de filtro
    const categoriaSeleccionadaValue = categoriaSeleccionada.value;
    const filtroSeleccionado = precioMenor.checked
        ? "precioMenor"
        : precioMayor.checked
        ? "precioMayor"
        : alfabetico.checked
        ? "alfabeticamente"
        : "masReciente"; // Agrega lógica para el filtro "masReciente" si es necesario

    // Clonar los platos originales para aplicar el filtro
    const platos = [...platosOriginales];

    // Filtrar por categoría
    const platosFiltrados = platos.filter((plato) => {
        const categoriaPlato = plato.querySelector(".celda-categoria").textContent;
        return categoriaSeleccionadaValue === "Todos" || categoriaPlato === categoriaSeleccionadaValue;
    });

    // Aplicar el ordenamiento
    if (filtroSeleccionado === "precioMenor") {
        platosFiltrados.sort((a, b) => {
            const precioA = parseFloat(a.querySelector(".celda-precio").textContent.replace("Precio: $", ""));
            const precioB = parseFloat(b.querySelector(".celda-precio").textContent.replace("Precio: $", ""));
            return precioA - precioB;
        });
    } else if (filtroSeleccionado === "precioMayor") {
        platosFiltrados.sort((a, b) => {
            const precioA = parseFloat(a.querySelector(".celda-precio").textContent.replace("Precio: $", ""));
            const precioB = parseFloat(b.querySelector(".celda-precio").textContent.replace("Precio: $", ""));
            return precioB - precioA;
        });
    } else if (filtroSeleccionado === "alfabeticamente") {
        platosFiltrados.sort((a, b) => {
            const nombreA = a.querySelector(".celda-nombre").textContent.toLowerCase();
            const nombreB = b.querySelector(".celda-nombre").textContent.toLowerCase();
            return nombreA.localeCompare(nombreB);
        });
    } else if (filtroSeleccionado === "masReciente") {
        platosFiltrados.sort((a, b) => {
            // Implementa la lógica de ordenamiento por fecha más reciente
            // aquí según tu estructura de datos.
            // Puedes usar atributos de fecha o timestamp para comparar.
        });
    }

    // Limpiar la lista actual de platos
    listadoPlatos.innerHTML = "";

    // Agregar los platos filtrados nuevamente a la lista
    platosFiltrados.forEach((plato) => {
        listadoPlatos.appendChild(plato);
    });
});
