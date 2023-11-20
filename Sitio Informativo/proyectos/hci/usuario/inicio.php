<?php session_start();?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/Inicio.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    

    <?php include'funcions.php'; ?>
    <title>Página de Inicio</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   




</head>
<?php
session_start();
    include 'Header.php';
?>
<body>

    <section class="hero" id="hero-section">
        <div class="title-container">
            <div class="title-box">
                <h1>URBAN FOORD</h1>
            </div>
            <div class="slogan">
                <p> SABOR DE EXCELENCIA</p>
                <p>EN CADA BOCADO</p>

            </div>
            <div class="menu-button-container">
                <a href="menu.php" class="menu-button">Ver Menú</a>
            </div>
        </div>
    </section>

    <section class="menu-highlights">
        <div class="menu-section-title">MENÚ DESTACADO</div>
        <div class="menu-cards-wrapper">
            
            <div class="menu-cards-container">
            <button class="prev-button"><i class="fas fa-chevron-left"></i></button>
            <?php
                        try{
                            include("../db.php");
                            $sql_producto = "SELECT idProducto, nombre, precio, disponibilidad, descripcion FROM producto WHERE idCategoria =?";
                            $consulta=$conexion->prepare($sql_producto);
                            $idCategoria=6;
                            $consulta->bind_param("i", $idCategoria);
                            $consulta->execute();
                            $resultado = $consulta->get_result();
                            while ($fila = $resultado->fetch_assoc()) {
                                echo "<div class='menu-card'>";
                                echo "<img src='images/Extras/" . $fila['nombre'] . ".png' alt='".$fila['nombre'].">";
                                echo "<p class='menu-text'>" . $fila['nombre'] . "</p>";
                                echo "<p class='menu-description'>" . $fila['descripcion'] . "</p>";
                                echo "<p class='menu-price'> Precio: $" . $fila['precio'] . "</p>";
                               
                                echo "</div>";
                            }
                            $resultado->close();
                            $conexion->close();
                        }catch(Exception $e){
                            echo "Error al cargar".$e;
                        }
                    ?>
                
            <button class="next-button"><i class="fas fa-chevron-right"></i></button>
            
            <!-- Agrega más tarjetas aquí -->
        </div>
        
    </section>
    <section class="restaurant-info">
        <div class="info-container">
            <div class="info-content">
                <h2> URBAN FOOD</h2>
    
            <div class="info-content">
            
                <p>Somos un restaurante comprometido en brindarte experiencias culinarias únicas y deliciosas.</p>
                <p>Nuestra pasión por la gastronomía se refleja en cada plato que servimos.</p>
                <p>Desde nuestros ingredientes frescos hasta nuestro servicio excepcional, todo se une para crear momentos inolvidables.</p>
                <a href="contacto.html" class="contact-button">Contactar</a>
                <div class="social-icons">
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a>
                </div>

            </div>
            <div class="info-images">
                    
                    <img src='/usuario/images/local.jpg' alt="Imagen del restaurante">
                    </div>
        
            </div>
            

    </section>
<script>
    $(document).ready(function () {
        const cardContainer = $(".menu-cards-container");
        const cardWidth = $(".menu-card").outerWidth() + 20;
        const numCards = cardContainer.children(".menu-card").length;
        const numVisibleCards = 3; // Número de tarjetas visibles
        let currentIndex = 0;

        function updateNavigation() {
            $(".menu-card").hide().slice(currentIndex, currentIndex + numVisibleCards).show();
            $(".prev-button").prop("disabled", currentIndex === 0);
            $(".next-button").prop("disabled", currentIndex >= numCards - numVisibleCards);
        }

        $(".prev-button").click(function () {
            if (currentIndex > 0) {
                currentIndex--;
                cardContainer.animate({ scrollLeft: currentIndex * cardWidth }, 500);
                updateNavigation();
            }
        });

        $(".next-button").click(function () {
            if (currentIndex < numCards - numVisibleCards) {
                currentIndex++;
                cardContainer.animate({ scrollLeft: currentIndex * cardWidth }, 500);
                updateNavigation();
            }
        });

        updateNavigation();
    });
    const usernameInput = document.getElementById("username");

usernameInput.addEventListener("input", function () {
    const inputValue = usernameInput.value.toLowerCase();
    const validDomains = ["gmail.com", "hotmail.com"];
    const domainValid = validDomains.some(domain => inputValue.endsWith(domain));

    if (domainValid) {
        // El dominio es válido, puedes realizar acciones adicionales si es necesario.
        usernameInput.classList.remove("invalid");
        usernameInput.classList.add("valid");
    } else {
        // El dominio no es válido.
        usernameInput.classList.remove("valid");
        usernameInput.classList.add("invalid");
    }
});
</script>
</body>
<?php include 'Footer.php'; ?>
</html>