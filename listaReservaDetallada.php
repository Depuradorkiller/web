<?php
include 'conexion.php';

$search = $_GET['search'] ?? '';
$sql = "SELECT ld.cod_listaventadetallada, c.nombres, SUM(ld.cantidad) AS total_cantidad, SUM(ld.precio * ld.cantidad) AS total_precio
        FROM listaventadetallada ld
        INNER JOIN clientes c ON ld.cod_cliente = c.cod_cliente
        WHERE c.nombres LIKE '%$search%'
        GROUP BY ld.cod_listaventadetallada, c.nombres";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ventas Detallada</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4" style="background-color: #bc4ed8">Lista de Ventas Detallada</h1>
    <a href="solicitudReservas.php" class="btn btn-success mb-4" style="background-color:#ffa8d9; border-color:#ffa8d9">Solicitudes de Reserva</a>
    <a href="listaProductos.php" class="btn btn-success mb-4" style="background-color:#c57d56; border-color: #c57d56">Lista de Productos</a>
    <a href="listaReservas.php" class="btn btn-success mb-4" style="background-color:#bc4ed8; border-color: #bc4ed8">Lista de Reservas</a>
    <a href="listaVentas.php" class="btn btn-success mb-4" style="background-color:#81c9fa; border-color:#81c9fa">Lista de Ventas</a>
    <form method="get" class="form-inline mb-4">
        <input type="text" name="search" class="form-control mr-2" placeholder="Buscar clientes" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Usuario</th>
                <th>Cantidad Total</th>
                <th>Total Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['cod_listaventadetallada']; ?></td>
                <td><?php echo $row['nombres']; ?></td>
                <td><?php echo $row['total_cantidad']; ?></td>
                <td><?php echo $row['total_precio']; ?></td>
                <td>
                    <a href="listaReservaDetallada.php?cod_listaventadetallada=<?php echo $row['cod_listaventadetallada']; ?>" class="btn btn-warning btn-sm">Ver más</a>
                    <a href="finalizandoReserva.php?cod_listaventadetallada=<?php echo $row['cod_listaventadetallada']; ?>" class="btn btn-danger btn-sm">Reserva Finalizada</a>
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
