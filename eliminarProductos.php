<?php
include ('conexion.php');

if (isset($_GET['cod_producto'])) {
    $cod_producto = $_GET['cod_producto'];
    $sql = "DELETE FROM productos WHERE cod_producto='$cod_producto'";
    if ($conn->query($sql) === TRUE) {
        header('Location: listaProductos.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>