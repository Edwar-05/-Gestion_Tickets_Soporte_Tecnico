<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== 'client') {
    header("location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 80%; padding: 20px; margin: 0 auto; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Área de Cliente</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link">Bienvenido, <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                </li>
                <li class="nav-item">
                    <a href="../logout.php" class="nav-link">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="wrapper">
        <h1 class="my-5">Bienvenido al Panel de Cliente</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Crear Nuevo Ticket</h5>
                        <p class="card-text">¿Necesitas ayuda? Crea un nuevo ticket de soporte.</p>
                        <a href="new_ticket.php" class="btn btn-primary">Nuevo Ticket</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mis Tickets</h5>
                        <p class="card-text">Revisa el estado de tus tickets existentes.</p>
                        <a href="my_tickets.php" class="btn btn-primary">Ver Mis Tickets</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tickets Recientes</h5>
                        <p class="card-text">Aquí puedes ver el estado de tus tickets más recientes.</p>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Asunto</th>
                                        <th>Estado</th>
                                        <th>Fecha de Creación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center">No hay tickets recientes</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
