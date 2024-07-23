<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location: index.php');
    die();
}
$carpeta = 'data/' . $_SESSION['usuario'];
$refarch = fopen($carpeta . '/status.txt', 'r');
fgets($refarch);
$sessionid = trim(fgets($refarch));
fclose($refarch);

if (session_id() != $sessionid) {
    $_SESSION = array();
    header('location: index.php');
    die();
}

$usuario = $_SESSION['usuario'];

if (isset($_GET['borrador'])) {
    $ruta = "data/$usuario/borradores/" . $_GET['borrador'];
    $arch = fopen($ruta, 'r');
    $remitente =  fgets($arch);
    $destinatario = fgets($arch);
    $titulocorreo = fgets($arch);

    $contenido = '';
    $linea = fgets($arch);
    while ($linea) {
        $contenido .= $linea;
        $linea = fgets($arch);
    }

    fclose($arch);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/nuevo.css">
    <script src="js/main.js"></script>
    <title>Nuevo Correo - Usuario</title>
</head>

<body>
    <div id="contenedor">
        <header id="cabecera">
            <div>
                <h1><a href="index.php">YMAIL</a></h1>
                <nav id="menu">
                    <ul>
                        <li id="menu-usuario">@<?= $usuario ?></li>
                        <li><a href="php/logout.php" class="btn btn-red">Log out</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <section id="contenido">
            <div id="caja">
                <form action="php/nuevo.php<?= (isset($_GET['borrador'])) ? '?correo=' . $_GET['borrador'] : '' ?>" method="post">
                    <div id="buttons">
                        <button type="button" class="btn btn-red" onclick="mostrarAnuncio()">Cancelar</button>
                        <button type="reset" class="btn btn-blue">Rehacer</button>
                        <input type="submit" name="modo" class="btn btn-green" value="<?= (isset($_GET['borrador'])) ? 'Editar borrador' : 'Crear borrador' ?>">
                    </div>
                    <label for="usuario">para:</label>
                    <input type="text" name="usuario" autocomplete="off" value="<?= (isset($destinatario) ? $destinatario : '') ?>" required>
                    <label for="titulo">Titulo:</label>
                    <input type="text" name="titulo" autocomplete="off" value="<?= (isset($titulocorreo) ? $titulocorreo : '') ?>" required>
                    <label for="contenido">Contenido</label>
                    <textarea name="contenido" id=""><?= (isset($contenido) ? $contenido : '') ?></textarea>
                    <input type="submit" class="btn btn-green" value="Enviar">
                    <input type="submit" name="datos" class="btn btn-blue" value="Aleatorio">
                </form>
            </div>
        </section>

        <?php if (isset($_GET['err'])) : ?>
            <div id="error">
                <p>
                    <?php
                    switch ($_GET['err']) {
                        case 'mismousuario':
                            echo 'No puede enviarse correos a usted mismo';
                            break;
                        case 'noexiste':
                            echo 'El usuario que desea enviar un correo no existe';
                            break;
                        default:
                            echo 'Ha ocurrido un error';
                            break;
                    }
                    ?>
                </p>
                <div>
                    <button onclick="quitarError()" class="btn btn-red">Cerrar</button>
                </div>
            </div>
        <?php endif; ?>

        <div id="anuncio">
            <p>
                Estas seguro que quieres cancelar
            </p>
            <div>
                <button onclick="quitarAnuncio()" class="btn btn-blue">NO</button>
                <a href="bandeja.php" class="btn btn-red">SI</a>
            </div>
        </div>
    </div>
</body>

</html>