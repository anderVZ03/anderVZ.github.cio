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

cambiarPestana(pestanaActiva);
        function cambiarPestana(pestana) {
            var pestañas = document.getElementsByClassName('pestana');
            for (var i = 0; i < pestañas.length; i++) {
                pestañas[i].style.backgroundColor = '#ccc';
            }
            //localStorage.setItem('pestanaActiva', pestana);
            document.getElementById(pestana).style.backgroundColor = '#f2f2f2';

            if (pestana === 'verCitas') {
                mostrarCitas(obtenerParametrosURL());
            } else if (pestana === 'Agendar') {
                agendarCita(obtenerParametrosURL());
            } else if (pestana === 'modificarDatos') {
                modificarDatos(obtenerParametrosURL());
            } else {
                document.getElementById('datosPacientes').innerHTML = '';
            }
        }

        function obtenerParametrosURL() {
            var urlParams = new URLSearchParams(window.location.search);
            var id_entidad = urlParams.get('id');
            return id_entidad;
        }


        function agendarCita(idPaciente) {
            window.location.href = "Agendar/agendar.php?id=" + encodeURIComponent(idPaciente);

        }
        function mostrarCitas(id) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("datosPacientes").innerHTML = xhr.responseText;
                }
            };

            // Agrega el parámetro 'id' a la URL de la solicitud
            xhr.open("GET", "datosCita/consultar/consulta.php?id=" + encodeURIComponent(id), true);
            xhr.send();
        }

        function eliminarCita(id) {
            // Preguntar al usuario si está seguro de eliminar la cita
            var respuesta = confirm("¿Estás seguro de que deseas eliminar esta cita?");

            if (respuesta) {
                // Realizar la solicitud AJAX para eliminar el registro
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "datosCita/eliminar/eliminar.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        alert(xhr.responseText);
                        // Actualizar la lista de citas después de eliminar
                        mostrarCitas(obtenerParametrosURL());
                    }
                };
                xhr.send("id=" + id);
            } else {
                // El usuario canceló la eliminación
                alert("Eliminación cancelada.");
            }
        }

        function modificarDatos(idPaciente) {
            window.location.href = "ModificarDatos/consulta.php?id=" + encodeURIComponent(idPaciente);
        }
        function redireccionar() {
            // Cambia la URL de abajo por la página a la que deseas redireccionar al hacer clic en "Salir"
            var urlRedireccion = "../../InicioSesion.html"; // Ejemplo de URL
            window.location.replace(urlRedireccion);

            // Agregar la nueva URL al historial sin cargar una nueva página
            history.pushState(null, null, urlRedireccion);
        }

        // Detectar cuando el usuario intenta utilizar el botón de retroceso del navegador
        window.addEventListener('popstate', function (event) {
            // Cambia la URL de abajo por la página a la que deseas redireccionar cuando se intente retroceder
            var urlRedireccion = "https://ejemplo.com"; // Ejemplo de URL
            window.location.replace(urlRedireccion);

            // Agregar la nueva URL al historial sin cargar una nueva página
            history.pushState(null, null, urlRedireccion);
        });
