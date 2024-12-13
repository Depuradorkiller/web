<?php
include 'conexion.php';
session_start();

// Función para obtener el próximo código disponible para listaventadetallada
function obtenerCodigoVentaDetalle($conn) {
    $sql = "SELECT MAX(cod_listaventadetallada) AS max_cod FROM listaventadetallada";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['max_cod'] != null) {
        $max_cod = $row['max_cod'];
        $num = (int)substr($max_cod, 2);
        $new_num = $num + 1;
        $new_cod = 'ls' . str_pad($new_num, 3, '0', STR_PAD_LEFT);
    } else {
        $new_cod = 'ls001';
    }

    return $new_cod;
}

// Función para enviar correo electrónico de confirmación
function enviarCorreoConfirmacion($correo) {
    $to = $correo;
    $subject = 'Confirmación de Reserva';
    $message = 'Tu reserva ha sido confirmada satisfactoriamente.';
    $headers = 'From: tuemail@example.com' . "\r\n" .
               'Reply-To: tuemail@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    return mail($to, $subject, $message, $headers);
}

// Obtener el código de reserva desde la URL
$cod_listareserva = $_GET['cod_listareserva'] ?? '';

if (!empty($cod_listareserva)) {
    // Obtener datos de la reserva desde listareservas
    $sql_select_reserva = "SELECT * FROM listareservas WHERE cod_listareserva = '$cod_listareserva'";
    $result_select_reserva = mysqli_query($conn, $sql_select_reserva);
    $row_reserva = mysqli_fetch_assoc($result_select_reserva);

    if ($row_reserva) {
        // Obtener datos de la reserva
        $cod_cliente = $row_reserva['cod_cliente'];
        $descripcion = $row_reserva['descripcion'];
        $precio = $row_reserva['precio'];
        $cantidad = $row_reserva['cantidad'];

        // Generar código para listaventadetallada
        $cod_listaventadetallada = obtenerCodigoVentaDetalle($conn);

        // Insertar reserva confirmada en listaventadetallada
        $sql_insert = "INSERT INTO listaventadetallada (cod_listaventadetallada, cod_cliente, descripcion, precio, cantidad)
                       VALUES ('$cod_listaventadetallada', '$cod_cliente', '$descripcion', '$precio', '$cantidad')";

        if (mysqli_query($conn, $sql_insert)) {
            // Eliminar reserva de listareservas
            $sql_delete_reserva = "DELETE FROM listareservas WHERE cod_listareserva = '$cod_listareserva'";
            if (mysqli_query($conn, $sql_delete_reserva)) {
                // Obtener el correo electrónico del cliente
                $sql_get_email = "SELECT gmail FROM clientes WHERE cod_cliente = '$cod_cliente'";
                $result_get_email = mysqli_query($conn, $sql_get_email);
                $row_get_email = mysqli_fetch_assoc($result_get_email);
                $cliente_email = $row_get_email['gmail'];

                // Enviar correo electrónico de confirmación
                if (enviarCorreoConfirmacion($cliente_email)) {
                    $_SESSION['success_message'] = "La reserva ha sido confirmada y se ha enviado un correo electrónico de confirmación.";
                } else {
                    $_SESSION['error_message'] = "La reserva ha sido confirmada, pero hubo un error al enviar el correo electrónico de confirmación.";
                }
            } else {
                $_SESSION['error_message'] = "Error al eliminar la reserva de listareservas: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error_message'] = "Error al insertar la reserva en listaventadetallada: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error_message'] = "No se encontró la reserva con el código proporcionado.";
    }
} else {
    $_SESSION['error_message'] = "No se proporcionó un código de reserva válido.";
}

// Redirigir a la página de lista de reservas
header("Location: solicitudReservas.php");
exit();
?>
