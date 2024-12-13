<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: white;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 10px;
            background: #f8f9fa;
        }
        .card-body {
            padding: 2rem;
        }
        .form-control {
            border-radius: 30px;
        }
        .btn-custom {
            border-radius: 30px;
            background: #007bff;
            border: none;
            color: white;
        }
        .btn-custom:hover {
            background: #0056b3;
        }
        .btn-exit {
            border-radius: 30px;
            background: #6c757d;
            border: none;
            color: white;
        }
        .btn-exit:hover {
            background: #5a6268;
        }
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4">
            <div class="card-body">
                <div class="form-header">
                    <h2>Iniciar Sesión</h2>
                </div>
                <form action="iniciando.php" method="post">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese su usuario">
                    </div>
                    <div class="form-group">
                        <label for="contraseña">Contraseña</label>
                        <input type="password" class="form-control" id="contraseña" name="password" placeholder="Ingrese su contraseña">
                    </div>
                    <button type="submit" class="btn btn-custom btn-block">Iniciar Sesión</button>
                    <button type="button" class="btn btn-exit btn-block mt-2" onclick="window.location.href='index.html'">Salir</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
