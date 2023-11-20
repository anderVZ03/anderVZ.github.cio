<?php session_start();?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/inicio.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>



    <script>
        document.addEventListener("DOMContentLoaded", function () {
               
    // Recorre los enlaces y agrega el evento click a cada uno
    navLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault(); // Evita el comportamiento predeterminado del enlace

            // Remueve la clase "active" de todos los enlaces
            navLinks.forEach(link => {
                link.classList.remove("active");
            });

            // Agrega la clase "active" al enlace actual
            this.classList.add("active");
        });
    });
});
            

    

     
        document.addEventListener("DOMContentLoaded", function () {
            const userIcon = document.querySelector(".user-icon");
            const userDropdown = userIcon.querySelector(".user-dropdown");
            const registerModal = document.getElementById("registerModal"); // Agregamos esta línea

            userIcon.addEventListener("click", function () {
                this.classList.toggle("active");
                userDropdown.classList.toggle("show");
            });

            // Cierra el menú desplegable al hacer clic fuera de él
            document.addEventListener("click", function (event) {
                if (!userIcon.contains(event.target)) {
                    userIcon.classList.remove("active");
                    userDropdown.classList.remove("show");
                }
            });

            // Abre el modal de registro al hacer clic en "Registrarse"
            document.getElementById("#registerLink").addEventListener("click", () => {
                registerModal.style.display = "block";
            });
            // Cierra el modal de registro si se hace clic fuera de él
            window.addEventListener("click", (event) => {
                if (event.target === registerModal) {
                    registerModal.style.display = "none";
                }
            });

        });
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("modal");
            const openModalButton = document.getElementById("openModal");
            const closeModalButton = document.getElementById("close");

            openModalButton.addEventListener("click", function () {
                modal.style.display = "block";
            });

            closeModalButton.addEventListener("click", function () {
                modal.style.display = "none";
            });

            window.addEventListener("click", function (event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
            const passwordToggle = document.getElementById("password-toggle");
            const passwordField = document.querySelector(".password-field");

            passwordToggle.addEventListener("click", function () {
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    passwordToggle.innerHTML = '<i class="fas fa-eye"></i>';
                } else {
                    passwordField.type = "password";
                    passwordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
                }

            });
            // JavaScript para abrir el modal de registro
            const openRegisterModalButton = document.getElementById("openRegisterModalButton");
            const closeRegisterModalButton = document.getElementById("closeRegisterModal");

            openRegisterModalButton.addEventListener("click", () => {
                registerModal.style.display = "block";
            });

            closeRegisterModalButton.addEventListener("click", () => {
                registerModal.style.display = "none";
            });

            // Cierra el modal si se hace clic fuera del contenido del modal
            window.addEventListener("click", (event) => {
                if (event.target === registerModal) {
                    registerModal.style.display = "none";
                }
            });

            

        });
        // Script para mostrar/ocultar el enlace "Volver arriba"
const backToTop = document.getElementById("back-to-top");

window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
        backToTop.style.opacity = 1;
    } else {
        backToTop.style.opacity = 0;
    }
});
// Agrega esto en tu archivo JavaScript o dentro de una etiqueta <script> en tu HTML

const menuIcon = document.querySelector('.menu-icon');
const navMenuResponsive = document.querySelector('.nav-menu-responsive');

menuIcon.addEventListener('click', () => {
    navMenuResponsive.classList.toggle('active');
});

    </script>


</head>

<body>
</body>

</html>
