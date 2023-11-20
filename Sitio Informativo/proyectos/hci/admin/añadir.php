<?php
// Datos de la base de datos
include("../../db.php");

// Obtener las categorías disponibles desde la base de datos
$sql_categorias = "SELECT idCategoria, nombre FROM categoria";
$resultado_categorias = $conexion->query($sql_categorias);
$categorias = array();
while ($fila = $resultado_categorias->fetch_assoc()) {
    $categorias[$fila['idCategoria']] = $fila['nombre'];
}
$resultado_categorias->close();
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Producto</title>
</head>
<body>
    <h2>Agregar Nuevo Producto</h2>
    <form action="../php/guardarProducto.php" method="post" enctype="multipart/form-data">
        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <option value="" disabled selected>Seleccione una categoría</option>
            <?php
            // Generar las opciones de categoría desde el array $categorias
            foreach ($categorias as $idCategoria => $nombreCategoria) {
                echo "<option value=\"$idCategoria\">$nombreCategoria</option>";
            }
            ?>
        </select>
        <br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" id="precio" name="precio" required>
        <br>

        <label for="descripcion">Descripción:</label>   
        <textarea id="descripcion" name="descripcion" required></textarea>
        <br>
        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>
        <br>
        <input type="submit" value="Guardar Producto">
    </form>
</body>
</html>
