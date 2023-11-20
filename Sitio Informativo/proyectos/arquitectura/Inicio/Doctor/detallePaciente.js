// Aquí deberás escribir el código JavaScript para obtener los datos del paciente y mostrarlos,
// además de manejar el evento de clic para eliminar la cita.

// Ejemplo de cómo obtener los datos del paciente y mostrarlos:
const pacienteDataDiv = document.getElementById('pacienteData');
pacienteDataDiv.innerHTML = '<p>Nombre: Juan Pérez</p><p>Fecha de Nacimiento: 1990-01-01</p><p>Dirección: Calle 123, Ciudad</p>';

// Ejemplo de cómo manejar el evento de clic para eliminar una cita:
const eliminarCitaBtn = document.getElementById('eliminarCitaBtn');
eliminarCitaBtn.addEventListener('click', function () {
    // Aquí se debe realizar la lógica para eliminar la cita.
    // Puedes llamar a una función o enviar una solicitud a un archivo PHP para eliminar la cita en la base de datos.
});
