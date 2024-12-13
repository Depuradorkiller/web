<?php
include 'conexion.php';

$search = $_GET['search'] ?? '';
$sql = "SELECT lv.cod_venta, lv.fecha, lv.usuario, lv.cantidad, lv.total 
        FROM listaventa lv
        WHERE lv.usuario LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ventas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4" style="background-color: #81c9fa">Lista de Ventas</h1>
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
                <th>Código</th>
                <th>Usuario</th>
                <th>Cantidad</th>
                <th>Total Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['cod_venta']; ?></td>
                <td><?php echo $row['usuario']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td><?php echo $row['total']; ?></td>
                <td>
                    <a href="listaDetallada.php?cod_producto=<?php echo $row['cod_venta']; ?>" class="btn btn-warning btn-sm">Ver más</a>
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
