document.addEventListener('DOMContentLoaded', () => {
    const imagenDerecha = document.querySelector('.imagen-derecha');
    imagenDerecha.addEventListener('mouseover', () => {
        imagenDerecha.classList.add('rotar');
    });
    imagenDerecha.addEventListener('mouseout', () => {
        imagenDerecha.classList.remove('rotar');
    });
});

// Función para cambiar de pestaña
function changeTab(tabId) {
    // Ocultar todas las pestañas
    const allTabs = document.querySelectorAll('.content');
    allTabs.forEach(tab => {
        tab.classList.remove('active');
    });

    // Mostrar la pestaña seleccionada
    const selectedTab = document.getElementById(tabId);
    selectedTab.classList.add('active');
}

// Función para mostrar el nombre del doctor en la bienvenida
function mostrarNombreDoctor() {
    // Hacemos la solicitud AJAX para obtener el nombre del doctor
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Convertimos la respuesta JSON a un objeto JavaScript
            const data = JSON.parse(xhr.responseText);

            // Obtenemos el elemento donde se mostrará el nombre de bienvenida
            const bienvenidaDoctorElement = document.getElementById('bienvenidaDoctor');

            // Mostramos el mensaje de bienvenida con el nombre del doctor
            bienvenidaDoctorElement.textContent = '¡Bienvenido, Dr. ' + data.doctorName + '!';
        }
    };
    xhr.open('GET', 'obtenerNombreDoctor.php', true);
    xhr.send();
}

// Función para mostrar las citas pendientes y realizadas
function mostrarCitas() {
    // Hacemos la solicitud AJAX al archivo PHP para obtener las citas pendientes y realizadas
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Convertimos la respuesta JSON a un objeto JavaScript
            const citas = JSON.parse(xhr.responseText);

            // Llenamos la tabla de citas pendientes y realizadas con los datos obtenidos
            const citasTable = document.getElementById('citasTable').getElementsByTagName('tbody')[0];
            citasTable.innerHTML = ''; // Limpiamos la tabla antes de llenarla

            // Llenar la tabla de citas pendientes
            citas.pendientes.forEach(cita => {
                const row = citasTable.insertRow();
                row.innerHTML = `<td>${cita.fechaHora}</td><td>${cita.paciente}</td><td>${cita.estado}</td><td>
                <button class="realizadoBtn" onclick="cambiarEstadoCita(${cita.idCita})">Realizado</button>
            </td>`;
            });

            // Llenar la tabla de citas realizadas
            citas.realizados.forEach(cita => {
                const row = citasTable.insertRow();
                row.innerHTML = `<td>${cita.fechaHora}</td><td>${cita.paciente}</td><td>${cita.estado}</td><td>
                <button class="realizadoBtn" disabled>Realizado</button>
                <button class="eliminarRealizadoBtn" onclick="eliminarCita(${cita.idCita})">Eliminar</button>
            </td>`;
            });
        }
    };
    xhr.open('GET', 'obtenerCitas.php', true);
    xhr.send();
}

// Función para eliminar una cita
function eliminarCita(idCita) {
    if (confirm("¿Estás seguro de que deseas eliminar esta cita?")) {
        // Realizar la solicitud AJAX para eliminar el registro
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "cambiarEstadoCita.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText);
                // Actualizar la lista de citas después de eliminar
                mostrarCitas();
            }
        };
        // Agrega el parámetro "option" con valor "eliminar"
        xhr.send("idCita=" + idCita + "&option=eliminar");
    }
}

// Función para cambiar el estado de una cita a "Realizado"
function cambiarEstadoCita(idCita) {
    // Hacemos la solicitud AJAX al archivo PHP para cambiar el estado de la cita a "Realizado"
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Una vez cambiado el estado, volvemos a cargar las citas para refrescar la tabla
            mostrarCitas();
        }
    };
    xhr.open('POST', 'cambiarEstadoCita.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('idCita=' + idCita);
}

