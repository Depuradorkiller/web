<?php
include ('conexion.php');

$search = $_GET['search'] ?? '';
$sql = "SELECT l.cod_listareserva, c.nombres, SUM(l.cantidad) AS total_cantidad, SUM(l.precio * l.cantidad) AS total_precio
        FROM listareservas l
        INNER JOIN clientes c ON l.cod_cliente = c.cod_cliente
        WHERE c.nombres LIKE '%$search%'
        GROUP BY l.cod_listareserva, c.nombres";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4" style="background-color: #ffa8d9">Lista de Reservas</h1>
    <a href="solicitudReservas.php" class="btn btn-success mb-4" style="background-color:#ffa8d9; border-color:#ffa8d9">Solicitudes de Reserva</a>
    <a href="listaProductos.php" class="btn btn-success mb-4" style="background-color:#c57d56; border-color: #c57d56">Lista de Productos</a>
    <a href="listaReservas.php" class="btn btn-success mb-4" style="background-color:#bc4ed8; border-color: #bc4ed8">Lista de Reservas</a>
    <a href="listaVentas.php" class="btn btn-success mb-4" style="background-color:#81c9fa; border-color:#81c9fa">Lista de Ventas</a>
    <form method="get" class="form-inline mb-4">
        <input type="text" name="search" class="form-control mr-2" placeholder="Buscar productos" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Usuario</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['cod_listareserva']; ?></td>
                <td><?php echo $row['nombres']; ?></td>
                <td><?php echo $row['total_cantidad']; ?></td>
                <td><?php echo $row['total_precio']; ?></td>
                <td>
                    <a href="confirmarReserva.php?cod_listareserva=<?php echo $row['cod_listareserva']; ?>" class="btn btn-warning btn-sm" style="background-color:#5ccb5f; border-color: #5ccb5f">Confirmar</a>
                    <a href="cancelarReserva.php?cod_listareserva=<?php echo $row['cod_listareserva']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de cancelar la reserva?');">Cancelar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <center><a href="index.html" class="btn btn-danger btn-sm">Salir</a></center>
    <br><br>
</div>
</body>
</html>

<?php
$conn->close();
?>
