<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('location: bandeja.php');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <title>YMAIL - Servidor de correos</title>
</head>

<body>
    <div id="contenedor">
        <header id="cabecera">
            <div>
                <h1><a href="index.php">YMAIL</a></h1>
                <nav id="menu">
                    <ul>
                        <li><a href="login.php" class="btn btn-green">Login</a></li>
                        <li><a href="signup.php" class="btn btn-blue">Sign Up</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <section id="contenido">
            <h2 class="subtitle">Servidor de correos</h2>
            <img id="banner" src="img/banner1.jpg" alt="banner1">
            <div>
                <p>
                    Registra tu usuario y envía correos a multiples usuarios, accede a tu bandeja de
                    entrada, tus correos enviados y correos eliminados.
                    Podrás crear borradores para enviarlos cuando tu quieras.
                </p>
                <div id="botones-acceso">
                    <a href="login.php" class="btn btn-green">Iniciar Sesión</a>
                    <a href="signup.php" class="btn btn-blue">Registrarse</a>
                </div>
            </div>
        </section>

        <footer id="pie">
            Este sitio web ha sido creado por &copy;AxelDiego
        </footer>
    </div>
</body>

</html>