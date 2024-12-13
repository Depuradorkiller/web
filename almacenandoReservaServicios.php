<?php
include ('conexion.php');
$cod = $_POST['codigo'];
$fec = date('Y-m-d');
$desc = $_POST['nombre'];
$pre = $_POST['precio'];
$cant = 1;

$sql = "INSERT INTO listareservatemporal VALUES ('$fec','$desc','$pre','$cant')";
$query = mysqli_query($conn, $sql);


if ($query) {
    header("Location: servicios.php");
}
?>