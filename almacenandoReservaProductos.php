<?php
include ('conexion.php');
$cod = $_POST['codigo'];
$fec = date('Y-m-d');
$desc = $_POST['nombre'];
$pre = $_POST['precio'];
$cant = $_POST['cantidad'];
$sto = $_POST['sto'];

$stockP = $sto - $cant;

$sql = "INSERT INTO listareservatemporal VALUES ('$fec','$desc','$pre','$cant')";
$query = mysqli_query($conn, $sql);

$sql = "UPDATE productos SET stock='$stockP' WHERE cod_producto='$cod'";
$query = mysqli_query($conn, $sql);

if ($query) {
    header("Location: productos.php");
}
?>