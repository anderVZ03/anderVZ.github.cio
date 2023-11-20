function changeTab(tabId) {
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.content');

    tabs.forEach(tab => {
        if (tab.getAttribute('onclick').includes(tabId)) {
            tab.classList.add('active');
        } else {
            tab.classList.remove('active');
        }
    });

    contents.forEach(content => {
        if (content.getAttribute('id').includes(tabId)) {
            content.classList.add('active');
        } else {
            content.classList.remove('active');
        }
    });
}

// Aquí deberás escribir el código JavaScript para llenar la tabla de citas pendientes
// y manejar el evento de clic para eliminar una cita.

// Ejemplo de cómo agregar una fila a la tabla de citas pendientes:
const citasTable = document.getElementById('citasTable').getElementsByTagName('tbody')[0];
const row = citasTable.insertRow();
row.innerHTML = '<td>Fecha y Hora</td><td>Nombre del Paciente</td><td>Pendiente</td><td><button class="eliminarBtn">Eliminar</button></td>';

// Ejemplo de cómo manejar el evento de clic para eliminar una cita:
const eliminarBtn = document.getElementsByClassName('eliminarBtn')[0];
eliminarBtn.addEventListener('click', function () {
    // Aquí se debe realizar la lógica para eliminar la cita.
    // Puedes llamar a una función o enviar una solicitud a un archivo PHP para eliminar la cita en la base de datos.
});
