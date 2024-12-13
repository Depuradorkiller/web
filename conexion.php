<?php
//mysqli("host","userName","PassWord","dbName")
//$conn=new mysqli("localhost","id22062696_administrador","ABCabc123*","id22062696_gabo2024");
$conn=new mysqli("localhost","root","","mecanicadanny");
if($conn->connect_errno) {
	echo "No hay conexión: (" . $conn->connect_errno . ") " . $conn->connect_error;
}
?>