<?php
include('conexion.php');
session_start();

// Verificar si se recibió un ID por POST
if(isset($_POST['id'])) {
    // Obtener el ID del producto a eliminar
    $id = $_POST['id'];

    // Consulta SQL para eliminar el producto
    $sql = "DELETE FROM listareservatemporal WHERE descripcion = '$id'";

    // Ejecutar la consulta
    if(mysqli_query($conn, $sql)) {
        // Redirigir de vuelta a productos.php
        header('Location: reservas.php');
        exit;
    } else {
        echo "Error al eliminar el producto: " . mysqli_error($conn);
    }
} else {
    echo "ID de producto no recibido.";
}
?>
