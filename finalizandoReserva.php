<?php
include 'conexion.php';
session_start();
$fec = date('Y-m-d');

// Obtener el código de listaventadetallada desde la URL
$cod_listaventadetallada = $_GET['cod_listaventadetallada'] ?? '';

if (!empty($cod_listaventadetallada)) {
    // Obtener datos de la reserva desde listaventadetallada
    $sql_select_reserva = "SELECT * FROM listaventadetallada WHERE cod_listaventadetallada = '$cod_listaventadetallada'";
    $result_select_reserva = mysqli_query($conn, $sql_select_reserva);
    $row_reserva = mysqli_fetch_assoc($result_select_reserva);

    if ($row_reserva) {
        // Obtener datos de la reserva
        $usuario = $row_reserva['usuario']; // Asume que 'usuario' es un campo en listaventadetallada
        $precio = $row_reserva['precio'];
        $cantidad = $row_reserva['cantidad'];
        $total = $precio * $cantidad;

        // Obtener el último código de venta
        $sql_select_last_cod = "SELECT cod_venta FROM listaventa ORDER BY cod_venta DESC LIMIT 1";
        $result_last_cod = mysqli_query($conn, $sql_select_last_cod);
        $row_last_cod = mysqli_fetch_assoc($result_last_cod);
        $last_cod = $row_last_cod['cod_venta'];

        // Generar el nuevo código de venta
        if ($last_cod) {
            $num = (int) substr($last_cod, 1) + 1;
            $new_cod_venta = 'v' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $new_cod_venta = 'v001';
        }

        // Insertar información en listaventa
        $sql_insert_ventas = "INSERT INTO listaventa (cod_venta, fecha, usuario, cantidad, total) VALUES ('$new_cod_venta', '$fec', '$usuario', '$cantidad', '$total')";

        if (mysqli_query($conn, $sql_insert_ventas)) {
            // Eliminar reserva de listaventadetallada
            $sql_delete_reserva = "DELETE FROM listaventadetallada WHERE cod_listaventadetallada = '$cod_listaventadetallada'";
            if (mysqli_query($conn, $sql_delete_reserva)) {
                $_SESSION['success_message'] = "La reserva ha sido finalizada correctamente.";
            } else {
                $_SESSION['error_message'] = "Error al eliminar la reserva de listaventadetallada: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error_message'] = "Error al insertar en listaventa: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error_message'] = "No se encontró la reserva con el código proporcionado.";
    }
} else {
    $_SESSION['error_message'] = "No se proporcionó un código de reserva válido.";
}

// Redirigir a la página de lista de ventas detallada
header("Location: listaReservas.php");
exit();
?>
