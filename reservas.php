<?php
include('conexion.php');
session_start();
$sql = "SELECT * FROM listareservatemporal";
$query = mysqli_query($conn, $sql);

$total_a_pagar = 0;
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Danny Motor's</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free Website Template" name="keywords">
    <meta content="Free Website Template" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="css/styleGeneral.css">
    <link rel="stylesheet" href="css/styleReserva.css" />
</head>

<body>
    <!-- Top Bar Start -->
    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-12">
                    <div class="logo">
                        <a href="index.html">
                            <h1>Danny<span>Motor's</span></h1>
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 d-none d-lg-block">
                    <div class="row">
                        <div class="col-4">
                            <div class="top-bar-item">
                                <div class="top-bar-icon">
                                    <i class="far fa-clock"></i>
                                </div>
                                <div class="top-bar-text">
                                    <h3>Horario de Atención</h3>
                                    <p>Lun - Vie, 8:00 - 12:00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="top-bar-item">
                                <div class="top-bar-icon">
                                    <i class="fa fa-phone-alt"></i>
                                </div>
                                <div class="top-bar-text">
                                    <h3>Llamanos</h3>
                                    <p>964 360 375</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="top-bar-item">
                                <div class="top-bar-icon">
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div class="top-bar-text">
                                    <h3>Email</h3>
                                    <p>info@example.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Bar End -->

    <!-- Nav Bar Start -->
    <div class="nav-bar">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
                <a href="#" class="navbar-brand">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto">
                        <a href="index.html" class="nav-item nav-link">Inicio</a>
                        <a href="servicios.php" class="nav-item nav-link">Servicios</a>
                        <a href="productos.php" class="nav-item nav-link">Productos</a>
                        <a href="locacion.html" class="nav-item nav-link">Lugares de Atención</a>
                        <a href="contactos.html" class="nav-item nav-link">Contactos</a>
                        <a href="about.html" class="nav-item nav-link">Acerca de</a>
                    </div>
                    <div class="ml-auto">
                        <button class="btn btn-custom" data-toggle="modal" data-target="#reservaModal">Reservar</button>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Nav Bar End -->

    <!-- Lista de reservas Start -->
    <div class="product-container">
        <div class="product-header">
            <div style="width:50px"></div>
            <div class="product-name">Producto</div>
            <div style="width:355px"></div>
            <div class="product-price">Precio</div>
            <div style="width:240px"></div>
            <div class="product-quantity">Cantidad</div>
            <div style="width:170px"></div>
            <div class="product-total">Total</div>
            <div class="product-price"></div>
        </div>
        <?php while ($row = mysqli_fetch_array($query)) { ?>
            <div class="product-item">
                <div class="product-details">
                    <div class="product-name"><?= $row['descripcion']; ?></div>
                    <div class="product-price">S/. <?= $row['precio']; ?></div>
                    <div class="product-quantity"><?= $row['cantidad']; ?></div>
                    <?php $total = $row['precio'] * $row['cantidad']; ?>
                    <div class="product-quantity">S/. <?= $total?></div>
                    <div class="product-delete">
                        <form action="sacarProducto.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['descripcion']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">&times;</button>
                        </form>
                    </div>

                </div>
            </div>
            <?php $total_a_pagar += $total; ?>
        <?php } ?>
        <div class="total-payment">
            Total a pagar: S/. <?= $total_a_pagar; ?><br><br>
        </div>
    </div>

    <!-- Modal de Reserva -->
    <div class="modal fade" id="reservaModal" tabindex="-1" role="dialog" aria-labelledby="reservaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reservaModalLabel">Formulario de Reserva</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="enviarSolicitud.php" method="POST">
                        <div class="form-group">
                            <label for="nombres_apellidos">Nombres y Apellidos:</label>
                            <input type="text" class="form-control" id="nombres_apellidos" name="nombresApellidos"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="gmail" required>
                        </div>
                        <div class="form-group">
                            <label for="numero_celular">Número de Celular:</label>
                            <input type="tel" class="form-control" id="numero_celular" name="telefono" required>
                        </div>
                        <button type="submit" class="btn btn-custom" onclick="solicitudRealizado()">Enviar Solicitud</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .product-container {
            width: 100%;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }

        .product-header,
        .product-item {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            margin-bottom: 10px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product-header {
            background: #e9ecef;
            font-weight: bold;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .product-name,
        .product-price,
        .product-quantity,
        .product-total {
            flex: 1;
            text-align: center;
            padding: 5px;
            font-weight: 600;
        }

        .product-name {
            text-align: left;
        }

        .product-price,
        .product-quantity,
        .product-total {
            text-align: right;
        }

        .total-payment {
            text-align: right;
            padding: 20px;
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }

        .product-delete {
            flex: 0.5;
            text-align: center;
        }
    </style>

    <script>
        function solicitudRealizado()
        {
            alert("Se ha enviado su solicitud");
        }
    </script>

    <!-- Footer Start -->
    <div class="footer">
        <div class="container copyright">
            <p>&copy; <a href="#">Danny Motor's</a>, Todos los Derechos Reservados.</a></p>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to top button -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- Pre Loader -->
    <div id="loader" class="show">
        <div class="loader"></div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/productos_servicios.js"></script>
    <script src="js/reservas.js"></script>

</body>

</html>
