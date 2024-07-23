<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/acceso.css">
    <title>Iniciar Sesión</title>
</head>

<body>
    <div id="contenedor">
        <header id="cabecera">
            <div>
                <h1><a href="index.php">YMAIL</a></h1>
                <nav id="menu">
                    <ul>
                        <li><a href="signup.php" class="btn btn-blue">Sign Up</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="caja" id="acceso">
            <h2 class="subtitle">Iniciar Sesión</h2>
            <?php if (isset($_GET['err'])) : ?>
                <span id="error">
                    <?php
                    switch ($_GET['err']) {
                        case 'contraincorrecta':
                            echo 'Contraseña incorrecta';
                            break;
                        case 'noexiste':
                            echo 'No existe el usuario';
                            break;
                        default:
                            echo 'Error en el inicio de sesión';
                            break;
                    }
                    ?>
                </span>
            <?php endif; ?>
            <?php if (isset($_GET['aviso'])) : ?>
                <span id="error">
                    <?php
                    echo 'El usuario ya existe';
                    ?>
                </span>
            <?php endif; ?>
            <form action="php/login.php" method="post">
                <label for="usuario">Usuario</label>
                <input value="<?= (isset($_COOKIE['usuario']) ? $_COOKIE['usuario'] : '') ?>" type="text" name="usuario" id="usuario" autocomplete="off" required>
                <label for="contra">Contraseña</label>
                <input type="password" name="contra" id="contra" value="<?= (isset($_COOKIE['contra']) ? $_COOKIE['contra'] : '') ?>" required>
                <div>
                    <input type="checkbox" name="recordar" <?= (isset($_COOKIE['usuario'])) ? 'checked' : '' ?>>
                    <label for="recordar">¿Desea recordar el usuario?</label>
                </div>
                <input type="submit" value="Login" class="btn btn-green">
            </form>

            <?php if (isset($_COOKIE['usuario'])) : ?>
                <a href="php/eliminarregistro.php" class="btn btn-red">Eliminar registro</a>
            <?php endif; ?>

            <a href="signup.php">¿No tienes un usuario?</a>
        </div>
        <?php if (isset($_SESSION['posible'])) : ?>
            <div id="cambiar" class="caja">
                <h2>Hay una sesión</h2>
                <form action="php/cambiar.php" method="post">
                    <label for="res">¿Desea cerrar la sesión?</label>
                    <input type="submit" name="res" value="No" class="btn btn-red">
                    <button type="submit" name="res" value="<?= $_SESSION['posible'] ?>" class="btn btn-blue">Si</button>
                    <?php if ($_SESSION['recordar'] == 'si') : ?>
                        <input type="hidden" name="recordar">
                    <?php endif; ?>
                </form>
            </div>
        <?php
            unset($_SESSION['posible']);
            unset($_SESSION['recordar']);
        endif;
        ?>
        <footer id="pie">
            Este sitio web ha sido creado por &copy;AxelDiego
        </footer>
    </div>
</body>

</html>