<?php
include('conexion.php');
	$usu = $_POST["usuario"];
	$pass = $_POST["password"];
	$queryusuario = mysqli_query($conn,"SELECT * FROM login WHERE usuario = '$usu' and password = '$pass'");
	$nr=mysqli_num_rows($queryusuario);  
if($nr==1 ){ 
	header('Location: solicitudReservas.php');
}else{
	echo "<script> alert('Usuario o contraseña incorrecto.');window.location= 'login.php' </script>";
}
?>