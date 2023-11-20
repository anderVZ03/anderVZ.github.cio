<!DOCTYPE html>
<html>
<head>
        
    <meta charset="UTF-8">
    <title>Generar Cita</title>
    <link rel="stylesheet" href="estilo.css">
     
</head>
<body>

    <div class="container">
    <button class="btn-regresar" onclick="regresar()">Regresar</button>
        <h2>Generar Cita</h2>
        <form action="insertar_cita.php" method="post">
            <!-- Eliminamos el campo de paciente ya que se obtendrá desde el HTML anterior -->
            <label for="area">Área:</label>
            <select name="area" id="area" required>
                <option value="" selected>Seleccione un área</option>
                <?php
                // Código PHP para obtener la lista de áreas desde la base de datos
                include("../../../db.php");
                $sql = "SELECT idArea, area FROM area";
                $resultado = $conexion->query($sql);

                while ($fila = $resultado->fetch_assoc()) {
                    echo "<option value='" . $fila['idArea'] . "'>" . $fila['area'] . "</option>";
                }

                $resultado->close();
                $conexion->close();
                ?>
            </select><br><br>

            <label for="doctor">Doctor:</label>
            <select name="doctor" id="doctor" required>
                <option value="" selected>Seleccione un doctor</option>
            </select><br><br>

            <label for="fecha_hora">Fecha y Hora:</label>
            <input type="datetime-local" name="fecha_hora" id="fecha_hora" required min="" /><br><br>

            <input type="hidden" name="paciente" value="<?php echo $_GET['id']; ?>">
            <!-- Cambiamos el valor del atributo 'name' del botón a 'agendar' -->
            <input type="submit" value="Generar Cita" name="submit">
        </form>
    </div>

    <script>
    // Función para cargar los doctores según el área seleccionada
    function cargarDoctoresPorArea() {
        // Obtener el valor seleccionado del área
        const idArea = document.getElementById("area").value;

        // Realizar la consulta AJAX
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                // Actualizar el campo de selección de doctores con la respuesta recibida
                document.getElementById("doctor").innerHTML = this.responseText;
            }
        };

        // Consulta AJAX para obtener los doctores según el área seleccionada
        xhttp.open("GET", "doc.php?idArea=" + idArea, true);
        xhttp.send();
    }

    // Asignar el evento 'change' al campo de selección del área
    document.getElementById("area").addEventListener("change", cargarDoctoresPorArea);

    // Cargar los doctores iniciales al cargar la página (si un área está preseleccionada)
    cargarDoctoresPorArea();
    </script>
<script>
    // Función para redirigir a la página de inicio con el parámetro "id"
    function regresar() {
        // Obtener el valor del parámetro "id" de la URL actual
        const params = new URLSearchParams(window.location.search);
        const idParam = params.get('id');

        // Redirigir a la página de inicio con el parámetro "id"
        if (idParam) {
            window.location.href = "../paginaInicio.html?id=" + idParam;
        } else {
            window.location.href = "../paginaInicio.html";
        }
    }
    </script>
     <script>
        // Obtener la fecha y hora actual
        const fechaActual = new Date();
        const anio = fechaActual.getFullYear();
        const mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0');
        const dia = fechaActual.getDate().toString().padStart(2, '0');
        const hora = fechaActual.getHours().toString().padStart(2, '0');
        const minutos = fechaActual.getMinutes().toString().padStart(2, '0');

        // Formatear la fecha y hora mínima como requerida por el atributo min
        const fechaMinima = `${anio}-${mes}-${dia}T${hora}:${minutos}`;

        // Establecer el valor del atributo min del input de fecha y hora
        document.getElementById('fecha_hora').min = fechaMinima;
    </script>
   
</body>
</html>