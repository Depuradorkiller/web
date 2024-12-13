<?php
include ('conexion.php');

if (isset($_POST['editar'])) {
    $cod_producto = $_POST['cod_producto'];
    $nom_producto = $_POST['nom_producto'];
    $desc_producto = $_POST['desc_producto'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];

    $sql = "UPDATE productos SET nom_producto='$nom_producto', desc_producto='$desc_producto', stock='$stock', precio='$precio' WHERE cod_producto='$cod_producto'";
    if ($conn->query($sql) === TRUE) {
        header('Location: listaProductos.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['cod_producto'])) {
    $cod_producto = $_GET['cod_producto'];
    $sql = "SELECT * FROM productos WHERE cod_producto='$cod_producto'";
    $result = $conn->query($sql);
    $producto = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Editar Producto</h1>
    <form method="post">
        <input type="hidden" name="cod_producto" value="<?php echo $producto['cod_producto']; ?>">
        <div class="form-group">
            <label for="nom_producto">Nombre del Producto</label>
            <input type="text" class="form-control" id="nom_producto" name="nom_producto" value="<?php echo $producto['nom_producto']; ?>" required>
        </div>
        <div class="form-group">
            <label for="desc_producto">Descripción</label>
            <textarea class="form-control" id="desc_producto" name="desc_producto" required><?php echo $producto['desc_producto']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $producto['stock']; ?>" required>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="editar">Guardar Cambios</button>
        <a href="interfazAdministrador.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>