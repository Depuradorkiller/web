<?php
include ('conexion.php');
$sql = "SELECT * FROM servicios";
$query = mysqli_query($conn, $sql);

// Define un arreglo con las rutas de las imágenes
$imagenes = [
    "img/servicios/cambio_aceite.jpg",
    "img/servicios/cambio_llantas.jpg",
    "img/servicios/mantenimiento_frenos.jpg",
    "img/servicios/reparacion_motores.jpg",
    "img/servicios/sistema_electrico.jpg"
    // Agrega más rutas de imágenes según sea necesario
];

// Contador para asociar cada producto con una imagen
$contador = 0;
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
    <link rel="stylesheet" href="css/styleProductos_servicios.css" />
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
                        <a href="servicios.php" class="nav-item nav-link active">Servicios</a>
                        <a href="productos.php" class="nav-item nav-link">Productos</a>
                        <a href="locacion.html" class="nav-item nav-link">Lugares de Atención</a>
                        <a href="contactos.html" class="nav-item nav-link">Contactos</a>
                        <a href="about.html" class="nav-item nav-link">Acerca de</a>
                    </div>
                    <div class="ml-auto">
                        <a class="btn btn-custom" href="reservas.php">Lista de Reservas</a>
                    </div>
                    <div class="ml-auto">
                        <a class="btn btn-custom" href="login.php">Acceder como administrador</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Nav Bar End -->

    <!-- Products Start -->
    <div class="product-container">
        <div class="row" style="width:100%">
            <?php while ($row = mysqli_fetch_array($query)) {
                ?>
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="product-item">
                        <form action="almacenandoReservaServicios.php" method="POST">
                            <!-- Mostrar el nombre del producto -->
                            <input type="hidden" name="codigo" value="<?= $row['cod_servicio']; ?>">
                            <h4><?= $row['nom_servicio']; ?><input type="hidden" name="nombre"
                                    value="<?= $row['nom_servicio']; ?>"></h4>
                            <img src="<?= $imagenes[$contador % count($imagenes)]; ?>" alt="<?= $row['nom_servicio']; ?>"
                                class="img-fluid">
                            <h4>S/. <?= $row['precio']; ?><input type="hidden" name="precio" value="<?= $row['precio']; ?>">
                            </h4>
                            <input type="submit" value="Reservar" class="btn btn-custom" onclick="reservarServicio()">
                            <button type="button" class="btn btn-custom" data-toggle="modal" data-target="#descripcionModal<?= $row['cod_servicio']; ?>">Descripción</button>
                        </form>
                    </div>
                </div>
                
                <!-- Modal -->
                <div class="modal fade" id="descripcionModal<?= $row['cod_servicio']; ?>" tabindex="-1" role="dialog" aria-labelledby="descripcionModalLabel<?= $row['cod_servicio']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="descripcionModalLabel<?= $row['cod_servicio']; ?>"><?= $row['nom_servicio']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="<?= $imagenes[$contador % count($imagenes)]; ?>" alt="<?= $row['nom_servicio']; ?>" class="img-fluid mb-3">
                                <p><?= $row['desc_servicio']; ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                // Incrementa el contador para la siguiente imagen
                $contador++;
            } ?>
        </div>
    </div>

    <script>
        function reservarServicio() {
            alert("Se agrego a la lista de reserva");
        }
    </script>
    <!-- Products End -->

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

</body>

</html>