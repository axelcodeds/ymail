<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/acceso.css">
    <script src="js/main.js"></script>
    <title>Registrarse</title>
</head>

<body>
    <div id="contenedor">
        <header id="cabecera">
            <div>
                <h1><a href="index.php">YMAIL</a></h1>
                <nav id="menu">
                    <ul>
                        <li><a href="login.php" class="btn btn-green">Login</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="caja" id="acceso">
            <h2 class="subtitle">Registrarse</h2>
            <?php if (isset($_GET['err'])) : ?>
                <span id="error">
                    <?php
                    switch ($_GET['err']) {
                        case 'confirmar':
                            echo 'Las contraseñas no coinciden';
                            break;
                        case 'tam':
                            echo 'La contraseña debe tener al menos 6 carácteres';
                            break;
                        case 'invalido':
                            echo 'Usuario invalido';
                            break;
                        default:
                            echo 'Error en el registro';
                            break;
                    }
                    ?>
                </span>
            <?php endif; ?>
            <form action="php/signup.php" method="post">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" autocomplete="off" id="usuario-entrada">
                <label for="contra">Contraseña</label>
                <input type="password" name="contra" id="contra">
                <label for="confirmar">Confirmar contraseña</label>
                <input type="password" name="confirmar" id="confirmar">
                <div>
                    <input type="checkbox" name="recordar">
                    <label for="recordar">¿Desea recordar el usuario?</label>
                </div>
                <input type="submit" value="Sign Up" class="btn btn-blue">
            </form>
            <a href="login.php">¿Ya tienes un usuario?</a>
        </div>

        <footer id="pie">
            Este sitio web ha sido creado por &copy;AxelDiego
        </footer>
    </div>
</body>

</html>