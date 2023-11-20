function obtenerCategorias() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () { // Cambiar == por =
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("categorias").innerHTML = xhr.responseText;
        }
    };
    xhr.open("GET", "php/consultaCategoria.php", true);
    xhr.send();
}


function beforeRedirect(event) {
    event.preventDefault();
    // Mostrar un mensaje de confirmación al usuario
    var confirmExit = window.confirm("¿Estás seguro de que deseas salir?");
    // Si el usuario confirma (hace clic en "Aceptar"), redirigirlo
    if (confirmExit) {
      // Ejecuta el código PHP en el servidor usando AJAX
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          // La respuesta del servidor (resultado del código PHP) está en xmlhttp.responseText
          console.log(xmlhttp.responseText);
          // Redirige al usuario después de 2 segundos (ejemplo)
          setTimeout(function () {
            window.location.href = event.target.href;
          }, 1000); // 2 segundos de espera antes de la redirección
        }
      };
      xmlhttp.open("GET", "php/salir.php", true);
      xmlhttp.send();
    }
  }
var logoutLink = document.getElementById('logout-link');
logoutLink.addEventListener('click', beforeRedirect);

document.addEventListener("DOMContentLoaded", function() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
          var data = JSON.parse(xhr.responseText);
          if (data.nombre) {
              // Si se obtiene el nombre de usuario, lo mostramos en el span
              document.getElementById("nombre-usuario").textContent =  data.nombre;
          } else if (data.error) {
              // Si hay un error, mostramos un mensaje de error
              document.getElementById("nombre-usuario").textContent = data.error;
          }
      }
  };

  xhr.open("GET", "php/nombreUsuario.php");
  xhr.send();
});

document.querySelectorAll('.add-to-cart-button').forEach(function(button) {
  button.addEventListener('click', function() {
      console.log('Botón de "Añadir al carrito" clicado.'); // Agrega esta línea de prueba
      // Resto de tu código aquí...
  });
});
  
