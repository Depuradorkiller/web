<?php
include 'conexion.php';
session_start();

// Función para enviar correo electrónico de cancelación
function enviarCorreoCancelacion($correo) {
    $to = $correo;
    $subject = 'Cancelación de Reserva';
    $message = 'Lamentamos informarte que tu reserva ha sido cancelada.';
    $headers = 'From: tuemail@example.com' . "\r\n" .
               'Reply-To: tuemail@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    return mail($to, $subject, $message, $headers);
}

// Obtener el código de reserva desde la URL
$cod_listareserva = $_GET['cod_listareserva'] ?? '';

if (!empty($cod_listareserva)) {
    // Realizar la eliminación de la reserva
    $sql_delete = "DELETE FROM listareservas WHERE cod_listareserva = '$cod_listareserva'";
    if (mysqli_query($conn, $sql_delete)) {
        // Obtener el correo electrónico del cliente
        $sql_get_email = "SELECT c.gmail FROM listareservas l 
                          INNER JOIN clientes c ON l.cod_cliente = c.cod_cliente 
                          WHERE l.cod_listareserva = '$cod_listareserva'";
        $result_get_email = mysqli_query($conn, $sql_get_email);
        $row_get_email = mysqli_fetch_assoc($result_get_email);
        $cliente_email = $row_get_email['gmail'];

        // Enviar correo electrónico de cancelación
        if (enviarCorreoCancelacion($cliente_email)) {
            $_SESSION['success_message'] = "La reserva ha sido cancelada y se ha enviado un correo electrónico de cancelación.";
        } else {
            $_SESSION['error_message'] = "La reserva ha sido cancelada, pero hubo un error al enviar el correo electrónico de cancelación.";
        }
    } else {
        $_SESSION['error_message'] = "Error al cancelar la reserva: " . mysqli_error($conn);
    }
} else {
    $_SESSION['error_message'] = "No se proporcionó un código de reserva válido.";
}

// Redirigir a la página de lista de reservas
header("Location: solicitudReservas.php");
exit();
?>