// Función para mostrar los horarios de disponibilidad del doctor
function mostrarHorarios() {
    // Hacemos la solicitud AJAX al archivo PHP para obtener los horarios de disponibilidad
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Convertimos la respuesta JSON a un objeto JavaScript
            const horarios = JSON.parse(xhr.responseText);

            // Obtenemos la tabla de horarios
            const horariosTable = document.getElementById('horariosTable').getElementsByTagName('tbody')[0];

            // Limpiamos la tabla antes de llenarla
            horariosTable.innerHTML = '';

            // Llenar la tabla con los horarios y agregar botones de eliminar
            horarios.forEach(horario => {
                const row = horariosTable.insertRow();
                row.innerHTML = `<td>${horario.diaSemana}</td><td>${horario.tiempoInicio}</td><td>${horario.tiempoFin}</td><td>
                    <button class="eliminarHorarioBtn" onclick="eliminarHorario(${horario.idDisponibilidad})">Eliminar</button>
                </td>`;
            });
        }
    };
    xhr.open('GET', 'obtenerHorario.php', true); // Cambia 'obtenerHorarios.php' por el archivo que obtiene los horarios desde la base de datos
    xhr.send();
}

function eliminarHorario(idDisponibilidad) {
    // Creamos un objeto FormData para enviar el ID del horario en la solicitud POST
    const formData = new FormData();
    formData.append('idDisponibilidad', idDisponibilidad);

    // Hacemos la solicitud AJAX para eliminar el horario
    fetch('obtenerHorario.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.success);
            // Actualizar la lista de horarios después de eliminar
            mostrarHorarios();
        } else if (data.error) {
            alert(data.error);
        }
    })
    .catch(error => {
        console.error('Error al enviar la solicitud:', error);
    });
}
// Función para cambiar la contraseña del doctor
function cambiarContrasena() {
    // Obtener la nueva contraseña y confirmar contraseña del formulario
    const nuevaContrasena = document.getElementById('nuevaContrasena').value.trim();
    const confirmarContrasena = document.getElementById('confirmarContrasena').value.trim();

    // Verificar que la contraseña no esté vacía
    if (nuevaContrasena === '') {
        alert('La contraseña no puede estar vacía');
        return;
    }

    // Verificar que las contraseñas coincidan
    if (nuevaContrasena !== confirmarContrasena) {
        alert('Las contraseñas no coinciden');
        return;
    }

    // Crear un objeto con los datos a enviar
    const data = {
        nuevaContrasena: nuevaContrasena,
        confirmarContrasena: confirmarContrasena
    };

    // Hacemos la solicitud AJAX al archivo PHP para cambiar la contraseña en la base de datos
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.error) {
                    alert(response.error);
                } else if (response.success) {
                    alert(response.success);
                    // Limpiamos los campos del formulario después de cambiar la contraseña
                    document.getElementById('nuevaContrasena').value = '';
                    document.getElementById('confirmarContrasena').value = '';
                } else {
                    alert('Error al cambiar la contraseña');
                }
            } else {
                alert('Error al realizar la solicitud');
            }
        }
    };
    xhr.open('POST', 'cambiarContrasena.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json'); // Indicamos que los datos se enviarán en formato JSON
    xhr.send(JSON.stringify(data)); // Convertimos el objeto a JSON antes de enviarlo
}

// Función para guardar un horario de disponibilidad del doctor
function guardarHorario() {
    // Obtener los datos del formulario
    const diasSemana = Array.from(document.getElementById('diasSemana').selectedOptions).map(option => option.value);
    const horaInicio = document.getElementById('horaInicio').value;
    const horaFin = document.getElementById('horaFin').value;

    // Crear un objeto con los datos a enviar
    const data = {
        diasSemana: diasSemana,
        horaInicio: horaInicio,
        horaFin: horaFin
    };

    // Hacemos la solicitud AJAX al archivo PHP para guardar el horario en la base de datos
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            // Actualizamos la tabla de horarios después de guardar
            mostrarHorarios();
        }
    };
    xhr.open('POST', 'guardarHorario.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('data=' + JSON.stringify(data));
}

// Función para cerrar la sesión del doctor
function cerrarSesion() {
    // Hacemos la solicitud AJAX al archivo PHP para cerrar la sesión
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert('Sesión cerrada exitosamente');
            // Redireccionamos a la página de inicio de sesión después de cerrar la sesión
            window.location.href = '../../InicioSesion.html';
        } 
    };
    xhr.open('GET', 'cerrarSesion.php', true); // Cambia 'cerrarSesion.php' por el nombre del archivo PHP que cierra la sesión
    xhr.send();
    window.history.pushState({}, '', '../../InicioSesion.html');
}
// Llamadas a las funciones para mostrar las citas y horarios al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    mostrarCitas();
    mostrarHorarios();
    mostrarNombreDoctor();
});
