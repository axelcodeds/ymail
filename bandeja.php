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

if (isset($_GET['seccion'])) {
    $seccion = $_GET['seccion'];
} else {
    $seccion = 'recibidos';
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bandeja.css">
    <script src="js/main.js"></script>
    <title>Inicio - Usuario</title>
</head>

<body>
    <div id="contenedor">
        <header id="cabecera">
            <div>
                <h1><a href="index.php">YMAIL</a></h1>
                <nav id="menu">
                    <ul>
                        <li onclick="mostrarEliminar()" id="menu-usuario">@<?= $usuario ?></li>
                        <li><a href="php/logout.php" class="btn btn-red">Log out</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <section id="contenido">
            <aside id="lateral">
                <div id="secciones">
                    <a class="seccion <?= ($seccion == 'recibidos') ? 'seleccionado' : '' ?>" href="bandeja.php?seccion=recibidos">Bandeja de entrada</a>
                    <a class="seccion <?= ($seccion == 'enviados') ? 'seleccionado' : '' ?>" href="bandeja.php?seccion=enviados">Correos enviados</a>
                    <a class="seccion <?= ($seccion == 'eliminados') ? 'seleccionado' : '' ?>" href="bandeja.php?seccion=eliminados">Correos eliminados</a>
                    <a class="seccion <?= ($seccion == 'borradores') ? 'seleccionado' : '' ?>" href="bandeja.php?seccion=borradores">borradores</a>
                </div>
                <div id="correos">
                    <?php
                    $directory = "data/$usuario/$seccion";

                    if (file_exists($directory)) {

                        $files = scandir($directory);

                        foreach ($files as $file) {
                            if ($file !== '.' && $file !== '..') {
                                $arch = fopen($directory . '/' . $file, 'r+');
                                $remitente = fgets($arch);
                                $destinatario = fgets($arch);
                                $titulo = fgets($arch);
                                $contenido = fgets($arch);
                                echo "
                                <a href='bandeja.php?seccion=$seccion&correo=$file' class='correo'><span class='correo-titulo'>$titulo</span>
                                <span class='correo-usuario'>$remitente - $destinatario</span>
                                <p class='correo-contenido'>$contenido</p>
                                </a>     
                                ";
                                fclose($arch);
                            }
                        }
                    }
                    ?>
                </div>
            </aside>
            <div id="vista">
                <div id="vista-cabecera">
                    <?php
                    if (isset($_GET['correo']) and file_exists('data/' . $usuario . "/$seccion/" . $_GET['correo'])) {
                        $ruta = 'data/' . $usuario . "/$seccion/" . $_GET['correo'];
                        $arch = fopen($ruta, 'r');
                        $remitente =  fgets($arch);
                        $destinatario = fgets($arch);
                        $titulocorreo = fgets($arch);
                    }
                    ?>

                    <h3><?= (isset($titulocorreo)) ? $titulocorreo : 'Sin seleccionar' ?></h3>
                    <div id="vista-botones">
                        <a href="nuevo.php" class="btn btn-blue">Nuevo Correo</a>
                        <?php if (isset($_GET['correo'])) : ?>
                            <a href="php/eliminarcorreo.php?seccion=<?= $seccion ?>&correo=<?= $_GET['correo'] ?>" class="btn btn-red">
                                Eliminar
                            </a>
                        <?php endif; ?>
                        <?php if ($seccion == 'borradores' and isset($_GET['correo'])) : ?>
                            <a href="nuevo.php?borrador=<?= $_GET['correo'] ?>" class="btn btn-green">
                                Usar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div id="vista-correo">
                    <?php
                    if (isset($ruta)) {

                        echo '<div id="vista-usuarios">';
                        echo "<p>Remitente: <span>$remitente</span></p>";
                        echo "<p>Destinatario: <span>$destinatario</span></p>";
                        echo '</div>';

                        echo '<div id="vista-contenido"><p>';
                        $linea = fgets($arch);
                        while ($linea) {
                            echo $linea . '<br>';
                            $linea = fgets($arch);
                        }
                        echo '</p></div>';

                        fclose($arch);
                    }
                    ?>
                </div>
            </div>

        </section>

        <div id="eliminar-usuario">
            <p>
                ¿Desea eliminar su usuario?
            </p>
            <div>
                <button onclick="quitarEliminar()" class="btn btn-blue">NO</button>
                <a href="php/eliminarusuario.php" class="btn btn-red">SI</a>
            </div>
        </div>
    </div>
</body>

</html>