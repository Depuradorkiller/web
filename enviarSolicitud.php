<?php
include 'conexion.php';
session_start();

// Datos del formulario
$nom = $_POST['nombresApellidos'];
$gma = $_POST['gmail'];
$tel = $_POST['telefono'];

// Iniciar transacción para asegurar la integridad de los datos
mysqli_autocommit($conn, false);

try {
    // Verificar si el correo electrónico ya existe en la tabla clientes
    $sql_check_email = "SELECT * FROM clientes WHERE gmail = '$gma'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // El correo electrónico ya existe en la tabla clientes, obtener el código de cliente
        $row = mysqli_fetch_assoc($result_check_email);
        $cod_cliente = $row['cod_cliente'];
    } else {
        // El correo electrónico no existe en la tabla clientes, insertar nuevo cliente y obtener el nuevo código de cliente
        $result = mysqli_query($conn, "SELECT MAX(cod_cliente) AS max_cod FROM clientes");
        $row = mysqli_fetch_assoc($result);

        if ($row['max_cod'] != null) {
            $max_cod = $row['max_cod'];
            $num = (int)substr($max_cod, 1);
            $new_num = $num + 1;
            $new_cod = 'p' . str_pad($new_num, 3, '0', STR_PAD_LEFT);
        } else {
            $new_cod = 'p001';
        }

        // Insertar nuevo cliente
        $sql_insert_client = "INSERT INTO clientes VALUES ('$new_cod', '$nom', '$gma', '$tel')";
        if (!mysqli_query($conn, $sql_insert_client)) {
            throw new Exception("Error al insertar datos del cliente: " . mysqli_error($conn));
        }

        $cod_cliente = $new_cod; // Usar el nuevo código generado
    }

    // Generar el código para cod_listareservas
    $result_cod = mysqli_query($conn, "SELECT MAX(SUBSTRING_INDEX(cod_listareserva, 'v', -1)) AS max_cod FROM listareservas");
    $row_cod = mysqli_fetch_assoc($result_cod);

    if ($row_cod['max_cod'] != null) {
        $max_cod = $row_cod['max_cod'];
        $new_num = (int)$max_cod + 1;
        $cod_listareservas = 'v' . str_pad($new_num, 3, '0', STR_PAD_LEFT);
    } else {
        $cod_listareservas = 'v001';
    }

    // Transferir datos de listareservatemporal a listareservas con fecha actual
    $current_date = date('Y-m-d');  // Formato de fecha actual
    $sql_transfer = "INSERT INTO listareservas (cod_listareserva, fecha, cod_cliente, descripcion, precio, cantidad)
                     SELECT '$cod_listareservas', '$current_date', '$cod_cliente', descripcion, precio, cantidad FROM listareservatemporal";
    
    if (mysqli_query($conn, $sql_transfer)) {
        // Eliminar datos de listareservatemporal después de transferir
        $sql_clear_temp = "DELETE FROM listareservatemporal";
        if (mysqli_query($conn, $sql_clear_temp)) {
            // Commit de la transacción
            mysqli_commit($conn);
            $_SESSION['success_message'] = "Tus reservas se han guardado correctamente.";

            // Redirigir con éxito
            header("Location: reservas.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Error al eliminar datos temporales: " . mysqli_error($conn);
            header("Location: reservas.php");
            exit();
        }
    } else {
        throw new Exception("Error al transferir datos: " . mysqli_error($conn));
    }
} catch (Exception $e) {
    // Rollback en caso de error
    mysqli_rollback($conn);

    // Guardar mensaje de error en sesión y redirigir
    $_SESSION['error_message'] = $e->getMessage();
    header("Location: reservas.php");
    exit();
} finally {
    mysqli_autocommit($conn, true);
    mysqli_close($conn);
}
?>
