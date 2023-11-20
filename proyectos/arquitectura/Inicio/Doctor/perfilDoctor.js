document.addEventListener('DOMContentLoaded', function () {
    // Función para obtener y mostrar el perfil del doctor
    function mostrarPerfilDoctor() {
      // Hacemos la solicitud AJAX al archivo PHP para obtener los datos del perfil del doctor
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            // Convertimos la respuesta JSON a un objeto JavaScript
            const perfilDoctor = JSON.parse(xhr.responseText);
  
            // Actualizamos los elementos HTML con la información del perfil del doctor
            document.getElementById('nombreDoctor').textContent = `${perfilDoctor.nombre} ${perfilDoctor.apellidoPaterno} ${perfilDoctor.apellidoMaterno}`;
            document.getElementById('especialidad').textContent = "Especialidad:"+ perfilDoctor.especialidad ;
            document.getElementById('area').textContent = `Área: Medicina`;
            document.getElementById('correo').textContent =  perfilDoctor.correo;
          document.getElementById('nacimiento').textContent =  perfilDoctor.fechaNacimiento;
            
            // Si tienes la foto del doctor en la respuesta, puedes actualizar la imagen de perfil
            // document.getElementById('fotoPerfil').src = perfilDoctor.foto;
  
          } else {
            alert('Error al obtener los datos del perfil del doctor');
          }
        }
      };
  
      xhr.open('GET', 'perfilDoctor.php?accion=perfil', true);
      xhr.send();
    }
  
    // Llamamos a la función para mostrar el perfil del doctor al cargar la página
    mostrarPerfilDoctor();
  });
  