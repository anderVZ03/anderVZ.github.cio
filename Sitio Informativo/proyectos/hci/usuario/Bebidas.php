<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Categoria.css">
    <link href="https://fonts.googleapis.com/css2?family=Nombre+de+la+Fuente&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <?php include'funcions.php'; ?>
    </head>
<?php include'Header.php'; ?>
<body class="paginacategorias"onload="generarCategorias();">
    
    
        <div id="menu-titulo">Bebidas</div>
        <div id="categorias">
            <!-- Categoría 1 -->
            <a href="Bebidas.php" class="menu">
                <img src="ruta_de_la_imagen_de_papas_1.png" alt="Papas">
                <p class="menu-text">Papas 1</p>
                <p class="menu-description">Descripción de las papas 1.</p>
                <p class="menu-price">Precio: $4.99</p>
                <div class="menu-action">
                    <button class="add-to-cart-button" data-producto="papas1">Añadir al carrito</button>
                    <input type="number" class="cantidad-input" min="1" value="1" data-producto="papas1">
                </div>
            </a>

            <!-- Categoría 2 -->
            <a href="Bebidas.php" class="menu">
                <img src="ruta_de_la_imagen_de_papas_2.png" alt="Papas">
                <p class="menu-text">Papas 2</p>
                <p class="menu-description">Descripción de las papas 2.</p>
                <p class="menu-price">Precio: $5.99</p>
                <div class="menu-action">
                    <button class="add-to-cart-button" data-producto="papas2">Añadir al carrito</button>
                    <input type="number" class="cantidad-input" min="1" value="1" data-producto="papas2">
                </div>
            </a>

            <!-- Categoría 3 -->
            <a href="Bebidas.php" class="menu">
                <img src="ruta_de_la_imagen_de_papas_3.png" alt="Papas">
                <p class="menu-text">Papas 3</p>
                <p class="menu-description">Descripción de las papas 3.</p>
                <p class="menu-price">Precio: $6.99</p>
                <div class="menu-action">
                    <button class="add-to-cart-button" data-producto="papas3">Añadir al carrito</button>
                    <input type="number" class="cantidad-input" min="1" value="1" data-producto="papas3">
                </div>
            </a>

            <!-- Categoría 4 -->
            <a href="Bebidas.php" class="menu">
                <img src="ruta_de_la_imagen_de_papas_4.png" alt="Papas">
                <p class="menu-text">Papas 4</p>
                <p class="menu-description">Descripción de las papas 4.</p>
                <p class="menu-price">Precio: $7.99</p>
                <div class="menu-action">
                    <button class="add-to-cart-button" data-producto="papas4">Añadir al carrito</button>
                    <input type="number" class="cantidad-input" min="1" value="1" data-producto="papas4">
                </div>
            </a>

            <!-- Categoría 5 -->
            <a href="Bebidas.php" class="menu">
                <img src="ruta_de_la_imagen_de_papas_5.png" alt="Papas">
                <p class="menu-text">Papas 5</p>
                <p class="menu-description">Descripción de las papas 5.</p>
                <p class="menu-price">Precio: $8.99</p>
                <div class="menu-action">
                    <button class="add-to-cart-button" data-producto="papas5">Añadir al carrito</button>
                    <input type="number" class="cantidad-input" min="1" value="1" data-producto="papas5">
                </div>
            </a>

            <!-- Categoría 6 -->
            <a href="Bebidas.php" class="menu">
                <img src="ruta_de_la_imagen_de_papas_6.png" alt="Papas">
                <p class="menu-text">Papas 6</p>
                <p class="menu-description">Descripción de las papas 6.</p>
                <p class="menu-price">Precio: $9.99</p>
                <div class="menu-action">
                    <button class="add-to-cart-button" data-producto="papas6">Añadir al carrito</button>
                    <input type="number" class="cantidad-input" min="1" value="1" data-producto="papas6">
                </div>
            </a>

        </div>
    </div>

    <script src="javascript/javaCategoria.js"></script>
    
</body>
<?php include 'Footer.php'; ?>
</html>

