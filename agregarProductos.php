<?php
include ('conexion.php');

if (isset($_POST['agregar'])) {
    $nom_producto = $_POST['nom_producto'];
    $desc_producto = $_POST['desc_producto'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO productos (nom_producto, desc_producto, stock, precio) VALUES ('$nom_producto', '$desc_producto', '$stock', '$precio')";
    if ($conn->query($sql) === TRUE) {
        header('Location: listaProductos.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Agregar Producto</h1>
    <form method="post">
        <div class="form-group">
            <label for="nom_producto">Nombre del Producto</label>
            <input type="text" class="form-control" id="nom_producto" name="nom_producto" required>
        </div>
        <div class="form-group">
            <label for="desc_producto">Descripción</label>
            <textarea class="form-control" id="desc_producto" name="desc_producto" required></textarea>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" required>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
        </div>
        <button type="submit" class="btn btn-primary" name="agregar">Agregar Producto</button>
        <a href="interfazAdministrador.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>